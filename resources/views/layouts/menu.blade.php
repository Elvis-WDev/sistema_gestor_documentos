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
            <li class="{{ setActive(['usuarios']) }}">
                <a href="{{ route('usuarios') }}"><i class="fas fa-users"></i><span>
                        Usuarios</span></a>
            </li>
            <li class="{{ setActive(['roles']) }}">
                <a href="{{ route('roles') }}"><i class="fas fa-users-cog"></i><span>
                        Roles</span></a>
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
        @can('ver facturas')
            <li class="{{ setActive(['facturas']) }}">
                <a href="{{ route('facturas') }}"><i class="fa-regular fa-file-lines"></i><span>
                        Facturas</span></a>
            </li>
        @endcan
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
