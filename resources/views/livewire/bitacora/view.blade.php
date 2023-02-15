<div class="m-3">
    <div class="input-group input-group-outline my-3 bg-white">
        <input type="text" class="form-control" wire:model="search"
            placeholder="Escribe el Código Postal">
    </div>

    <div class="card mt-3">
        <div class="table-responsive">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr class="text-center">
                        <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7">Id</th>
                        <th class="text-uppercase text-dark text-sm font-weight-bolder opacity-7">Id externo</th>
                        <th class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 ps-2">
                            nombre</th>
                        <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                            Código postal</th>
                        <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                            Domicilio</th>
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
                        <tr class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 text-center">
                            <td>
                                {{ $guia->id }}
                            </td>
                            <td>
                                {{ $guia->id_externo }}
                            </td>
                            <td>
                                {{ $guia->nombre }}
                            </td>
                            <td>
                                {{ $guia->cp }}
                            </td>
                            <td>
                                {{ $guia->domicilio }}
                            </td>
                            <td>
                                {{ $guia->estatus_entrega }}
                            </td>
                            <td>
                                {{ $guia->guia_prepago }}
                            </td>
                            <td>
                                {{ $guia->fecha_captura }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{ $guias->links('livewire.pagination.custom-pagination') }}
</div>
