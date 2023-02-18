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
            <input type="text" class="form-control" wire:model="search" placeholder="Coloca el nombre, licencia o usuario externo">
        </div>

        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="modal" tabindex="-1" role="dialog"
            aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title font-weight-normal" id="exampleModalLabel">
                            {{ $editStatus ? __('Actualizar Chofer') : __('Crear Chofer') }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    @if (!$editStatus)
                                        <label class="form-label">Nombre del Chofer*</label>
                                    @endif
                                    <input type="text" class="form-control" required wire:model.defer="nombre">
                                    {{-- @error('nombre')
                                        <span class="text-danger text-sm">El campo Nombre es obligatorio</span>
                                    @enderror --}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    @if (!$editStatus)
                                        <label class="form-label">Licencia del Chofer*</label>
                                    @endif
                                    <input type="text" class="form-control" required wire:model.defer="licencia">
                                    {{-- @error('licencia')
                                        <span class="text-danger text-sm">El campo licencia es obligatorio</span>
                                    @enderror --}}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="input-group input-group-outline my-3">
                                    @if (!$editStatus)
                                        <label class="form-label">Usuario Externo*</label>
                                    @endif
                                    <input type="text" class="form-control" required wire:model.defer="usuarioExt">
                                    {{-- @error('usuarioExt')
                                        <span class="text-danger text-sm">El campo usuario externo es obligatorio</span>
                                    @enderror --}}
                                </div>
                            </div>
                            <div class="col-md-6">
                            </div>
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

        <div class="card mt-3">
            <div class="table-responsive">
                <table class="table align-items-center mb-0">
                    <thead>
                        <tr class="text-center">
                            <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7">Id</th>
                            <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                                Nombre</th>
                            <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                                Licencia</th>
                            <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                                Usuario Externo</th>
                            <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($choferes as $chofer)
                            <tr class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 text-center">
                                <td>
                                    {{ $chofer->id }}
                                </td>
                                <td>
                                    {{ $chofer->nombre }}
                                </td>
                                <td>
                                    {{ $chofer->licencia }}
                                </td>
                                <td>
                                    {{ $chofer->usuarioExt }}
                                </td>
                                <td>
                                    <button type="button" class="btn bg-gradient-primary"
                                        wire:click="edit({{ $chofer->id }})" data-bs-toggle="modal"
                                        data-bs-target="#modal">
                                        Editar
                                    </button>
                                    {{-- <button type="button" class="btn bg-gradient-danger"
                                        wire:click="delete({{ $chofer->id }})">
                                        Eliminar
                                    </button> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $choferes->links('livewire.pagination.custom-pagination') }}
    </div>
</div>
