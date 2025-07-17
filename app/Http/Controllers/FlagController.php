<?php

namespace App\Http\Controllers;

use App\Models\Flag;
use App\Models\EconomicGroup; // Importar o model de Grupo Econômico
use App\Http\Requests\StoreFlagRequest; // Importar nossa validação

class FlagController extends Controller
{
    public function index()
    {
        // Usamos with('economicGroup') para carregar o relacionamento (Eager Loading).
        // Isso evita múltiplas queries ao banco e melhora a performance.
        $flags = Flag::with('economicGroup')->latest()->paginate(10);
        return view('flags.index', compact('flags'));
    }

    public function create()
    {
        // Precisamos buscar todos os grupos para popular o <select> no formulário.
        $economicGroups = EconomicGroup::orderBy('name')->get();
        return view('flags.create', compact('economicGroups'));
    }

    public function store(StoreFlagRequest $request)
    {
        Flag::create($request->validated());
        return redirect()->route('flags.index')->with('success', 'Bandeira criada com sucesso!');
    }

    public function edit(Flag $flag)
    {
        // Para a edição, precisamos da bandeira específica E da lista de todos os grupos.
        $economicGroups = EconomicGroup::orderBy('name')->get();
        return view('flags.edit', compact('flag', 'economicGroups'));
    }

    public function update(StoreFlagRequest $request, Flag $flag)
    {
        $flag->update($request->validated());
        return redirect()->route('flags.index')->with('success', 'Bandeira atualizada com sucesso!');
    }

    public function destroy(Flag $flag)
    {
        $flag->delete();
        return redirect()->route('flags.index')->with('success', 'Bandeira deletada com sucesso!');
    }
}
