<div>
    <!-- Navbar -->
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="d-flex justify-content-end">
            <div class="text-start">
                <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#modalClient"
                    wire:click="resetInputs">
                    <i class="material-icons opacity-10 pb-1">person</i>
                    Nuevo cliente
                </button>
            </div>
            &nbsp;&nbsp;&nbsp;
            <div class="text-end">
                <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#modal"
                    wire:click="resetInputs">
                    <i class="material-icons opacity-10 pb-1">add</i>
                    Nuevo registro
                </button>
            </div>
        </div>

        <div class="input-group input-group-outline my-3 bg-white">
            <input type="text" class="form-control" wire:model="search"
                placeholder="Coloca el estatus de entrega, id cliente o el id externo">
        </div>

        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="modal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">
                            {{ $editStatus ? __('Actualizar Guía') : __('Crear Guía') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    <input type="search" id="query" class="w-full form-control" name="query"
                                        placeholder="Escribe el cliente" wire:model="query" autocomplete="off" />

                                    @if (!empty($query))

                                        <div
                                            class="position-absolute top-100 list-group shadow translate-middle-x inputSearch">

                                            @if (!empty($clientesBuscados))

                                                @foreach ($clientesBuscados as $i => $buscado)
                                                    <div wire:click="selectContact({{ $i }})"
                                                        class="absolute list-item list-none p-2 rounded-md cursor-pointer search">
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
                                    <input type="text" class="form-control" placeholder="Nombre del cliente"
                                        value="{{ $clienteBarraBuscadora ? $clienteBarraBuscadora['nombre'] : '' }}"
                                        disabled>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    <input type="search" id="queryDom" class="w-full form-control" name="queryDom"
                                        placeholder="Escribe el domicilio" wire:model="queryDom" autocomplete="off" />

                                    @if (!empty($queryDom))

                                        <div
                                            class="position-absolute top-100 list-group shadow translate-middle-x inputSearch">

                                            @if (!empty($domiciliosBuscados))

                                                @foreach ($domiciliosBuscados as $i => $buscado)
                                                    <div wire:click="selectDomicilio({{ $i }})"
                                                        class="absolute list-item list-none p-2 rounded-md cursor-pointer search">
                                                        {{ $buscado['domicilio'] }}
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
                                    <textarea type="text" class="form-control" placeholder="Nombre del domicilio" disabled
                                        wire:model="domicilioTextArea"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" class="form-control" value="Estatus: Pendiente" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    {{-- @if (!$editStatus)
                                        <label class="form-label">Id Externo*</label>
                                    @endif --}}
                                    @if (!$guiaStatus)
                                        <input type="text" class="form-control" wire:model.defer="id_externo"
                                            placeholder="Id Externo">
                                    @else
                                        <input type="text" class="form-control" wire:model="id_externo = ''"
                                            disabled>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    <input class="form-check-input mr-4 border" type="checkbox" wire:model="guiaStatus"
                                        id="flexCheckDefault">
                                    &nbsp;&nbsp;&nbsp;
                                    <label class="form-check-label ml-3" for="flexCheckDefault">
                                        Guía Prepago
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            @if ($guiaStatus)
                                <div class="col-md-6">
                                    <div class="input-group input-group-outline my-3">
                                        <input type="text" class="form-control" placeholder="Coloca la guía"
                                            wire:model="guia_prepago">
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        {{-- <button type="button" class="btn bg-gradient-dark" data-bs-dismiss="modal">Cerrar</button> --}}
                        @if ($editStatus)
                            <button type="button" class="btn bg-gradient-primary" wire:click="update">Actualizar
                                Registro</button>
                        @else
                            <button type="button" class="btn bg-gradient-primary" wire:click="store">Crear
                                Registro</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Delete --}}
        <div wire:ignore.self class="modal fade" id="modalDelete" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">
                            Eliminar Registro
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <p>¿Estás seguro que deseas dejar inactivo el registro?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn bg-gradient-primary"
                            data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn bg-gradient-primary" wire:click="delete">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal client --}}
        <div wire:ignore.self class="modal fade" id="modalClient" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">
                            {{ $editStatus ? __('Actualizar Cliente') : __('Crear Cliente') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    @if (!$editStatus)
                                        <label class="form-label">Nombre del Cliente*</label>
                                    @endif
                                    <input type="text" class="form-control" required wire:model.defer="nombre">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    @if (!$editStatus)
                                        <label class="form-label">Telefono*</label>
                                    @endif
                                    <input type="text" class="form-control" required wire:model.defer="telefono">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    @if (!$editStatus)
                                        <label class="form-label">Código postal*</label>
                                    @endif
                                    <input type="text" class="form-control" required wire:model.defer="cp">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    <textarea type="text" class="form-control" required wire:model.defer="domicilio"
                                        placeholder="Coloca el domicilio"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    <textarea type="text" class="form-control" required wire:model.defer="observaciones"
                                        placeholder="Coloca las observaciones"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if ($editStatus)
                            <button type="button" class="btn bg-gradient-primary" wire:click="update">Actualizar
                                Registro</button>
                        @else
                            <button type="button" class="btn bg-gradient-primary" wire:click="createCliente">Crear
                                Registro</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr class="text-center">
                            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7">Id</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                                ID Externo</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                                ID Cliente</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                                Cliente</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                                ID Domicilio</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                                Domicilio</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                                Código Postal</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                                Estatus Entrega</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                                Fecha Captura</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                                Guía Prepago</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($guias as $guia)
                            <tr class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 text-center">
                                <td>
                                    {{ $guia->id }}
                                </td>
                                <td>
                                    {{ $guia->id_externo }}
                                </td>
                                <td>
                                    {{ $guia->id_cliente }}
                                </td>
                                <td>
                                    {{ $guia->nombre }}
                                </td>
                                <td>
                                    {{ $guia->id_domicilio }}
                                </td>
                                <td>
                                    {{ $guia->domicilio }}
                                </td>
                                <td>
                                    {{ $guia->cp }}
                                </td>
                                <td>
                                    {{ $guia->estatus_entrega }}
                                </td>
                                <td>
                                    {{ $guia->created_at }}
                                </td>
                                <td>
                                    {{ $guia->guia_prepago }}
                                </td>
                                <td>
                                    <div class="col-6">
                                        @if ($guia->id_externo != null)
                                            <?php $status = 0; ?>
                                            {{-- <button type="button" class="btn bg-gradient-success"
                                                wire:click="verPDFMediaCarta({{ $guia->id }}, {{ $status }})">
                                                Comprobante
                                            </button> --}}
                                            <button type="button" class="btn bg-gradient-dark"
                                                wire:click="verGuiaPrepago({{ $guia->id }}, {{ $status = null }})">
                                                Etiqueta
                                            </button>
                                        @else
                                            <?php $status = 1; ?>
                                            <button type="button" class="btn bg-gradient-success"
                                                wire:click="verPDFMediaCarta({{ $guia->id }}, {{ $status }})">
                                                Comprobante
                                            </button>
                                            <button type="button" class="btn bg-gradient-dark"
                                                wire:click="verGuiaPrepago({{ $guia->id }}, {{ $status = null }})">
                                                Etiqueta
                                            </button>
                                        @endif
                                    </div>
                                    <div class="col-6">
                                        <button type="button" class="btn bg-gradient-primary"
                                            wire:click="edit({{ $guia->id }})" data-bs-toggle="modal"
                                            data-bs-target="#modal">
                                            <i class="material-icons opacity-10 pb-1">edit</i>
                                            Editar
                                        </button>
                                        <button type="button" class="btn bg-gradient-danger" data-bs-toggle="modal"
                                            data-bs-target="#modalDelete"
                                            wire:click="showWarningMessage({{ $guia->id }})">
                                            <i class="material-icons opacity-10 pb-1">cancel</i>
                                            Eliminar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $guias->links('livewire.pagination.custom-pagination') }}
    </div>
</div>
