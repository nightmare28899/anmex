<?php

namespace App\Http\Livewire\Guias;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

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
