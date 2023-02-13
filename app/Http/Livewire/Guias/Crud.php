<?php

namespace App\Http\Livewire\Guias;

use Livewire\Component;
use App\Models\Guias;
use App\Models\Clientes;
use App\Models\DomiciliosE;
use Carbon\Carbon;
use Livewire\WithPagination;

class Crud extends Component
{
    use WithPagination;

    public $id_externo, $id_cliente, $id_domicilio, $estatus_entrega = 'Pendiente', $guia_prepago, $guiaStatus = false, $status = 'created', $editStatus = false, $guiaFound, $search = "", $domiciliosFound = [], $idGuia;

    public $query = '', $clientesBuscados = [], $clienteBarraBuscadora = null;

    public function mount()
    {
        $this->resetear();
    }

    public function resetear()
    {
        $this->query = '';
        $this->clientesBuscados = [];
    }

    public function selectContact($pos)
    {
        $this->clienteBarraBuscadora = $this->clientesBuscados[$pos] ?? null;
        if ($this->clienteBarraBuscadora) {
            $this->clienteBarraBuscadora;
            $this->domiciliosFound = DomiciliosE::where('cliente_id', $this->clienteBarraBuscadora['id'])->get();
            $this->resetear();
        }
    }

    public function updatedQuery()
    {
        if ($this->query != '') {
            $this->clientesBuscados = Clientes::where('nombre', 'like', '%' . $this->query . '%')
                ->limit(6)
                ->get()
                ->toArray();
        }
    }

    public function store()
    {
        $this->editStatus = false;

        if ($this->id_domicilio == '') {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => '¡Todos los campos son requeridos!'
            ]);
        } else {
            Guias::create([
                'id_externo' => $this->id_externo,
                'id_cliente' => $this->clienteBarraBuscadora['id'],
                'id_domicilio' => $this->id_domicilio,
                'estatus_entrega' => 'Pendiente',
                'guia_prepago' => $this->guia_prepago,
                'fecha_captura' => Carbon::now()->format('d/m/Y'),
                'status' => 'activo',
            ]);

            $this->status = 'created';
            $this->toast($this->status);
            $this->dispatchBrowserEvent('close-modal');
            $this->resetInputs();
        }
    }

    public function update()
    {
        $this->editStatus = true;

        $guiasFound = Guias::find($this->idGuia);
        $guiasFound->update([
            'id_externo' => $this->id_externo,
            'id_cliente' => $this->clienteBarraBuscadora['id'],
            'id_domicilio' => $this->id_domicilio,
            'estatus_entrega' => 'Pendiente',
            'guia_prepago' => $this->guia_prepago,
        ]);

        $this->status = 'updated';
        $this->toast($this->status);
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
    }

    public function edit($id)
    {
        $this->idGuia = $id;
        $this->editStatus = true;
        $guiaFound = Guias::find($id);
        $this->id_externo = $guiaFound->id_externo;
        $this->clienteBarraBuscadora = Clientes::find($guiaFound->id_cliente);
        $guiaFound->guia_prepago != '' ? $this->guiaStatus = true : $this->guiaStatus = false;
        $this->guiaStatus == true ? $this->guia_prepago = $guiaFound->guia_prepago : $this->guia_prepago = '';

        $this->domiciliosFound = DomiciliosE::where('cliente_id', $this->clienteBarraBuscadora['id'])->get();
    }

    public function delete($id)
    {
        $guiaFound = Guias::find($id);
        $guiaFound->update([
            'status' => 'inactivo',
        ]);

        $this->status = 'error';
        $this->dispatchBrowserEvent('alert', [
            'message' => '¡Guía eliminada correctamente!'
        ]);
    }

    public function resetInputs()
    {
        $this->editStatus = false;
        $this->id_externo = '';
        $this->id_cliente = '';
        $this->id_domicilio = '';
        $this->estatus_entrega = '';
        $this->guia_prepago = '';
        $this->guiaStatus = false;
        $this->clienteBarraBuscadora = null;
        $this->domiciliosFound = [];
    }

    public function toast($status)
    {
        $this->status = $status;
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Guía creada correctamente!' : '¡Guía actualizada correctamente!'
        ]);
    }

    public function render()
    {
        if ($this->search != '') {
            $guia = Guias::where('estatus_entrega', $this->search)
                ->where('status', 'activo')
                ->orWhere('id_cliente', $this->search)
                ->orWhere('id_externo', $this->search)
                ->paginate(10);
        } else {
            $guia = Guias::where('status', 'activo')->paginate(10);
        }

        return view('livewire.guias.crud', [
            'guias' => $guia
        ]);
    }
}
