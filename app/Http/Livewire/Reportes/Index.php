<?php

namespace App\Http\Livewire\Reportes;

use Livewire\Component;
use App\Models\Guias;
use Carbon\Carbon;
use LiveWire\WithPagination;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class Index extends Component
{
    use WithPagination;
    public $date, $from, $to;

    public function verPDF()
    {
        if ($this->from && $this->to) {
            $bitacoras = Guias::join('domicilio_entregar', 'domicilio_entregar.id', '=', 'guias.id_domicilio')
                ->join('clientes', 'clientes.id', '=', 'guias.id_cliente')
                ->join('bitacora', 'bitacora.cp', '=', 'domicilio_entregar.cp')
                ->where('guias.estatus_entrega', '=', 'Entregado')
                ->whereBetween('guias.created_at', [$this->from, $this->to])
                ->select('guias.*', 'domicilio_entregar.cp', 'domicilio_entregar.domicilio', 'domicilio_entregar.cp', 'domicilio_entregar.cliente_id', 'domicilio_entregar.fechaActual', 'clientes.nombre')
                ->get();
        } else {
            $bitacoras = Guias::join('domicilio_entregar', 'domicilio_entregar.id', '=', 'guias.id_domicilio')
                ->join('clientes', 'clientes.id', '=', 'guias.id_cliente')
                ->join('bitacora', 'bitacora.cp', '=', 'domicilio_entregar.cp')
                ->where('guias.estatus_entrega', '=', 'Entregado')
                ->select('guias.*', 'domicilio_entregar.cp', 'domicilio_entregar.domicilio', 'domicilio_entregar.cp', 'domicilio_entregar.cliente_id', 'domicilio_entregar.fechaActual', 'clientes.nombre')
                ->get();
        }

        $pdf = PDF::loadView('livewire.reportes.reportesView', [
            'bitacoras' => $bitacoras,
            'from' => $this->from,
            'to' => $this->to,
            'date' => $this->date,
        ])
        ->setPaper('A5', 'landscape')
        ->output();

        Storage::disk('public')->put('/reporteEntregados.pdf', $pdf);

        return Redirect::to('/entregados-vista');
    }

    public function render()
    {
        $this->date = Carbon::now()->format('Y-m-d');

        if ($this->from && $this->to) {
            $bitacoras = Guias::join('domicilio_entregar', 'domicilio_entregar.id', '=', 'guias.id_domicilio')
                ->join('clientes', 'clientes.id', '=', 'guias.id_cliente')
                ->join('bitacora', 'bitacora.cp', '=', 'domicilio_entregar.cp')
                ->where('guias.estatus_entrega', '=', 'Entregado')
                ->whereBetween('guias.created_at', [$this->from, $this->to])
                ->select('guias.*', 'domicilio_entregar.cp', 'domicilio_entregar.domicilio', 'domicilio_entregar.cp', 'domicilio_entregar.cliente_id', 'domicilio_entregar.fechaActual', 'clientes.nombre')
                ->paginate(10);
        } else {
            $bitacoras = Guias::join('domicilio_entregar', 'domicilio_entregar.id', '=', 'guias.id_domicilio')
                ->join('clientes', 'clientes.id', '=', 'guias.id_cliente')
                ->join('bitacora', 'bitacora.cp', '=', 'domicilio_entregar.cp')
                ->where('guias.estatus_entrega', '=', 'Entregado')
                ->select('guias.*', 'domicilio_entregar.cp', 'domicilio_entregar.domicilio', 'domicilio_entregar.cp', 'domicilio_entregar.cliente_id', 'domicilio_entregar.fechaActual', 'clientes.nombre')
                ->paginate(10);
        }


        return view('livewire.reportes.index', compact('bitacoras'));
    }
}
