<li class="{{ setActive(['dashboard']) }}">
    {{-- <a href="{!! route('admin.dashboard') !!}"><i class="fa fa-home"></i><span>Home</span></a> --}}
    <a href="{{ route('dashboard') }}"><i class="fa-solid fa-gauge"></i><span>
            Dashboard</span></a>
</li>


@can('ver usuario')
    <li class="treeview active">
        <a href="#">
            <i class="fas fa-users"></i>
            <span>Usuarios</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ setActive(['usuarios', 'crear-usuario', 'editar-usuario']) }}">
                <a href="{{ route('usuarios') }}"><i class="fas fa-users"></i><span>
                        Usuarios</span></a>
            </li>
            <li class="{{ setActive(['roles', 'crear-rol', 'editar-rol']) }}">
                <a href="{{ route('roles') }}"><i class="fas fa-users-cog"></i><span>
                        Roles</span></a>
            </li>

        </ul>
    </li>
@endcan

@can('ver establecimiento')
    <li class="treeview">
        <a href="#">
            <i class="far fa-building"></i>
            <span>Establecimiento</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">

            <li class="{{ setActive(['establecimientos', 'crear-establecimiento', 'editar-establecimiento']) }}">
                <a href="{{ route('establecimientos') }}"><i class="far fa-building"></i><span>
                        Estasblecimiento</span>
                </a>
            </li>

        </ul>
    </li>
@endcan

@can('ver punto_emision')
    <li class="treeview">
        <a href="#">
            <i class="fa-solid fa-building-user"></i>
            <span>Punto emisión</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">

            <li class="{{ setActive(['punto_emision', 'crear-punto_emision', 'editar-punto_emision']) }}">
                <a href="{{ route('punto_emision') }}"> <i class="fa-solid fa-building-user"></i><span>
                        Punto de emisión</span>
                </a>
            </li>

        </ul>
    </li>
@endcan


@can('ver facturas')
    <li class="treeview active">
        <a href="#">
            <i class="fas fa-file-pdf"></i>
            <span>Facturas</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ setActive(['facturas', 'crear-factura', 'editar-factura']) }}">
                <a href="{{ route('facturas') }}"><span>
                        Todas</span>
                </a>
            </li>
            <li class="{{ setActive(['facturas-pagadas']) }}">
                <a href="{{ route('facturas-pagadas') }}"><span>
                        Pagadas</span>
                </a>
            </li>
            <li class="{{ setActive(['facturas-abonadas']) }}">
                <a href="{{ route('facturas-abonadas') }}"><span>
                        Abonadas</span>
                </a>
            </li>
            <li class="{{ setActive(['facturas-anuladas']) }}">
                <a href="{{ route('facturas-anuladas') }}"><span>
                        Anuladas</span>
                </a>
            </li>
            <li class="{{ setActive(['cuentas', 'abonos']) }}">
                <a href="{{ route('cuentas') }}"><span>
                        Cuentas</span>
                </a>
            </li>
            <li class="{{ setActive(['facturas-reportes']) }}">
                <a href="{{ route('facturas-reportes') }}"><span>
                        Reportes</span>
                </a>
            </li>
        </ul>
    </li>
@endcan

<li class="treeview active">
    <a href="#">
        <i class="fa-solid fa-folder-open"></i>
        <span>Documentos</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        @can('ver pagos')
            <li class="{{ setActive(['pagos']) }}">
                <a href="{{ route('pagos') }}">
                    <i class="fa-solid fa-dollar-sign"></i><span>
                        Pagos</span></a>
            </li>
        @endcan
        @can('ver NotasCredito')
            <li class="{{ setActive(['notas-credito']) }}">
                <a href="{{ route('notas-credito') }}"><i class="fa-brands fa-creative-commons-share"></i><span>
                        Notas de créditos</span></a>
            </li>
        @endcan
        @can('ver SolicitudAfiliado')
            <li class="{{ setActive(['solicitud-afiliados']) }}">
                <a href="{{ route('solicitud-afiliados') }}"><i class="fa-solid fa-user-check"></i><span>Solicitudes de
                        afilación</span></a>
            </li>
        @endcan
        @can('ver retenciones')
            <li class="{{ setActive(['retenciones']) }}">
                <a href="{{ route('retenciones') }}"><i class="fa-solid fa-hand-holding-dollar"></i><span>
                        Retenciones</span></a>
            </li>
        @endcan
    </ul>
</li>
<li class="treeview active">
    <a href="#">
        <i class="fa fa-gear"></i>
        <span>Configuraciones</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ setActive(['custom-module']) }}">
            <a href="{{ route('custom-module') }}"><i class="fa-solid fa-folder"></i><span>
                    Módulos</span></a>
        </li>
        <li class="{{ setActive(['configuraciones']) }}">
            <a href="{{ route('configuraciones') }}"><i class="fa-solid fa-sliders"></i><span>
                    Generales</span></a>
        </li>
        <li class="{{ setActive(['custom-module']) }}">
            <a href="{{ route('custom-module') }}"><i class="fa-solid fa-file-pdf"></i><span>
                    Archivos</span></a>
        </li>
    </ul>
</li>
