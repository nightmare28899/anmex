<?php

namespace App\Http\Livewire\Clientes;

use Livewire\Component;
use App\Models\Clientes;
use Carbon\Carbon;
use Livewire\WithPagination;

class Crud extends Component
{
    use WithPagination;

    public $nombre, $status = 'created', $editStatus = false, $clienteId, $search = "";

    public function store()
    {
        $this->editStatus = false;

        if ($this->nombre == '') {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => '¡Todos los campos son requeridos!'
            ]);

            $this->validate([
                'nombre' => 'required',
            ]);
        } else {
            Clientes::create([
                'nombre' => $this->nombre,
                'fechaActual' => Carbon::now()->format('d/m/Y'),
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

        Clientes::find($this->clienteId)->update([
            'nombre' => $this->nombre,
        ]);

        $this->status = 'updated';
        $this->toast($this->status);
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
    }

    public function edit($id)
    {
        $this->clienteId = $id;
        $this->editStatus = true;
        $chofer = Clientes::find($id);
        $this->nombre = $chofer->nombre;
    }

    public function delete($id)
    {
        $choferFound = Clientes::find($id);
        $choferFound->update([
            'status' => 'inactivo',
        ]);

        $this->status = 'error';
        $this->dispatchBrowserEvent('alert', [
            'message' => '¡Cliente eliminado correctamente!'
        ]);
    }

    public function resetInputs()
    {
        $this->editStatus = false;
        $this->clienteId = '';
        $this->nombre = '';
    }

    public function toast($status)
    {
        $this->status = $status;
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Cliente creado correctamente!' : '¡Cliente actualizado correctamente!'
        ]);
    }

    public function render()
    {
        if ($this->search != '') {
            $clientes = Clientes::where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('id', $this->search)
                ->paginate(10);
        } else {
            $clientes = Clientes::paginate(10);
        }

        return view('livewire.clientes.crud', [
            'clientes' => $clientes,
        ]);
    }
}
