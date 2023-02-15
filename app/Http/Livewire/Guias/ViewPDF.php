<?php

namespace App\Http\Livewire\Guias;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class ViewPDF extends Component
{
    public $pdf;

    public function render()
    {
        $this->pdf = Storage::url('guiaMediaCarta.pdf');
        
        return view('livewire.guias.view-p-d-f', [
            'pdf' => $this->pdf
        ]);
    }
}

