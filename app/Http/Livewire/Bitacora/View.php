<?php

namespace App\Http\Livewire\Bitacora;

use Livewire\Component;
use App\Models\Guias;
use App\Models\DomiciliosE;
use App\Models\Choferes;
use App\Models\Bitacora;
use App\Models\PostalCode;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class View extends Component
{
    use WithPagination;

    public $search = '', $showFilterCp = false, $postalCodeSend, $selected = [], $status = 'created', $marked = false, $from, $to, $guidePDF = false, $date, $cpPDF = false, $arrayCp = [], $choferSelected = [], $editStatus = false;

    public $query = '', $clientesBuscados = [], $clienteBarraBuscadora = null, $cpList = [], $cpSelected = '', $finalArray = [], $cpText, $arrayCpNames = [], $queryCP = '', $cpBuscados = [], $cpBarraBuscadora = null;

    public function mount()
    {
        $this->resetear();

        $this->from = Carbon::now()->format('Y-m-d');
    }

    public function resetear()
    {
        $this->query = '';
        $this->clientesBuscados = [];
        $this->queryCP = '';
        $this->cpBuscados = [];
    }

    public function selectContact($pos)
    {
        $this->clienteBarraBuscadora = $this->clientesBuscados[$pos] ?? null;
        if ($this->clienteBarraBuscadora) {
            $this->clienteBarraBuscadora;
            $this->resetear();
        }
    }

    public function selectCP($pos)
    {
        $this->cpBarraBuscadora = $this->cpBuscados[$pos] ?? null;
        if ($this->cpBarraBuscadora) {
            $this->cpBarraBuscadora;
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

    public function updatedQueryCP()
    {
        if ($this->queryCP != '') {
            $this->cpBuscados = PostalCode::where('postal_code', 'like', '%' . $this->queryCP . '%')
                ->groupBy('postal_code')
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
        if ($this->cpBarraBuscadora) {

            $bitacoraFound = Bitacora::where('cp', $this->cpBarraBuscadora['postal_code'])
                ->whereDate('created_at', '=', now())
                ->first();

            if ($bitacoraFound) {
                $bitacora = Bitacora::find($bitacoraFound->id);
                $bitacora->chofer = $this->clienteBarraBuscadora['nombre'];
                $bitacora->id_chofer = $this->clienteBarraBuscadora['id'];
                $bitacora->cp = $this->cpBarraBuscadora['postal_code'];
                $bitacora->save();
            } else {
                $bitacora = new Bitacora();
                $bitacora->chofer = $this->clienteBarraBuscadora['nombre'];
                $bitacora->id_chofer = $this->clienteBarraBuscadora['id'];
                $bitacora->cp = $this->cpBarraBuscadora['postal_code'];
                $bitacora->save();
            }

            $guiaFound = Guias::join('domicilio_entregar', 'domicilio_entregar.id', '=', 'guias.id_domicilio')
                ->where('domicilio_entregar.cp', $this->cpBarraBuscadora['postal_code'])
                ->whereDate('guias.created_at', '=', now())
                ->select('guias.*', 'domicilio_entregar.cp')
                ->get();

            for ($i = 0; $i < count($guiaFound); $i++) {
                $guia = Guias::find($guiaFound[$i]->id);
                $guia->id_chofer = $this->clienteBarraBuscadora['id'];
                $guia->save();
            }

            $this->cpBarraBuscadora = null;
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
            $this->selected = Guias::join('domicilio_entregar', 'domicilio_entregar.id', 'guias.id_domicilio')
                ->where('domicilio_entregar.cp', $this->postalCodeSend)
                ->select('guias.*', 'domicilio_entregar.cp')
                ->pluck('id')->toArray();
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

        $bitacoraFound = Bitacora::where('cp', $cp)->whereDate('created_at', now())->first();
        if ($bitacoraFound) {
            $bitacoraFound->guides = $guias->count();
            $bitacoraFound->save();

            for ($i = 0; $i < count($guias); $i++) {
                $guiaFound = Guias::find($guias[$i]['id']);
                $guiaFound->id_chofer = $bitacoraFound->id_chofer;
                $guiaFound->save();
            }
        }

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
            if ($this->from) {
                $guias = Bitacora::whereDate('created_at', $this->from)
                    ->select('chofer', 'guides', 'cp')
                    ->groupBy('cp')
                    ->paginate(10);
            } else {
                $guias = Bitacora::whereDate('created_at', now())
                    ->select('chofer', 'guides', 'cp')
                    ->groupBy('cp')
                    ->paginate(10);
            }

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
