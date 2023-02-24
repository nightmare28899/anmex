<?php

namespace App\Http\Livewire\Corte;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ViewPDF extends Component
{
    public $pdf;

    public function render()
    {
        $this->pdf = Storage::url('corteGuias.pdf');

        return view('livewire.corte.view-p-d-f', [
            'pdf' => $this->pdf,
        ]);
    }
}
