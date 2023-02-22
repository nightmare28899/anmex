<?php

namespace App\Http\Livewire\Guias;

use Livewire\Component;
use App\Models\Guias;
use App\Models\Clientes;
use App\Models\DomiciliosE;
use Carbon\Carbon;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class Crud extends Component
{
    use WithPagination;

    public $id_externo, $id_cliente, $id_domicilio, $estatus_entrega = 'Pendiente', $guia_prepago, $guiaStatus = false, $status = 'created', $editStatus = false, $guiaFound, $search = "", $domiciliosFound = [], $idGuia, $idGuiaDelete;

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
                'id_externo' => $this->guiaStatus == false ? $this->id_externo : '-',
                'id_cliente' => $this->clienteBarraBuscadora['id'],
                'id_domicilio' => $this->id_domicilio,
                'estatus_entrega' => 'Pendiente',
                'guia_prepago' => $this->guia_prepago == true ? $this->guia_prepago : '-',
                'fecha_entrega' => 'Pendiente',
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
        $this->clienteBarraBuscadora = Clientes::find($guiaFound->id_cliente);
        $guiaFound->guia_prepago != '' ? $this->guiaStatus = true : $this->guiaStatus = false;

        $this->guiaStatus == true ? $this->guia_prepago = $guiaFound->guia_prepago : $this->guia_prepago = '';
        $this->guiaStatus == false ? $this->id_externo = $guiaFound->id_externo : $this->id_externo = '';

        $this->domiciliosFound = DomiciliosE::where('cliente_id', $this->clienteBarraBuscadora['id'])->get();
        $this->id_domicilio = $guiaFound->id_domicilio;
    }

    public function showWarningMessage($id)
    {
        $this->idGuiaDelete = $id;
    }

    public function delete()
    {
        $guiaFound = Guias::find($this->idGuiaDelete);
        $guiaFound->update([
            'status' => 'inactivo',
        ]);

        $this->status = 'error';
        $this->dispatchBrowserEvent('alert', [
            'message' => '¡Guía inactiva correctamente!'
        ]);

        $this->dispatchBrowserEvent('close-modal');
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

    public function verGuiaPrepago($id, $status = null)
    {
        $guiaFound = Guias::find($id);
        $clienteFound = Clientes::find($guiaFound->id_cliente);
        $domicilioFound = DomiciliosE::find($guiaFound->id_domicilio);
        $customPaper = array(0, 0, 289.133858268, 430.866141732);

        $pdf = PDF::loadView(
            'livewire.guias.pdf-mediaCarta',
            [
                'guia' => $guiaFound,
                'cliente' => $clienteFound,
                'domicilio' => $domicilioFound,
                'status' => $status,
            ]
        )
            ->setPaper($customPaper, 'vertical')
            ->output();

        Storage::disk('public')->put('/guiaMediaCarta.pdf', $pdf);

        return Redirect::to('/view-pdf');
    }

    public function verPDFMediaCarta($id, $status)
    {
        $guiaFound = Guias::find($id);
        $clienteFound = Clientes::find($guiaFound->id_cliente);
        $domicilioFound = DomiciliosE::find($guiaFound->id_domicilio);

        $pdf = PDF::loadView(
            'livewire.guias.pdf-mediaCarta',
            [
                'guia' => $guiaFound,
                'cliente' => $clienteFound,
                'domicilio' => $domicilioFound,
                'status' => $status,
            ]
        )
            ->setPaper('A3', 'landscape')
            ->output();

        Storage::disk('public')->put('/guiaMediaCarta.pdf', $pdf);

        return Redirect::to('/view-pdf');
    }

    public function render()
    {
        if ($this->search != '') {
            $guia = Guias::join('domicilio_entregar', 'domicilio_entregar.id', 'guias.id_domicilio')
                ->join('clientes', 'clientes.id', 'guias.id_cliente')
                ->where('estatus_entrega', $this->search)
                ->where('status', 'activo')
                ->orWhere('id_cliente', $this->search)
                ->orWhere('id_externo', $this->search)
                ->select('guias.*', 'domicilio_entregar.cp', 'domicilio_entregar.domicilio', 'clientes.nombre')
                ->paginate(10);
        } else {
            $guia = Guias::join('domicilio_entregar', 'domicilio_entregar.id', 'guias.id_domicilio')
                ->join('clientes', 'clientes.id', 'guias.id_cliente')
                ->where('status', 'activo')
                ->select('guias.*', 'domicilio_entregar.cp', 'domicilio_entregar.domicilio', 'clientes.nombre')
                ->paginate(10);
        }

        return view('livewire.guias.crud', [
            'guias' => $guia
        ]);
    }
}
