<?php

namespace App\Http\Livewire\Bitacora;

use Livewire\Component;
use App\Models\Guias;
use Livewire\WithPagination;

class View extends Component
{
    use WithPagination;

    public $search = '';

    public function render()
    {
        if ($this->search) {
            $guias = Guias::join('domicilio_entregar', 'domicilio_entregar.id', 'guias.id_domicilio')
                ->join('clientes', 'clientes.id', 'guias.id_cliente')
                ->where('domicilio_entregar.cp', $this->search)
                ->select('guias.*', 'domicilio_entregar.cp', 'domicilio_entregar.domicilio', 'clientes.nombre')
                ->paginate(10);
        } else {
            $guias = Guias::join('domicilio_entregar', 'domicilio_entregar.id', 'guias.id_domicilio')
                ->join('clientes', 'clientes.id', 'guias.id_cliente')
                ->select('guias.*', 'domicilio_entregar.cp', 'domicilio_entregar.domicilio', 'clientes.nombre')
                ->paginate(10);
        }

        return view('livewire.bitacora.view', compact('guias'));
    }
}
