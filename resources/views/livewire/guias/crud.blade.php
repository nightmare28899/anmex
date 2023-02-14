<div>
    <!-- Navbar -->
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="text-end">
            <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#modal"
                wire:click="resetInputs">
                Nuevo registro
            </button>
        </div>

        <div class="input-group input-group-outline my-3 bg-white">
            <input type="text" class="form-control" wire:model="search" placeholder="Coloca el estatus de entrega, id cliente o el id externo">
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

                                        <div class="fixed top-0 right-0 bottom-0 left-0" wire:click="resetear"></div>

                                        <div class="absolute z-10 list-group bg-white rounded-md shadow-lg"
                                            style="width: 15.5rem;">

                                            @if (!empty($clientesBuscados))

                                                @foreach ($clientesBuscados as $i => $buscado)
                                                    <div wire:click="selectContact({{ $i }})"
                                                        class="absolute list-item list-none p-2 hover:text-white rounded-md  hover:bg-blue-600 cursor-pointer">
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
                                    @if (!$editStatus)
                                        <label class="form-label">Id Externo*</label>
                                    @endif
                                    @if (!$guiaStatus)
                                        <input type="text" class="form-control" wire:model.defer="id_externo">
                                    @else
                                        <input type="text" class="form-control" disabled>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" class="form-control"
                                        value="{{ $clienteBarraBuscadora ? $clienteBarraBuscadora['nombre'] : '' }}"
                                        disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    <select class="form-control" wire:model="id_domicilio">
                                        <option style="display: none;">Selecciona un domicilio</option>
                                        @foreach ($domiciliosFound as $domicilio)
                                            <option value="{{ $domicilio->id }}">
                                                {{ $domicilio->domicilio }}
                                            </option> )
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    <input type="text" class="form-control" value="Pendiente" disabled>
                                </div>
                            </div>
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
                        <button type="button" class="btn bg-gradient-dark" data-bs-dismiss="modal">Cerrar</button>
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

        <div class="card mt-3">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr class="text-center">
                            <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7">Id</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                                ID Externo</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                                ID Cliente</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                                ID Domicilio</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                                Estatus Entrega</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                                Captura Fecha</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                                Guía Prepago</th>
                            {{-- <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                                Estatus</th> --}}
                            <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
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
                                    {{ $guia->id_domicilio }}
                                </td>
                                <td>
                                    {{ $guia->estatus_entrega }}
                                </td>
                                <td>
                                    {{ $guia->fecha_captura }}
                                </td>
                                <td>
                                    {{ $guia->guia_prepago }}
                                </td>
                                {{-- <td>
                                    {{ $guia->status }}
                                </td> --}}
                                <td>
                                    <button type="button" class="btn bg-gradient-primary"
                                        wire:click="verPDFMediaCarta">
                                        PDF Media Carta
                                    </button>
                                    <button type="button" class="btn bg-gradient-primary"
                                        wire:click="edit({{ $guia->id }})" data-bs-toggle="modal"
                                        data-bs-target="#modal">
                                        Editar
                                    </button>
                                    <button type="button" class="btn bg-gradient-danger"
                                        wire:click="delete({{ $guia->id }})">
                                        Eliminar
                                    </button>
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
