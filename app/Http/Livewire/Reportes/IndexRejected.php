<?php

namespace App\Http\Livewire\Reportes;

use Livewire\Component;
use App\Models\Guias;
use App\Models\Choferes;
use Carbon\Carbon;
use LiveWire\WithPagination;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class IndexRejected extends Component
{
    use WithPagination;
    public $date, $from, $choferSelected = 'vacio';

    public function mount()
    {
        $this->from = Carbon::now()->format('Y-m-d');
    }

    public function verPDF()
    {
        $bitacoras = Guias::join('domicilio_entregar', 'domicilio_entregar.id', '=', 'guias.id_domicilio')
            ->join('clientes', 'clientes.id', '=', 'guias.id_cliente')
            ->join('choferes', 'choferes.id', '=', 'guias.id_chofer')
            ->where('guias.estatus_entrega', '=', 'Sin Entregar')
            ->whereDate('guias.created_at', '=', $this->from)
            ->select('guias.*', 'domicilio_entregar.cp', 'domicilio_entregar.domicilio', 'domicilio_entregar.cp', 'domicilio_entregar.cliente_id', 'domicilio_entregar.fechaActual', 'clientes.nombre', 'choferes.nombre as choferName')
            ->get();

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

        $bitacoras = Guias::join('domicilio_entregar', 'domicilio_entregar.id', '=', 'guias.id_domicilio')
            ->join('clientes', 'clientes.id', '=', 'guias.id_cliente')
            ->join('choferes', 'choferes.id', '=', 'guias.id_chofer')
            ->where('guias.estatus_entrega', '=', 'Sin Entregar')
            ->whereDate('guias.created_at', '=', $this->from)
            ->select('guias.*', 'domicilio_entregar.cp', 'domicilio_entregar.domicilio', 'domicilio_entregar.cp', 'domicilio_entregar.cliente_id', 'domicilio_entregar.fechaActual', 'clientes.nombre', 'choferes.nombre as choferName')
            ->paginate(10);

        if ($this->choferSelected != 'vacio') {
            $bitacoras = Guias::join('domicilio_entregar', 'domicilio_entregar.id', '=', 'guias.id_domicilio')
                ->join('clientes', 'clientes.id', '=', 'guias.id_cliente')
                ->join('choferes', 'choferes.id', '=', 'guias.id_chofer')
                ->where('guias.estatus_entrega', '=', 'Sin Entregar')
                ->whereDate('guias.created_at', '=', $this->from)
                ->where('guias.id_chofer', $this->choferSelected)
                ->select('guias.*', 'domicilio_entregar.cp', 'domicilio_entregar.domicilio', 'domicilio_entregar.cp', 'domicilio_entregar.cliente_id', 'domicilio_entregar.fechaActual', 'clientes.nombre', 'choferes.nombre as choferName')
                ->paginate(10);
        }

        return view('livewire.reportes.index-rejected', [
            'choferes' => Choferes::all(),
        ], compact('bitacoras'));
    }
}
