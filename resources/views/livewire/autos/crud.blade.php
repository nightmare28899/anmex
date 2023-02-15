<div class="">
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
            <input type="text" class="form-control" wire:model="search"
                placeholder="Coloca la matricula, color, marca, modelo, tarjeta o chofer">
        </div>

        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="modal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">
                            {{ $editStatus ? __('Actualizar Auto') : __('Crear Auto') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">

                                    <input type="search" id="query" class="w-full form-control" name="query"
                                        placeholder="Escribe el nombre del chofer" wire:model="query"
                                        autocomplete="off" />

                                    @if (!empty($query))

                                        <div class="fixed top-0 right-0 bottom-0 left-0" wire:click="resetear"></div>

                                        <div class="absolute z-10 list-group bg-white rounded-md shadow-lg"
                                            style="width: 15.5rem;">

                                            @if (!empty($clientesBuscados))

                                                @foreach ($clientesBuscados as $i => $buscado)
                                                    <div wire:click="selectContact({{ $i }})"
                                                        class="list-item list-none p-2 hover:text-white rounded-md  hover:bg-blue-600 cursor-pointer">
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
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    @if (!$editStatus)
                                        <label class="form-label">Marca*</label>
                                    @endif
                                    <input type="text" class="form-control" required wire:model.defer="marca">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    @if (!$editStatus)
                                        <label class="form-label">Modelo*</label>
                                    @endif
                                    <input type="text" class="form-control" required wire:model.defer="modelo">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    @if (!$editStatus)
                                        <label class="form-label">Tarjeta de Circulación*</label>
                                    @endif
                                    <input type="text" class="form-control" required wire:model.defer="tarjetaC">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    @if (!$editStatus)
                                        <label class="form-label">Color*</label>
                                    @endif
                                    <input type="text" class="form-control" required wire:model.defer="color">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    @if (!$editStatus)
                                        <label class="form-label">Matricula del auto*</label>
                                    @endif
                                    <input type="text" class="form-control" required wire:model.defer="matricula">
                                </div>
                            </div>
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
                                Matricula</th>
                            <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                                Color</th>
                            <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                                Marca</th>
                            <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                                Modelo</th>
                            <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                                Tarjeta de circulación</th>
                            <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                                Id Chofer</th>
                            <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                                Chofer</th>
                            <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($autos as $auto)
                            <tr class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 text-center">
                                <td>
                                    {{ $auto->id }}
                                </td>
                                <td>
                                    {{ $auto->matricula }}
                                </td>
                                <td>
                                    {{ $auto->color }}
                                </td>
                                <td>
                                    {{ $auto->marca }}
                                </td>
                                <td>
                                    {{ $auto->modelo }}
                                </td>
                                <td>
                                    {{ $auto->tarjeta_circulacion }}
                                </td>
                                <td>
                                    {{ $auto->idChofer }}
                                </td>
                                <td>
                                    {{ $auto->nombre }}
                                </td>
                                <td>
                                    <button type="button" class="btn bg-gradient-primary"
                                        wire:click="edit({{ $auto->id }})" data-bs-toggle="modal"
                                        data-bs-target="#modal">
                                        Editar
                                    </button>
                                    {{-- <button type="button" class="btn bg-gradient-danger"
                                        wire:click="delete({{ $auto->id }})">
                                        Eliminar
                                    </button> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $autos->links('livewire.pagination.custom-pagination') }}
    </div>
</div>
