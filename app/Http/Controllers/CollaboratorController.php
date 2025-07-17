<?php

namespace App\Http\Controllers;

use App\Models\Collaborator;
use App\Models\Unit; // Importar o model de Unidade
use App\Http\Requests\StoreCollaboratorRequest;

class CollaboratorController extends Controller
{
    public function index()
    {
        // Carregamos o relacionamento com a Unidade para otimizar as queries
        $collaborators = Collaborator::with('unit')->latest()->paginate(10);
        return view('collaborators.index', compact('collaborators'));
    }

    public function create()
    {
        // Buscamos todas as unidades para popular o <select>
        $units = Unit::orderBy('trading_name')->get();
        return view('collaborators.create', compact('units'));
    }

    public function store(StoreCollaboratorRequest $request)
    {
        Collaborator::create($request->validated());
        return redirect()->route('collaborators.index')->with('success', 'Colaborador criado com sucesso!');
    }

    public function edit(Collaborator $collaborator)
    {
        // Para editar, precisamos do colaborador e da lista de todas as unidades
        $units = Unit::orderBy('trading_name')->get();
        return view('collaborators.edit', compact('collaborator', 'units'));
    }

    public function update(StoreCollaboratorRequest $request, Collaborator $collaborator)
    {
        $collaborator->update($request->validated());
        return redirect()->route('collaborators.index')->with('success', 'Colaborador atualizado com sucesso!');
    }

    public function destroy(Collaborator $collaborator)
    {
        $collaborator->delete();
        return redirect()->route('collaborators.index')->with('success', 'Colaborador deletado com sucesso!');
    }
}
