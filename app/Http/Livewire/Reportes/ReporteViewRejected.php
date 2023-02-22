<?php

namespace App\Http\Livewire\Reportes;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ReporteViewRejected extends Component
{
    public $pdf;

    public function render()
    {
        $this->pdf = Storage::url('reporteDevueltos.pdf');

        return view('livewire.reportes.reporte-view-rejected', [
            'pdf' => $this->pdf
        ]);
    }
}
