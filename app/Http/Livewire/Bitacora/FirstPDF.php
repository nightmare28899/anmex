<?php

namespace App\Http\Livewire\Bitacora;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;

class FirstPDF extends Component
{
    public $pdf;
    
    public function render()
    {
        $this->pdf = Storage::url('/pdfcp.pdf');

        return view('livewire.bitacora.first-p-d-f', [
            'pdf' => $this->pdf
        ]);
    }
}
