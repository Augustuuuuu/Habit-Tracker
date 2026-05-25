<?php

namespace App\Http\Controllers;

use App\Http\Requests\HabitRequest;
use App\Models\Habit;
use App\Models\HabitLog;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HabitController extends Controller
{
    use AuthorizesRequests;

    public function index(): View
    {
        $habits = Auth::user()->habits()
            ->with('habitLogs')
            ->get();

        return view('dashboard', compact('habits'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(HabitRequest $request)
    {
        $validated = $request->validated();

        Auth::user()->habits()->create($validated);

        return redirect()
            ->route('habits.index')
            ->with('success', 'Hábito criado com sucesso!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('habits.create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Habit $habit)
    {
        $this->authorize('update', $habit);
        return view('habits.edit', compact('habit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HabitRequest $request, Habit $habit)
    {
        $this->authorize('update', $habit);
        $habit->update($request->all());

        return redirect()
            ->route('habits.index')
            ->with('success', 'Hábito atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Habit $habit)
    {
        $this->authorize('delete', $habit);

        $habit->delete();
        // Caso dê tudo certo redireciona ele para o dashboard.
        return redirect()
            ->route('habits.index')
            ->with('warning', 'Hábito removido com sucesso!');
    }

    public function settings(): View
    {
        $habits = Auth::user()->habits;
        return view('settings', compact('habits'));
    }

    public function toggle(Habit $habit)
    {
        $this->authorize('toggle', $habit);
        $userId = Auth::id();
        $today = Carbon::today()->toDateString();

        $deleted = HabitLog::query()
            ->where('user_id', $userId)
            ->where('habit_id', $habit->id)
            ->where('completed_at', $today)
            ->delete();
        if ($deleted > 0) {
            $alert = 'warning';
            $message = 'Hábito desmarcado com sucesso!';
        } else {
            HabitLog::query()->createOrFirst([
                'user_id' => $userId,
                'habit_id' => $habit->id,
                'completed_at' => $today
            ]);

            $message = 'Hábito concluído!';
            $alert = 'success';
        }
        return redirect()
            ->back()
            ->with($alert, $message);
    }

    public function history(?int $year = null): View
    {
        $currentYear = now()->year;
        $selectedYear = $year ?? $currentYear;
        $avaiableYears = $this->availableHistoryYears($currentYear);

        if (!in_array($selectedYear, $avaiableYears)) {
            abort(404, 'Ano inválido!');
        }

        $startYear = Carbon::create($selectedYear, 1, 1);
        $endYear = Carbon::create($selectedYear, 12, 31, 23, 59, 59);

        $habits = Auth::user()->habits()
            ->with(['habitLogs' => function ($query) use ($startYear, $endYear) {
                $query->whereBetween('completed_at', [$startYear, $endYear]);
            }])
            ->get();

        return view('habits.history', compact('habits', 'selectedYear', 'avaiableYears'));
    }

    private function availableHistoryYears(int $currentYear): array
    {
        $firstYear = HabitLog::query()
            ->where('user_id', Auth::id())
            ->selectRaw('YEAR(MIN(completed_at)) as year')
            ->value('year') ?? $currentYear;

        return range($firstYear, $currentYear);
    }
}
