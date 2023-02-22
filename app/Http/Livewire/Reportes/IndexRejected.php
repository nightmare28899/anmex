<?php

namespace App\Http\Livewire\Reportes;

use Livewire\Component;
use App\Models\Guias;
use Carbon\Carbon;
use LiveWire\WithPagination;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class IndexRejected extends Component
{
    use WithPagination;
    public $date, $from;

    public function mount()
    {
        $this->from = Carbon::now()->format('Y-m-d');
    }

    public function verPDF()
    {
        if ($this->from) {
            $bitacoras = Guias::join('domicilio_entregar', 'domicilio_entregar.id', '=', 'guias.id_domicilio')
                ->join('clientes', 'clientes.id', '=', 'guias.id_cliente')
                ->join('bitacora', 'bitacora.cp', '=', 'domicilio_entregar.cp')
                ->where('guias.estatus_entrega', '=', 'Sin Entregar')
                ->whereDate('guias.created_at', '=', $this->from)
                ->select('guias.*', 'domicilio_entregar.cp', 'domicilio_entregar.domicilio', 'domicilio_entregar.cp', 'domicilio_entregar.cliente_id', 'domicilio_entregar.fechaActual', 'clientes.nombre')
                ->get();
        } else {
            $bitacoras = Guias::join('domicilio_entregar', 'domicilio_entregar.id', '=', 'guias.id_domicilio')
                ->join('clientes', 'clientes.id', '=', 'guias.id_cliente')
                ->join('bitacora', 'bitacora.cp', '=', 'domicilio_entregar.cp')
                ->where('guias.estatus_entrega', '=', 'Sin Entregar')
                ->select('guias.*', 'domicilio_entregar.cp', 'domicilio_entregar.domicilio', 'domicilio_entregar.cp', 'domicilio_entregar.cliente_id', 'domicilio_entregar.fechaActual', 'clientes.nombre')
                ->get();
        }

        $pdf = PDF::loadView('livewire.reportes.reportesViewRejected', [
            'bitacoras' => $bitacoras,
            'from' => $this->from,
            'date' => $this->date,
        ])
        ->setPaper('A5', 'landscape')
        ->output();

        Storage::disk('public')->put('/reporteDevueltos.pdf', $pdf);

        return Redirect::to('/devueltos-vista');
    }

    public function render()
    {
        $this->date = Carbon::now()->format('Y-m-d');

        if ($this->from) {
            $bitacoras = Guias::join('domicilio_entregar', 'domicilio_entregar.id', '=', 'guias.id_domicilio')
                ->join('clientes', 'clientes.id', '=', 'guias.id_cliente')
                ->join('bitacora', 'bitacora.cp', '=', 'domicilio_entregar.cp')
                ->where('guias.estatus_entrega', '=', 'Sin Entregar')
                ->whereDate('guias.created_at', '=', $this->from)
                ->select('guias.*', 'domicilio_entregar.cp', 'domicilio_entregar.domicilio', 'domicilio_entregar.cp', 'domicilio_entregar.cliente_id', 'domicilio_entregar.fechaActual', 'clientes.nombre')
                ->paginate(10);
        } else {
            $bitacoras = Guias::join('domicilio_entregar', 'domicilio_entregar.id', '=', 'guias.id_domicilio')
                ->join('clientes', 'clientes.id', '=', 'guias.id_cliente')
                ->join('bitacora', 'bitacora.cp', '=', 'domicilio_entregar.cp')
                ->where('guias.estatus_entrega', '=', 'Sin Entregar')
                ->select('guias.*', 'domicilio_entregar.cp', 'domicilio_entregar.domicilio', 'domicilio_entregar.cp', 'domicilio_entregar.cliente_id', 'domicilio_entregar.fechaActual', 'clientes.nombre')
                ->paginate(10);
        }

        return view('livewire.reportes.index-rejected', compact('bitacoras'));
    }
}
