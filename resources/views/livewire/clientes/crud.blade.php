<div>
    <!-- Navbar -->
    <!-- End Navbar -->
    <div class="container-fluid py-4">
        <div class="text-end">
            <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal" data-bs-target="#modal"
                wire:click="resetInputs">
                <i class="material-icons opacity-10 pb-1">add</i>
                Nuevo registro
            </button>
        </div>

        <div class="input-group input-group-outline my-3 bg-white">
            <input type="text" class="form-control" wire:model="search"
                placeholder="Coloca el nombre o el id">
        </div>

        <!-- Modal -->
        <div wire:ignore.self class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                    {{-- @error('nombre')
                                        <span class="text-danger text-sm">El campo Nombre es obligatorio</span>
                                    @enderror --}}
                                </div>
                            </div>
                            <div class="col-md-6">
                                {{-- <div class="input-group input-group-outline my-3">
                                    <label class="form-label">Licencia del Chofer*</label>
                                    <input type="text" class="form-control" required wire:model.defer="licencia">
                                    @error('licencia')
                                        <span class="text-danger text-sm">El campo licencia es obligatorio</span>
                                    @enderror
                                </div> --}}
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
                                Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $cliente)
                            <tr class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 text-center">
                                <td>
                                    {{ $cliente->id }}
                                </td>
                                <td>
                                    {{ $cliente->nombre }}
                                </td>
                                <td>
                                    <button type="button" class="btn bg-gradient-primary"
                                        wire:click="edit({{ $cliente->id }})" data-bs-toggle="modal"
                                        data-bs-target="#modal">
                                        <i class="material-icons opacity-10 pb-1">edit</i>
                                        Editar
                                    </button>
                                    {{-- <button type="button" class="btn bg-gradient-danger"
                                        wire:click="delete({{ $cliente->id }})">
                                        Eliminar
                                    </button> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        {{ $clientes->links('livewire.pagination.custom-pagination') }}
    </div>
</div>
