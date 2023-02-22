<div class="mx-3">

    <div class="d-flex col-6 mx-auto">
        <div class="input-group input-group-static my-3 mx-6 col">
            <label>Selecciona una Fecha</label>
            <input type="date" class="form-control" wire:model="from">
        </div>
        <div class="my-3 mx-6 col">
            <button type="button" class="btn bg-gradient-primary" wire:click="verPDF">
                <i class="material-icons opacity-10 pb-1">picture_as_pdf</i>
                Generar PDF
            </button>
        </div>
    </div>

    <div class="card mt-3">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr class="text-center">
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Id</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                            Código Postal</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                            ID Externo</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                            ID Cliente</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                            Cliente</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                            Domicilio</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                            Estatus Entrega</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                            Guía Prepago</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                            Fecha Captura</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bitacoras as $bitacora)
                        <tr class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 text-center">
                            <td>
                                {{ $bitacora->id }}
                            </td>
                            <td>
                                {{ $bitacora->cp }}
                            </td>
                            <td>
                                {{ $bitacora->id_externo }}
                            </td>
                            <td>
                                {{ $bitacora->id_cliente }}
                            </td>
                            <td>
                                {{ $bitacora->nombre }}
                            </td>
                            <td>
                                {{ $bitacora->domicilio }}
                            </td>
                            <td class="text-danger">
                                <strong>{{ $bitacora->estatus_entrega }}</strong>
                            </td>
                            <td>
                                {{ $bitacora->guia_prepago }}
                            </td>
                            <td>
                                {{ $bitacora->created_at }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $bitacoras->links('livewire.pagination.custom-pagination') }}
    <p style="margin-top: 2rem;"><strong>Total de registros: {{ $bitacoras->count() }}</strong></p>
</div>
