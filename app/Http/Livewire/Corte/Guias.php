<?php

namespace App\Http\Livewire\Corte;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Guias as GuiasModel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class Guias extends Component
{
    use WithPagination;

    public $status, $postalCodeSend, $statusPDF = false, $arrayCp = [], $pickerDate;

    public function guiasQuantity($cp)
    {
        $this->postalCodeSend = $cp;

        $guias = GuiasModel::join('domicilio_entregar', 'domicilio_entregar.id', 'guias.id_domicilio')
            ->join('clientes', 'clientes.id', 'guias.id_cliente')
            ->where('domicilio_entregar.cp', $cp)
            ->where('guias.status', '!=', 'inactivo')
            ->whereDate('guias.created_at', now()->format('Y-m-d'))
            ->select('guias.*', 'domicilio_entregar.cp', 'domicilio_entregar.domicilio', 'clientes.nombre')
            ->get();

        return $guias->count();
    }

    public function showpdf($data)
    {
        for ($i = 0; $i < count($data); $i++) {
            array_push($this->arrayCp, $this->guiasQuantity($data[$i]->cp));
        }

        $pdf = PDF::loadView(
            'livewire.corte.structurePDF',
            [
                'guias' => $data,
                'dateNow' => $this->pickerDate,
                'cantidad' => $this->arrayCp,
            ]
        )
            ->setPaper('A5', 'vertical')
            ->output();

        Storage::disk('public')->put('/corteGuias.pdf', $pdf);

        $this->status = 'created';
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡PDF Generado correctamente!' : ''
        ]);

        return Redirect::to('/vista-pdf-corte');
    }

    public function changeStatusPDF()
    {
        $this->statusPDF = true;
    }

    public function render()
    {
        $this->pickerDate = Carbon::now()->format('Y-m-d');

        $guias = GuiasModel::join('domicilio_entregar', 'domicilio_entregar.id', 'guias.id_domicilio')
            ->join('clientes', 'clientes.id', 'guias.id_cliente')
            ->where('guias.status', '!=', 'inactivo')
            ->whereDate('guias.created_at', now()->format('Y-m-d'))
            ->select('guias.*', 'domicilio_entregar.cp', 'domicilio_entregar.domicilio', 'clientes.nombre')
            ->groupBy('domicilio_entregar.cp')
            ->paginate(10);

        if ($this->statusPDF) {
            $this->showpdf($guias);
        }

        return view('livewire.corte.guias', compact('guias'));
    }
}
