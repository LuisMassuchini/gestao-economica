<?php

namespace App\Exports;

use App\Models\ExportedReport;
use App\Models\Collaborator;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class CollaboratorsExport implements FromQuery, WithHeadings, WithMapping, ShouldQueue, WithEvents
{
    protected $filters;
    protected $reportId;



     public function __construct(array $filters, int $reportId)
    {
        $this->filters = $filters;
        $this->reportId = $reportId;
    }

    // 2. Define os cabeçalhos das colunas
    public function headings(): array
    {
        return [
            'ID',
            'Nome',
            'Email',
            'CPF',
            'Unidade',
            'Bandeira',
            'Grupo Econômico',
            'Data de Criação',
        ];
    }

    // 3. Mapeia os dados de cada linha
    public function map($collaborator): array
    {
        return [
            $collaborator->id,
            $collaborator->name,
            $collaborator->email,
            $collaborator->cpf,
            $collaborator->unit->trading_name,
            $collaborator->unit->flag->name,
            $collaborator->unit->flag->economicGroup->name,
            $collaborator->created_at->format('d/m/Y H:i:s'),
        ];
    }

    // 4. Constrói a query com base nos filtros recebidos
    public function query()
    {
        $query = Collaborator::query()->with(['unit.flag.economicGroup']);

        if (!empty($this->filters['economic_group_id'])) {
            $query->whereHas('unit.flag', function ($q) {
                $q->where('economic_group_id', $this->filters['economic_group_id']);
            });
        }

        if (!empty($this->filters['flag_id'])) {
            $query->whereHas('unit', function ($q) {
                $q->where('flag_id', $this->filters['flag_id']);
            });
        }

        if (!empty($this->filters['unit_id'])) {
            $query->where('unit_id', $this->filters['unit_id']);
        }

        return $query;
    }

    public function registerEvents(): array
    {
        return [
            // Este evento é acionado depois de a folha de cálculo ser criada e guardada.
            AfterSheet::class => function(AfterSheet $event) {
                $report = ExportedReport::find($this->reportId);
                if ($report) {
                    $report->update(['status' => 'completed']);
                }
            },
        ];
    }
}
