<div class="m-3">
    <!-- Modal -->
    <div wire:ignore.self class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title font-weight-normal" id="exampleModalLabel">
                        {{ $editStatus ? __('Actualizar Chofer') : __('Agregar Chofer') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="input-group input-group-outline my-3">

                                <input type="search" id="query" class="w-full form-control" name="query"
                                    placeholder="Escribe el nombre del chofer" wire:model="query" autocomplete="off" />

                                @if (!empty($query))

                                    <div
                                        class="position-absolute top-100 list-group shadow translate-middle-x inputSearch">

                                        @if (!empty($clientesBuscados))

                                            @foreach ($clientesBuscados as $i => $buscado)
                                                <div wire:click="selectContact({{ $i }})"
                                                    class="list-item list-none p-2 rounded-md cursor-pointer search">
                                                    {{ $buscado['nombre'] }}
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="list-item list-none p-2">No hay resultado</div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-outline my-3">
                                <input type="text" class="form-control" placeholder="Nombre del chofer"
                                    value="{{ $clienteBarraBuscadora ? $clienteBarraBuscadora['nombre'] : '' }}"
                                    disabled>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-outline">
                                <div class="input-group input-group-outline my-3">

                                    <input type="search" id="queryCP" class="w-full form-control" name="queryCP"
                                        placeholder="Escribe el código postal" wire:model="queryCP"
                                        autocomplete="off" />

                                    @if (!empty($queryCP))

                                        <div
                                            class="position-absolute top-100 list-group shadow translate-middle-x inputSearch">

                                            @if (!empty($cpBuscados))

                                                @foreach ($cpBuscados as $i => $buscado)
                                                    <div wire:click="selectCP({{ $i }})"
                                                        class="list-item list-none p-2 rounded-md cursor-pointer search">
                                                        {{ $buscado['cp'] }}
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="list-item list-none p-2">No hay resultado</div>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group input-group-outline my-3">
                                <input type="text" class="form-control" placeholder="Nombre del código postal"
                                    value="{{ $cpBarraBuscadora ? $cpBarraBuscadora['cp'] : '' }}"
                                    disabled>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn bg-gradient-dark" data-bs-dismiss="modal">Cerrar</button> --}}
                    @if ($editStatus)
                        <button type="button" class="btn bg-gradient-primary" wire:click="update">Actualizar
                            Registro</button>
                    @else
                        <button type="button" class="btn bg-gradient-primary" wire:click="store">Agregar
                            Chofer</button>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if (!$showFilterCp)
        <div class="d-flex col-7 mx-auto">
            <div class="col mt-4">
                <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#modal">
                    <i class="material-icons opacity-10 pb-1">add</i>
                    Agregar Chofer
                </button>
            </div>
            <div class="input-group input-group-static my-3 mx-6 col">
                <label>Selecciona la Fecha</label>
                <input type="date" class="form-control" wire:model="from">
            </div>
            <div class="col">
                {{-- <button type="button" class="btn bg-gradient-primary mt-4" wire:click="removeDates">
                    Resetear
                </button> --}}
            </div>
        </div>
        <div class="float-end">
            <button type="button" class="btn bg-gradient-primary" wire:click="showPDFCp">
                <i class="material-icons opacity-10 pb-1">picture_as_pdf</i>
                Generar PDF
            </button>
        </div>
        <div class="card mt-3 col-12">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr class="text-center">
                            <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                                Código postal</th>
                            <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                                Chofer</th>
                            <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                                Firma de Recibido</th>
                            <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                                Guias</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guias as $key => $guia)
                            <?php $guiasFunction = App\Http\Livewire\Bitacora\View::guiasQuantity($guia->cp); ?>
                            @if ($guiasFunction != 0)
                                <tr class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 text-center">
                                    <td>
                                        <a class="table-hover cursor-pointer"
                                            wire:click="getGuides({{ $guia->cp }})">{{ $guia->cp }}</a>
                                    </td>
                                    <td>
                                        {{ $guia->chofer }}
                                    </td>
                                    <td>
                                    </td>

                                    <td>
                                        {{ $guiasFunction }}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    @if ($showFilterCp)
        <div>
            <a wire:click="back" class="table-hover cursor-pointer">Regresar</a>
        </div>
        <div class="d-flex justify-content-between">
            <div class="mt-3">
                <button type="button" class="btn bg-gradient-danger" wire:click="selectAll">
                    {{ !$marked ? __('Marcar todos') : __('Desmarcar todos') }}
                </button>
            </div>
            <div class="mt-3">
                <button type="button" class="btn bg-gradient-danger" wire:click="undelivered">
                    No entregado
                </button>
            </div>
            <div class="mt-3">
                <button type="button" class="btn bg-gradient-primary" wire:click="showPDFGuia">
                    <i class="material-icons opacity-10 pb-1">picture_as_pdf</i>
                    Generar PDF
                </button>
            </div>
        </div>

        <div class="card mt-3 col-12">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr class="text-center">
                            <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                                Seleccionar
                            </th>
                            <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7">Id</th>
                            <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7">Id externo</th>
                            <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7">Domicilio
                                Entregar</th>
                            <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7">Nombre Cliente
                            </th>
                            <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                                Estatus entrega</th>
                            <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                                Guía prepago</th>
                            <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                                Fecha captura</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guias as $guia)
                            {{-- @if ($guia->estatus_entrega != 'Entregado' && $guia->status != 'inactivo') --}}
                            <tr class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 text-center">
                                <td>
                                    <input type="checkbox" wire:model="selected" value="{{ $guia->id }}">
                                </td>
                                <td>
                                    {{ $guia->id }}
                                </td>
                                <td>
                                    {{ $guia->id_externo }}
                                </td>
                                <td>
                                    {{ $guia->domicilio }}
                                </td>
                                <td>
                                    {{ $guia->nombre }}
                                </td>
                                <td>
                                    {{ $guia->estatus_entrega }}
                                </td>
                                <td>
                                    {{ $guia->guia_prepago }}
                                </td>
                                <td>
                                    {{ $guia->created_at }}
                                </td>
                            </tr>
                            {{-- @endif --}}
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="float-end mt-3">
            <button type="button" class="btn bg-gradient-success" wire:click="changeStatus">
                Entregado
            </button>
        </div>
    @endif
    {{ $guias->links('livewire.pagination.custom-pagination') }}
</div>
