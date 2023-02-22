<?php

namespace App\Http\Livewire\Reportes;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ReporteEntregadosView extends Component
{
    public $pdf;

    public function render()
    {
        $this->pdf = Storage::url('reporteEntregados.pdf');

        return view('livewire.reportes.reporte-entregados-view', [
            'pdf' => $this->pdf
        ]);
    }
}
