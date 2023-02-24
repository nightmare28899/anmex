<div class="float-end">
    <button type="button" class="btn bg-gradient-primary" wire:click="changeStatusPDF">
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
                        Guias</th>
                    <th class="text-center text-uppercase text-dark text-xs font-weight-bolder opacity-7">
                        Fecha</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($guias as $guia)
                    <?php $guiasFunction = App\Http\Livewire\Corte\Guias::guiasQuantity($guia->cp); ?>
                    @if ($guiasFunction != 0)
                        <tr class="text-uppercase text-dark text-xs font-weight-bolder opacity-7 text-center">
                            <td>
                                {{ $guia->cp }}
                            </td>
                            <td>
                                {{ $guiasFunction }}
                            </td>
                            <td>
                                {{ $pickerDate }}
                            </td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
    <div>
        {{ $guias->links() }}
    </div>
</div>
