<?php

namespace App\Http\Controllers;

use App\Http\Requests\HabitRequest;
use App\Models\Habit;
use App\Models\HabitLog;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HabitController extends Controller
{

    public function index(): View
    {
        $habits = Auth::user()->habits()
            ->with('habitLogs')
            ->get();

        return view('/dashboard', compact('habits'));
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
        return view('habits.edit', compact('habit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(HabitRequest $request, Habit $habit)
    {
        if ($habit->user_id != Auth::user()->id) {
            abort(403, 'Esse hábito não é seu!');
        }

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
        // Caso o usuário esteja deletando um hábito de outro usuário apresente esse erro.
        if ($habit->user_id != Auth::user()->id) {
            abort(403, 'Esse hábito não é seu!');
        }

        $habit->delete();
        // Caso dê tudo certo redireciona ele para o dashboard.
        return redirect()
            ->route('habits.index')
            ->with('success', 'Hábito removido com sucesso!');
    }

    public function settings(): View
    {
        $habits = Auth::user()->habits;
        return view('settings', compact('habits'));
    }

    public function toggle(Habit $habit)
    {
        //1. Verificar usuário autenticado é dono do hábito
        if ($habit->user_id != Auth::user()->id) {
            abort(403, 'Esse hábito não é seu!');
        }
        //2. Pegar a data de hoje
        $today = Carbon::today()->toDateString();

        //2.1 Pegar o log
        $log = HabitLog::query()
            ->where('habit_id', $habit->id)
            ->where('completed_at', $today)
            ->first();
        //3.  Validar se nessa data já existe um registro
        if ($log) {
            //4. Se existir, removar o registro
            $log->delete();
            $message = 'Hábito desmarcado com sucesso!';
        } else {
            //5. Se não existir, criar o registro
            HabitLog::create([
                'user_id' => Auth::user()->id,
                'habit_id' => $habit->id,
                'completed_at' => $today
            ]);
            $message = 'Hábito concluído!';
        }


        //6. Retornar para a página anterior
        return redirect()
            ->route('habits.index')
            ->with('success', $message);
    }
}
