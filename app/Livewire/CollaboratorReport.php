<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Collaborator;
use App\Models\EconomicGroup;
use App\Models\Flag;
use App\Models\Unit;

class CollaboratorReport extends Component
{
    use WithPagination;

    // Propriedades para os valores dos filtros
    public $economicGroupId = '';
    public $flagId = '';
    public $unitId = '';

    // Propriedades para as opções dos dropdowns
    public $economicGroups;
    public $flags = [];
    public $units = [];

    // Método 'mount' é executado quando o componente é inicializado (como um construtor)
    public function mount()
    {
        $this->economicGroups = EconomicGroup::orderBy('name')->get();
    }

    // Este método é acionado sempre que a propriedade 'economicGroupId' é atualizada
    public function updatedEconomicGroupId($value)
    {
        // Se um grupo for selecionado, busca as bandeiras correspondentes
        if ($value) {
            $this->flags = Flag::where('economic_group_id', $value)->orderBy('name')->get();
        } else {
            $this->flags = [];
        }
        // Reseta os filtros dependentes
        $this->reset(['flagId', 'unitId']);
        $this->units = [];
    }

    // Este método é acionado sempre que a propriedade 'flagId' é atualizada
    public function updatedFlagId($value)
    {
        // Se uma bandeira for selecionada, busca as unidades correspondentes
        if ($value) {
            $this->units = Unit::where('flag_id', $value)->orderBy('trading_name')->get();
        } else {
            $this->units = [];
        }
        // Reseta o filtro dependente
        $this->reset('unitId');
    }

    // Método 'render' é responsável por renderizar a vista do componente
    public function render()
    {
        $query = Collaborator::with(['unit.flag.economicGroup']);

        if ($this->economicGroupId) {
            $query->whereHas('unit.flag', function ($q) {
                $q->where('economic_group_id', $this->economicGroupId);
            });
        }

        if ($this->flagId) {
            $query->whereHas('unit', function ($q) {
                $q->where('flag_id', $this->flagId);
            });
        }

        if ($this->unitId) {
            $query->where('unit_id', $this->unitId);
        }

        return view('livewire.collaborator-report', [
            'collaborators' => $query->latest()->paginate(10)
        ]);
    }
}
