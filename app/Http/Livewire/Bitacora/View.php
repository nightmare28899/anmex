<?php

namespace App\Http\Livewire\Bitacora;

use Livewire\Component;
use App\Models\Guias;
use App\Models\DomiciliosE;
use App\Models\Choferes;
use App\Models\Bitacora;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class View extends Component
{
    use WithPagination;

    public $search = '', $showFilterCp = false, $postalCodeSend, $selected = [], $status = 'created', $marked = false, $from, $to, $guidePDF = false, $date, $cpPDF = false, $arrayCp = [], $choferSelected = [], $editStatus = false;

    public $query = '', $clientesBuscados = [], $clienteBarraBuscadora = null, $cpList = [], $cpSelected = '', $finalArray = [], $cpText, $arrayCpNames = [];

    public function mount()
    {
        $this->resetear();

        $this->from = Carbon::now()->format('Y-m-d');
    }

    public function resetear()
    {
        $this->query = '';
        $this->clientesBuscados = [];
    }

    public function selectContact($pos)
    {
        $this->clienteBarraBuscadora = $this->clientesBuscados[$pos] ?? null;
        if ($this->clienteBarraBuscadora) {
            $this->clienteBarraBuscadora;
            $this->resetear();
        }
    }

    public function updatedQuery()
    {
        if ($this->query != '') {
            $this->clientesBuscados = Choferes::where('nombre', 'like', '%' . $this->query . '%')
                ->limit(6)
                ->get()
                ->toArray();
        }
    }

    public function dataChofer($cp)
    {
        if ($this->cpText) {
            foreach ($this->finalArray as $key => $value) {
                if (isset($value[$cp])) {
                    return $value[$cp];
                }
            }
        }
    }

    public function store()
    {
        if ($this->cpText) {
            $bitacoraFound = Bitacora::where('cp', $this->cpText)->whereDate('created_at', '=', now())->first();
            $bitacoraFound->chofer = $this->clienteBarraBuscadora['nombre'];
            $bitacoraFound->save();

            $guiaFound = Guias::join('domicilio_entregar', 'domicilio_entregar.id', '=', 'guias.id_domicilio')
                ->where('domicilio_entregar.cp', $this->cpText)
                ->whereDate('guias.created_at', '=', now())
                ->get();
                
            foreach ($guiaFound as $key => $value) {
                $value->id_chofer = $this->clienteBarraBuscadora['id'];
                $value->save();
            }

            $this->cpText = '';
            $this->clienteBarraBuscadora = null;

            $this->dispatchBrowserEvent('close-modal');
            $this->status = 'created';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'created') ? '¡Chofer agregado!' : ''
            ]);
        } else {
            $this->status = 'error';
            $this->dispatchBrowserEvent('alert', [
                'message' => ($this->status == 'error') ? '¡Todos los campos son requeridos!' : ''
            ]);
        }
    }

    public function showPDFCp()
    {
        $this->cpPDF = true;
    }

    public function showFirstPDF($data)
    {
        for ($i = 0; $i < count($data); $i++) {
            $this->postalCodeSend = $data[$i]->cp;
            array_push($this->arrayCp, $this->guiasQuantity($this->postalCodeSend));
            array_push($this->arrayCpNames, $this->dataChofer($this->postalCodeSend));
        }

        $pdf = PDF::loadView(
            'livewire.bitacora.cpView',
            [
                'guias' => $data,
                'dateNow' => $this->date,
                'postalCode' => $this->postalCodeSend,
                'quantity' => $this->arrayCp,
                'dateP' => $this->date,
            ]
        )
            ->setPaper('A5', 'landscape')
            ->output();

        Storage::disk('public')->put('/pdfcp.pdf', $pdf);

        $this->status = 'created';
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡PDF Generado correctamente!' : ''
        ]);

        return Redirect::to('/vista-pdf-cp');
    }

    public function showPDFGuia()
    {
        $this->guidePDF = true;
    }

    public function showpdf($data)
    {
        $pdf = PDF::loadView(
            'livewire.bitacora.guideView',
            [
                'guias' => $data,
                'dateNow' => $this->date,
                'postalCode' => $this->postalCodeSend
            ]
        )
            ->setPaper('A5', 'landscape')
            ->output();

        Storage::disk('public')->put('/guiascp.pdf', $pdf);

        $this->status = 'created';
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'created') ? '¡PDF Generado correctamente!' : ''
        ]);

        return Redirect::to('/vista-pdf-guia');
    }

    public function removeDates()
    {
        $this->from = null;
    }

    public function selectAll()
    {
        $this->marked = !$this->marked;

        if ($this->marked) {
            $this->selected = Guias::pluck('id')->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function undelivered()
    {
        if ($this->selected) {
            for ($i = 0; $i < count($this->selected); $i++) {
                $guia = Guias::find($this->selected[$i]);

                $guia->estatus_entrega = 'Sin Entregar';
                $guia->fecha_entrega = 'Pendiente';

                $guia->save();
            }

            if ($this->marked) {
                $this->marked = false;
            }

            $this->status = 'updated';
            $this->toast($this->status);
            $this->selected = [];
        } else {
            $this->status = 'created';
            $this->toast($this->status);
        }
    }

    public function changeStatus()
    {
        if ($this->selected) {
            for ($i = 0; $i < count($this->selected); $i++) {
                $guia = Guias::find($this->selected[$i]);

                $guia->estatus_entrega = 'Entregado';
                $guia->fecha_entrega = Carbon::now()->format('d/m/Y');

                $guia->save();
            }

            if ($this->marked) {
                $this->marked = false;
            }

            $this->status = 'updated';
            $this->toast($this->status);
            $this->selected = [];
        } else {
            $this->status = 'created';
            $this->toast($this->status);
        }
    }

    public function getGuides($cp)
    {
        $this->showFilterCp = true;
        $this->postalCodeSend = $cp;

        if ($this->from) {
            $guias = Guias::join('domicilio_entregar', 'domicilio_entregar.id', 'guias.id_domicilio')
                ->join('clientes', 'clientes.id', 'guias.id_cliente')
                ->whereDate('guias.created_at', $this->from)
                ->where('domicilio_entregar.cp', $cp)
                ->select('guias.*', 'domicilio_entregar.cp', 'domicilio_entregar.domicilio', 'clientes.nombre')
                ->paginate(10);

            if ($this->guidePDF) {
                $this->showpdf($guias);
                $this->guidePDF = false;
            }
        }

        return $guias;
    }

    public function guiasQuantity($cp)
    {
        $guias = Guias::join('domicilio_entregar', 'domicilio_entregar.id', 'guias.id_domicilio')
            ->join('clientes', 'clientes.id', 'guias.id_cliente')
            ->where('domicilio_entregar.cp', $cp)
            ->where('guias.status', '!=', 'inactivo')
            ->whereDate('guias.created_at', $this->from)
            ->select('guias.*', 'domicilio_entregar.cp', 'domicilio_entregar.domicilio', 'clientes.nombre')
            ->get();

        $bitacoraFound = Bitacora::where('cp', $cp)->first();
        $bitacoraFound->guides = $guias->count();
        $bitacoraFound->save();

        return $guias->count();
    }

    public function back()
    {
        $this->showFilterCp = false;
        $this->postalCodeSend = '';
    }

    public function toast($status)
    {
        $this->status = $status;
        $this->dispatchBrowserEvent('alert', [
            'message' => ($this->status == 'updated') ? '¡Estatus actualizado correctamente!' : '¡No se ha seleccionado ninguna guía!'
        ]);
    }

    public function render()
    {
        $this->date = Carbon::now();
        $this->cpList = DomiciliosE::select('cp')->groupBy('cp')->get();

        if ($this->showFilterCp) {
            $guias = $this->getGuides($this->postalCodeSend);
        } else {
            
            $guias = Bitacora::whereDate('created_at', '=', $this->from)
                ->select('chofer', 'guides', 'cp')
                ->groupBy('cp')
                ->paginate(10);
            
            if ($this->cpPDF) {
                $this->showFirstPDF($guias);
                $this->cpPDF = false;
            }
        }

        if ($this->guidePDF) {
            $this->getGuides($this->postalCodeSend);
        }

        return view('livewire.bitacora.view', [
            'choferes' => Choferes::all(),
            'finalArray' => $this->finalArray,
        ], compact('guias'));
    }
}
