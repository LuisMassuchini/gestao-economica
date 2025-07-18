<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use Illuminate\Http\Request;
use App\Models\Flag;
use App\Http\Requests\StoreUnitRequest;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $units = Unit::with('flag')->latest()->paginate(10);
        return view('units.index', compact('units'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        // Buscamos todas as bandeiras para popular o <select>
        $flags = Flag::orderBy('name')->get();
        return view('units.create', compact('flags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUnitRequest $request) // <-- A solução está aqui
    {
        Unit::create($request->validated());
        return redirect()->route('units.index')->with('success', 'Unidade criada com sucesso!');
    }


    /**
     * Display the specified resource.
     */
    public function show(Unit $unit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreUnitRequest $request, Unit $unit) 
{
    $unit->update($request->validated());
    return redirect()->route('units.index')->with('success', 'Unidade atualizada com sucesso!');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('units.index')->with('success', 'Unidade deletada com sucesso!');
    }
}
