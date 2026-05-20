<?php

namespace App\Http\Controllers;

use App\Http\Requests\HabitRequest;
use App\Models\Habit;
use Illuminate\View\View;

class HabitController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(HabitRequest $request)
    {
        $validated = $request->validated();

        auth()->user()->habits()->create($validated);

        return redirect()
            ->route('site.dashboard')
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
        if ($habit->user_id != auth()->user()->id) {
            abort(403, 'Esse hábito não é seu!');
        }

        $habit->update($request->all());

        return redirect()
            ->route('site.dashboard')
            ->with('success', 'Hábito atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Habit $habit)
    {
        // Caso o usuário esteja deletando um hábito de outro usuário apresente esse erro.
        if ($habit->user_id != auth()->user()->id) {
            abort(403, 'Esse hábito não é seu!');
        }

        $habit->delete();
        // Caso dê tudo certo redireciona ele para o dashboard.
        return redirect()
            ->route('site.dashboard')
            ->with('success', 'Hábito removido com sucesso!');
    }
}
