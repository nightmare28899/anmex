<?php

namespace App\Http\Livewire\Bitacora;

use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class GuideViewPDF extends Component
{
    public $pdf;

    public function render()
    {
        $this->pdf = Storage::url('/guiascp.pdf');

        return view('livewire.bitacora.guide-view-p-d-f', [
            'pdf' => $this->pdf
        ]);
    }
}
