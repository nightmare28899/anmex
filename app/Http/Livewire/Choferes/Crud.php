<?php

namespace App\Http\Livewire\Choferes;

use Livewire\Component;
use App\Models\Choferes;
use Carbon\Carbon;
use Livewire\WithPagination;

class Crud extends Component
{
    use WithPagination;

    public $nombre, $licencia, $usuarioExt, $status = 'created', $editStatus = false, $choferId, $search = "";

    public function store()
    {
        $this->editStatus = false;

        if ($this->nombre == '' || $this->licencia == '' || $this->usuarioExt == '') {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => '¡Todos los campos son requeridos!'
            ]);

            $this->validate([
                'nombre' => 'required',
                'licencia' => 'required',
                'usuarioExt' => 'required',
            ]);
        } else {
            Choferes::create([
                'nombre' => $this->nombre,
                'licencia' => $this->licencia,
                'usuarioExt' => $this->usuarioExt,
                'fechaActual' => Carbon::now()->format('d/m/Y'),
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

        Choferes::find($this->choferId)->update([
            'nombre' => $this->nombre,
            'licencia' => $this->licencia,
            'usuarioExt' => $this->usuarioExt,
            'fechaActual' => Carbon::now()->format('d/m/Y'),
        ]);

        $this->status = 'updated';
        $this->toast($this->status);
        $this->dispatchBrowserEvent('close-modal');
        $this->resetInputs();
    }

    public function edit($id)
    {
        $this->choferId = $id;
        $this->editStatus = true;
        $chofer = Choferes::find($id);
        $this->nombre = $chofer->nombre;
        $this->licencia = $chofer->licencia;
        $this->usuarioExt = $chofer->usuarioExt;
    }

    public function delete($id)
    {
        $choferFound = Choferes::find($id);
        $choferFound->update([
            'status' => 'inactivo',
        ]);

        $this->status = 'error';
        $this->dispatchBrowserEvent('alert', [
            'message' => '¡Chofer eliminado correctamente!'
        ]);
    }

    public function resetInputs()
    {
        $this->editStatus = false;
        $this->choferId = '';
        $this->nombre = '';
        $this->licencia = '';
        $this->usuarioExt = '';
    }

    public function toast($status)
    {
        $this->status = $status;
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡Chofer creado correctamente!' : '¡Chofer actualizado correctamente!'
        ]);
    }

    public function render()
    {
        if ($this->search != '') {
            $choferes = Choferes::where('nombre', 'like', '%' . $this->search . '%')
                ->orWhere('licencia', 'like', '%' . $this->search . '%')
                ->orWhere('usuarioExt', 'like', '%' . $this->search . '%')
                ->orWhere('id', $this->search)
                ->paginate(10);
        } else {
            $choferes = Choferes::where('status', 'activo')->paginate(10);
        }

        return view('livewire.choferes.crud', [
            'choferes' => $choferes,
        ]);
    }
}
