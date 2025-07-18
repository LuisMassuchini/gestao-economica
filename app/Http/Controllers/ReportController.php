<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\CollaboratorsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Collaborator;
use App\Models\EconomicGroup;
use App\Models\Flag;
use App\Models\Unit;
use App\Models\ExportedReport;
use Illuminate\Support\Facades\Auth;


class ReportController extends Controller
{
    public function collaborators(Request $request)
    {
        // Começamos a query com os relacionamentos que vamos precisar
        $query = Collaborator::with(['unit.flag.economicGroup']);

        // Filtro por Grupo Econômico
        if ($request->filled('economic_group_id')) {
            $query->whereHas('unit.flag', function ($q) use ($request) {
                $q->where('economic_group_id', $request->economic_group_id);
            });
        }

        // Filtro por Bandeira
        if ($request->filled('flag_id')) {
            $query->whereHas('unit', function ($q) use ($request) {
                $q->where('flag_id', $request->flag_id);
            });
        }

        // Filtro por Unidade
        if ($request->filled('unit_id')) {
            $query->where('unit_id', $request->unit_id);
        }

        // Executamos a query e paginamos os resultados
        $collaborators = $query->latest()->paginate(15)->withQueryString();

        // Buscamos os dados para popular os filtros
        $economicGroups = EconomicGroup::orderBy('name')->get();
        $flags = Flag::orderBy('name')->get();
        $units = Unit::orderBy('trading_name')->get();

        return view('reports.collaborators.index', compact(
            'collaborators',
            'economicGroups',
            'flags',
            'units'
        ));
    }
    public function exportCollaborators(Request $request)
    {
        // 1. Criar o registo na base de dados primeiro
        $report = ExportedReport::create([
            'user_id' => auth()->id(),
            'file_path' => '', // Deixamos o caminho vazio por agora
            'status' => 'pending',
        ]);

        // Usamos o ID do relatório para garantir um nome de ficheiro único
        $fileName = 'reports/collaborators_' . $report->id . '.xlsx';

        // Atualizamos o registo com o caminho final do ficheiro
        $report->update(['file_path' => $fileName]);

        // 2. A CORREÇÃO CRUCIAL ESTÁ AQUI:
        // Garantir que estamos a passar o $report->id como segundo argumento.
        Excel::queue(new CollaboratorsExport($request->all(), $report->id), $fileName);

        return redirect()->route('my-reports.index')->with('success', 'O seu relatório foi enviado para processamento! Esta página será atualizada automaticamente.');
    }
}
