<li class="{{ setActive([config('rol')[Auth::user()->id_rol] . '.dashboard']) }}">
    {{-- <a href="{!! route('admin.dashboard') !!}"><i class="fa fa-home"></i><span>Home</span></a> --}}
    <a href="{{ route(config('rol')[Auth::user()->id_rol] . '.dashboard') }}"><i class="fa-solid fa-gauge"></i><span>
            Dashboard</span></a>
</li>
@if (Auth::user()->id_rol == 1)
    <li class="{{ setActive([config('rol')[Auth::user()->id_rol] . '.usuarios']) }}">
        {{-- <a href="{!! route('admin.dashboard') !!}"><i class="fa fa-home"></i><span>Home</span></a> --}}
        <a href="{{ route(config('rol')[Auth::user()->id_rol] . '.usuarios') }}"><i
                class="fa-solid fa-users"></i></i><span>
                Usuarios</span></a>
    </li>
@endif

<li class="treeview active">
    <a href="#">
        <i class="fa-solid fa-folder-open"></i>
        <span>Documentos</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        @if (Auth::user()->id_rol == 1 || Auth::user()->id_rol == 2 || Auth::user()->id_rol == 3)
            <li class="{{ setActive([config('rol')[Auth::user()->id_rol] . '.facturas']) }}">
                <a href="{{ route(config('rol')[Auth::user()->id_rol] . '.facturas') }}"><i
                        class="fa-regular fa-file-lines"></i><span>
                        Facturas</span></a>
            </li>
        @endif
        @if (Auth::user()->id_rol == 1 || Auth::user()->id_rol == 2 || Auth::user()->id_rol == 3)
            <li class="{{ setActive([config('rol')[Auth::user()->id_rol] . '.pagos']) }}">
                <a href="{{ route(config('rol')[Auth::user()->id_rol] . '.pagos') }}">
                    <i class="fa-solid fa-dollar-sign"></i><span>
                        Pagos</span></a>
            </li>
        @endif
        @if (Auth::user()->id_rol == 1)
            <li class="{{ setActive([config('rol')[Auth::user()->id_rol] . '.notas-credito']) }}">
                <a href="{{ route(config('rol')[Auth::user()->id_rol] . '.notas-credito') }}"><i
                        class="fa-brands fa-creative-commons-share"></i><span>
                        Notas de
                        créditos</span></a>
            </li>
        @endif
        @if (Auth::user()->id_rol == 1 || Auth::user()->id_rol == 3)
            <li class="{{ setActive([config('rol')[Auth::user()->id_rol] . '.solicitud-afiliados']) }}">
                <a href="{{ route(config('rol')[Auth::user()->id_rol] . '.solicitud-afiliados') }}"><i
                        class="fa-solid fa-user-check"></i><span>
                        Solicitudes de
                        afilación</span></a>
            </li>
        @endif
        @if (Auth::user()->id_rol == 1)
            <li class="{{ setActive([config('rol')[Auth::user()->id_rol] . '.retenciones']) }}">
                <a href="{{ route(config('rol')[Auth::user()->id_rol] . '.retenciones') }}"><i
                        class="fa-solid fa-hand-holding-dollar"></i><span>
                        Retenciones</span></a>
            </li>
        @endif
    </ul>
</li>
@if (Auth::user()->id_rol == 1)
    <li class="treeview active">
        <a href="#">
            <i class="fa fa-gear"></i>
            <span>Configuraciones</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ setActive([config('rol')[Auth::user()->id_rol] . '.custom-module']) }}">
                <a href="{{ route('SuperAdmin.custom-module') }}"><i class="fa-solid fa-folder"></i><span>
                        Módulos</span></a>
            </li>
            <li class="{{ setActive([config('rol')[Auth::user()->id_rol] . '.configuraciones']) }}">
                <a href="{{ route('SuperAdmin.configuraciones') }}"><i class="fa-solid fa-sliders"></i><span>
                        Generales</span></a>
            </li>
            <li class="{{ setActive([config('rol')[Auth::user()->id_rol] . '.custom-module']) }}">
                <a href="{{ route('SuperAdmin.custom-module') }}"><i class="fa-solid fa-file-pdf"></i><span>
                        Archivos</span></a>
            </li>
        </ul>
    </li>
@endif
