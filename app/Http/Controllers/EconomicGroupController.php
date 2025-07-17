<?php

namespace App\Http\Controllers;

use App\Models\EconomicGroup;
use App\Http\Requests\StoreEconomicGroupRequest; // NOSSA VALIDAÇÃO
use Illuminate\Http\Request;

class EconomicGroupController extends Controller
{
    // Listar todos os grupos
    public function index()
    {
        $economicGroups = EconomicGroup::latest()->paginate(10); // Busca os mais recentes, 10 por página
        return view('economic-groups.index', compact('economicGroups'));
    }

    // Mostrar o formulário de criação
    public function create()
    {
        return view('economic-groups.create');
    }

    // Salvar o novo grupo no banco
    public function store(StoreEconomicGroupRequest $request)
    {
        EconomicGroup::create($request->validated()); // Pega os dados validados e cria
        return redirect()->route('economic-groups.index')->with('success', 'Grupo Econômico criado com sucesso!');
    }

    // Mostrar o formulário de edição com os dados do grupo
    public function edit(EconomicGroup $economicGroup) // O Laravel já busca o grupo pelo ID da URL
    {
        return view('economic-groups.edit', compact('economicGroup'));
    }

    // Atualizar o grupo no banco
    public function update(StoreEconomicGroupRequest $request, EconomicGroup $economicGroup)
    {
        $economicGroup->update($request->validated());
        return redirect()->route('economic-groups.index')->with('success', 'Grupo Econômico atualizado com sucesso!');
    }

    // Deletar o grupo do banco
    public function destroy(EconomicGroup $economicGroup)
    {
        // Lembre-se: configuramos onDelete('restrict'). Se o grupo tiver bandeiras, isso dará erro.
        // Uma implementação mais robusta trataria esse erro com um try-catch.
        $economicGroup->delete();
        return redirect()->route('economic-groups.index')->with('success', 'Grupo Econômico deletado com sucesso!');
    }
}
