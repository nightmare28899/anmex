<?php

namespace App\Http\Livewire\Autos;

use Livewire\Component;
use App\Models\Autos;
use App\Models\Choferes;
use Carbon\Carbon;
use Livewire\WithPagination;

class Crud extends Component
{
    use WithPagination;

    public $matricula, $color, $marca, $modelo, $tarjetaC, $chofer, $status = 'created', $editStatus = false, $autoId, $search = "";

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
            $this->clientesBuscados = Choferes::where('nombre', 'like', '%' . $this->query . '%')
                ->limit(6)
                ->get()
                ->toArray();
        }
    }

    public function store()
    {
        $this->editStatus = false;

        if ($this->matricula == '' || $this->color == '' || $this->marca == '' || $this->modelo == '' || $this->tarjetaC == '') {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => '¡Todos los campos son requeridos!'
            ]);

            $this->validate([
                'matricula' => 'required',
                'color' => 'required',
                'marca' => 'required',
                'modelo' => 'required',
                'tarjetaC' => 'required',
                'chofer' => 'required',
            ]);
        } else {
            Autos::create([
                'matricula' => $this->matricula,
                'color' => $this->color,
                'modelo' => $this->modelo,
                'marca' => $this->marca,
                'tarjeta_circulacion' => $this->tarjetaC,
                'idChofer' => $this->clienteBarraBuscadora['id'],
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

        Autos::find($this->autoId)->update([
            'matricula' => $this->matricula,
            'color' => $this->color,
            'modelo' => $this->modelo,
            'marca' => $this->marca,
            'tarjeta_circulacion' => $this->tarjetaC,
            'idChofer' => $this->clienteBarraBuscadora['id'],
            'fechaActual' => Carbon::now()->format('d/m/Y'),
        ]);

        $this->status = 'updated';
        $this->toast($this->status);
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
    }

    public function edit($id)
    {
        $this->autoId = $id;
        $this->editStatus = true;
        $chofer = Autos::find($id);
        $choferFound = Choferes::find($chofer->idChofer);
        $this->matricula = $chofer->matricula;
        $this->color = $chofer->color;
        $this->marca = $chofer->marca;
        $this->modelo = $chofer->modelo;
        $this->tarjetaC = $chofer->tarjeta_circulacion;
        $this->clienteBarraBuscadora = $choferFound;
        $this->chofer = $chofer->idChofer;
    }

    public function delete($id)
    {
        $autoFound = Autos::find($id);
        $autoFound->update([
            'status' => 'inactivo',
        ]);

        $this->status = 'error';
        $this->dispatchBrowserEvent('alert', [
            'message' => '¡Auto eliminado correctamente!'
        ]);
    }

    public function resetInputs()
    {
        $this->editStatus = false;
        $this->autoId = '';
        $this->matricula = '';
        $this->color = '';
        $this->marca = '';
        $this->modelo = '';
        $this->tarjetaC = '';
        $this->chofer = '';
        $this->clienteBarraBuscadora = '';
    }

    public function toast($status)
    {
        $this->status = $status;
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Auto creado correctamente!' : '¡Auto actualizado correctamente!'
        ]);
    }

    public function render()
    {
        if ($this->search != '') {
            $autos = Autos::join('choferes', 'choferes.id', '=', 'autos.idChofer')
                ->select('autos.*', 'choferes.nombre', 'choferes.licencia', 'choferes.usuarioExt', 'choferes.status', 'choferes.fechaActual')
                ->where(function ($query) {
                    $query->where('autos.matricula', 'like', '%' . $this->search . '%')
                        ->orWhere('autos.color', $this->search)
                        ->orWhere('autos.marca', $this->search)
                        ->orWhere('autos.modelo', $this->search)
                        ->orWhere('autos.tarjeta_circulacion', $this->search)
                        ->orWhere('choferes.nombre', 'like', '%' . $this->search . '%');
                })
                ->paginate(10);
        } else {
            $autos = Autos::join('choferes', 'choferes.id', '=', 'autos.idChofer')
                ->select('autos.*', 'choferes.nombre', 'choferes.licencia', 'choferes.usuarioExt', 'choferes.status', 'choferes.fechaActual')
                ->orderBy('autos.id', 'asc')
                ->paginate(10);
        }

        return view('livewire.autos.crud', [
            'autos' => $autos,
        ]);
    }
}
