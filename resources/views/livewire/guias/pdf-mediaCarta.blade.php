<style>
    body {
        font-family: 'Roboto', sans-serif;
    }
</style>

<div>
    @if ($guia->id_externo != null && $status == 0)
        <div style="margin-left: 1.6rem;">
            <img src="assets/img/logo-anmex.png" alt="">
            <div style="margin-left: 40rem; margin-top: -23rem">
                <p style="color: red; font-size: 7rem;"><strong>ID:{{ $guia->id }}</strong></p>
                <div style="margin-top: -10rem;">
                    <p style="color: red; font-size: 3rem;">EXT:{{ $guia->id_externo }}</p>
                    <p style="color: red; font-size: 3rem; margin-left: 34rem; margin-top: -7rem;">
                        CP:{{ $domicilio->cp }}
                    </p>
                </div>
            </div>
        </div>

        <div style="font-size: 3rem; margin-left: 3rem;">
            <p>Cliente: {{ $cliente->nombre }}</p>
            <p>Domiclio de entrega: {{ $domicilio->domicilio }}</p>
            <p>Telefono: {{ $domicilio->telefono }}</p>
            <p>Observaciones: {{ $domicilio->observaciones }}</p>

            <div style="margin-top: 3rem;">
                <p>Documentador: <kbd style="border-bottom: 3px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</kbd></p>
                <p style="margin-top: -7rem; margin-left: 55rem;">Cliente: <kbd style="border-bottom: 3px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</kbd></p>
            </div>
        </div>
    @elseif ($status == 1)
        <div style="margin-left: 1.6rem;">
            <img src="assets/img/logo-anmex.png" alt="">
            <div style="margin-left: 40rem; margin-top: -23rem">
                <p style="color: red; font-size: 7rem;"><strong>ID:{{ $guia->id }}</strong></p>
                <div style="margin-top: -10rem;">
                    <p style="color: red; font-size: 3rem;">{{-- EXT:{{ $guia->id_externo }} --}}</p>
                    <p style="color: red; font-size: 3rem; margin-left: 34rem; margin-top: -7rem;">
                        CP:{{ $domicilio->cp }}
                    </p>
                </div>
            </div>
        </div>

        <div style="font-size: 3rem; margin-left: 3rem;">
            <p>Cliente: {{ $cliente->nombre }}</p>
            <p>Domiclio de entrega: {{ $domicilio->domicilio }}</p>
            <p>Telefono: {{ $domicilio->telefono }}</p>
            <p>Observaciones: {{ $domicilio->observaciones }}</p>

            <div style="margin-top: 3rem;">
                <p>Documentador: <kbd style="border-bottom: 3px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</kbd></p>
                <p style="margin-top: -7rem; margin-left: 55rem;">Cliente: <kbd style="border-bottom: 3px solid black;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p>
            </div>
        </div>
    @elseif ($guia->guia_prepago != null)
        <div style="text-align: center; margin-top: -3rem;">
            <img src="assets/img/logo-anmex.png" width="200rem" height="100" alt="">
        </div>
        <br>
        <div style="text-align: center; border: .3px solid black;">
            <p style="margin-top: -.76rem; background: white; width: 45%; margin-left: 5rem;"><strong>Guía de
                    Prepago</strong></p>
            <p style="color: red; font-size: 2rem; margin-top: -.5rem;"><strong>ID:{{ $guia->id }}</strong></p>
            <p style="color: red; font-size: 1rem; margin-top: -1.6rem;">CP:{{ $domicilio->cp }}</p>
            <p style="text-align: center;">Cliente:</p>
            <p style="text-align: center;">{{ $cliente->nombre }}</p>
            <p style="text-align: center;">Domicilio de entrega:</p>
            <p style="text-align: center;">{{ $domicilio->domicilio }}</p>
            <p style="text-align: center;">Telefono:</p>
            <p style="text-align: center;">{{ $domicilio->telefono }}</p>
            <p style="text-align: center;">Observaciones:</p>
            <p style="text-align: center;">{{ $domicilio->observaciones }}</p>
        </div>
    @endif
</div>
