<?php

namespace App\Http\Livewire\Domicilios;

use Livewire\Component;
use App\Models\DomiciliosE;
use App\Models\Clientes;
use App\Models\Bitacora;
use Carbon\Carbon;
use Livewire\WithPagination;

class Crud extends Component
{
    use WithPagination;

    public $domicilio, $cp, $telefono, $observaciones, $cliente_id, $status = 'created', $editStatus = false, $domicilioId, $search = "";

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

        if ($this->domicilio == '' || $this->cp == '' || $this->telefono == '' || $this->observaciones == '') {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => '¡Todos los campos son requeridos!'
            ]);

            $this->validate([
                'domicilio' => 'required',
                'cp' => 'required',
                'telefono' => 'required',
                'observaciones' => 'required',
                'cliente_id' => 'required',
            ]);
        } else {
            DomiciliosE::create([
                'domicilio' => $this->domicilio,
                'cp' => $this->cp,
                'telefono' => $this->telefono,
                'observaciones' => $this->observaciones,
                'cliente_id' => $this->clienteBarraBuscadora['id'],
                'fechaActual' => Carbon::now()->format('d/m/Y'),
            ]);

            $bitacoraFound = Bitacora::where('cp', $this->cp)->get();
            if ($bitacoraFound->count() == 0) {
                Bitacora::create([
                    'cp' => $this->cp,
                ]);
            }

            $this->status = 'created';
            $this->toast($this->status);
            $this->dispatchBrowserEvent('close-modal');
            $this->resetInputs();
        }
    }

    public function update()
    {
        $this->editStatus = true;

        DomiciliosE::find($this->domicilioId)->update([
            'domicilio' => $this->domicilio,
            'cp' => $this->cp,
            'telefono' => $this->telefono,
            'observaciones' => $this->observaciones,
            'cliente_id' => $this->clienteBarraBuscadora['id'],
        ]);

        $this->status = 'updated';
        $this->toast($this->status);
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
    }

    public function edit($id)
    {
        $this->domicilioId = $id;
        $this->editStatus = true;
        $domicilioE = DomiciliosE::find($id);
        $clienteFound = Clientes::find($domicilioE->cliente_id);
        $this->domicilio = $domicilioE->domicilio;
        $this->cp = $domicilioE->cp;
        $this->telefono = $domicilioE->telefono;
        $this->observaciones = $domicilioE->observaciones;
        $this->clienteBarraBuscadora = $clienteFound;
    }

    public function delete($id)
    {
        $domicilioFound = DomiciliosE::find($id);
        $domicilioFound->update([
            'status' => 'inactivo',
        ]);

        $this->status = 'error';
        $this->dispatchBrowserEvent('alert', [
            'message' => '¡Domicilio de entrega eliminado correctamente!'
        ]);
    }

    public function resetInputs()
    {
        $this->editStatus = false;
        $this->domicilio = '';
        $this->cp = '';
        $this->telefono = '';
        $this->observaciones = '';
        $this->cliente_id = '';
        $this->clienteBarraBuscadora = null;
    }

    public function toast($status)
    {
        $this->status = $status;
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Domicilio de entrega creado correctamente!' : '¡Domicilio de entrega actualizado correctamente!'
        ]);
    }

    public function render()
    {
        if ($this->search != '') {
            $domicilios = DomiciliosE::join('clientes', 'clientes.id', '=', 'domicilio_entregar.cliente_id')
                ->where('domicilio', 'like', '%' . $this->search . '%')
                ->orWhere('cp', $this->search)
                ->orWhere('telefono', $this->search)
                ->orWhere('observaciones', 'like', '%' . $this->search . '%')
                ->orWhere('id', $this->search)
                ->select('domicilio_entregar.*', 'clientes.nombre')
                ->paginate(10);
        } else {
            $domicilios = DomiciliosE::join('clientes', 'clientes.id', '=', 'domicilio_entregar.cliente_id')
                ->select('domicilio_entregar.*', 'clientes.nombre')
                ->paginate(10);
        }

        return view('livewire.domicilios.crud', [
            'clientes' => Clientes::all(),
            'domicilios' => $domicilios,
        ]);
    }
}
