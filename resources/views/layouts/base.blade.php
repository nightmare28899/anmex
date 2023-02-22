<!DOCTYPE html>
<html lang='en' dir="{{ Route::currentRouteName() == 'rtl' ? 'rtl' : '' }}">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('assets') }}/img/logo-anmexcolor.png">
    <link rel="icon" type="image/png" href="{{ asset('assets') }}/img/logo-anmexcolor.png">
    <title>
        ANMEX
    </title>
    <!--     Fonts and icons     -->
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
    <!-- Nucleo Icons -->
    <link href="{{ asset('assets') }}/css/nucleo-icons.css" rel="stylesheet" />
    <link href="{{ asset('assets') }}/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
    <!-- CSS Files -->
    <link id="pagestyle" href="{{ asset('assets') }}/css/material-dashboard.css?v=3.0.0" rel="stylesheet" />
    <link href="{{ asset('css') }}/app.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    @livewireStyles
</head>

<body
    class="g-sidenav-show {{ Route::currentRouteName() == 'rtl' ? 'rtl' : '' }} {{ Route::currentRouteName() == 'register' || Route::currentRouteName() == 'static-sign-up' ? '' : 'bg-gray-200' }}">

    {{ $slot }}

    <script src="{{ asset('assets') }}/js/core/popper.min.js"></script>
    <script src="{{ asset('assets') }}/js/core/bootstrap.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins/smooth-scrollbar.min.js"></script>
    @stack('js')
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>
    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
    <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('assets') }}/js/material-dashboard.min.js?v=3.0.0"></script>
    @livewireScripts

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script>
        window.addEventListener('alert', event => {
            /* alert(event.detail.message); */
            /* console.log(event.detail.message); */
            switch (event.detail.message) {
                case '¡Chofer creado correctamente!':
                case '¡Auto creado correctamente!':
                case '¡Cliente creado correctamente!':
                case '¡Domicilio de entrega creado correctamente!':
                case '¡Guía creada correctamente!':
                case '¡PDF Generado correctamente!':
                case '¡Chofer agregado!':
                case '¡Chofer agregado correctamente!':
                    toastr.success(event.detail.message, '¡Exito!');
                    break;
                case '¡Chofer eliminado correctamente!':
                case '¡Auto eliminado correctamente!':
                case '¡Cliente eliminado correctamente!':
                case '¡Domicilio de entrega eliminado correctamente!':
                case '¡Guía inactiva correctamente!':
                case '¡Todos los campos son requeridos!':
                case '¡No se ha seleccionado ninguna guía!':
                case '¡Falta el domicilio!':
                    toastr.error(event.detail.message, '¡Alerta!');
                    break;
                    toastr.warning(event.detail.message, '¡Alerta!');
                    break;
                case '¡Chofer actualizado correctamente!':
                case '¡Auto actualizado correctamente!':
                case '¡Cliente actualizado correctamente!':
                case '¡Domicilio de entrega actualizado correctamente!':
                case '¡Guía actualizada correctamente!':
                case '¡Estatus actualizado correctamente!':
                    toastr.info(event.detail.message, '¡Actualizado!');
                    break;
                default:
                    /* toastr.warning(event.detail.message, 'Error'); */
                    break;
            }
        });
    </script>
    <script>
        window.addEventListener('close-modal', event => {
            $('#modal').modal('hide');
            $('#modalDelete').modal('hide');
            $('#modalClient').modal('hide');
        });
    </script>
</body>

</html>
