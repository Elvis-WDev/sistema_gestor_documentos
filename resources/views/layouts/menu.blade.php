<li class="{{ setActive(['dashboard']) }}">
    {{-- <a href="{!! route('admin.dashboard') !!}"><i class="fa fa-home"></i><span>Home</span></a> --}}
    <a href="{{ route('dashboard') }}"><i class="fa-solid fa-gauge"></i><span>
            Dashboard</span></a>
</li>
<li class="{{ setActive(['usuarios']) }}">
    {{-- <a href="{!! route('admin.dashboard') !!}"><i class="fa fa-home"></i><span>Home</span></a> --}}
    <a href="{{ route('usuarios') }}"><i class="fa-solid fa-users"></i></i><span>
            Usuarios</span></a>
</li>
<li class="treeview active">
    <a href="#">
        <i class="fa-solid fa-folder-open"></i>
        <span>Documentos</span>
        <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
        </span>
    </a>
    <ul class="treeview-menu">
        <li class="{{ setActive(['facturas']) }}">
            <a href="{{ route('facturas') }}"><i class="fa-regular fa-file-lines"></i><span>
                    Facturas</span></a>
        </li>
        <li class="{{ setActive(['pagos']) }}">
            <a href="{{ route('pagos') }}"><i class="fa-solid fa-dollar-sign"></i><span>
                    Pagos</span></a>
        </li>
        <li class="{{ setActive(['notas-credito']) }}">
            <a href="{{ route('notas-credito') }}"><i class="fa-brands fa-creative-commons-share"></i><span> Notas de
                    créditos</span></a>
        </li>
        <li class="{{ setActive(['solicitud-afiliados']) }}">
            <a href="{{ route('solicitud-afiliados') }}"><i class="fa-solid fa-user-check"></i><span> Solicitudes de
                    afilación</span></a>
        </li>
        <li class="{{ setActive(['retenciones']) }}">
            <a href="{{ route('retenciones') }}"><i class="fa-solid fa-hand-holding-dollar"></i><span>
                    Retenciones</span></a>
        </li>
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
            <a href="{{ route('configuraciones') }}"><i class="fa-solid fa-sliders"></i><span> Generales</span></a>
        </li>
        <li class="{{ setActive(['custom-module']) }}">
            <a href="{{ route('custom-module') }}"><i class="fa-solid fa-file-pdf"></i><span> Archivos</span></a>
        </li>
    </ul>
</li>

{{-- @can('read users')
    <li class="{{ Request::is('admin/users*') ? 'active' : '' }}">
        <a href="{!! route('users.index') !!}"><i class="fa fa-users"></i><span>Users</span></a>
    </li>
@endcan
@can('read tags')
    <li class="{{ Request::is('admin/tags*') ? 'active' : '' }}">
        <a href="{!! route('tags.index') !!}"><i
                class="fa fa-tags"></i><span>{{ ucfirst(config('settings.tags_label_plural')) }}</span></a>
    </li>
@endcan
@can('viewAny', \App\Document::class)
    <li class="{{ Request::is('admin/documents*') ? 'active' : '' }}">
        <a href="{!! route('documents.index') !!}"><i
                class="fa fa-file"></i><span>{{ ucfirst(config('settings.document_label_plural')) }}</span></a>
    </li>
@endcan
{{-- @if (auth()->user()->is_super_admin) --}}
{{-- <li class="treeview {{ Request::is('admin/advanced*') ? 'active' : '' }}">
        <a href="#">
            <i class="fa fa-info-circle"></i>
            <span>Advanced Settings</span>
            <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
            <li class="{{ Request::is('admin/advanced/settings*') ? 'active' : '' }}">
                <a href="{!! route('settings.index') !!}"><i class="fa fa-gear"></i><span>Settings</span></a>
            </li>
            <li class="{{ Request::is('admin/advanced/custom-fields*') ? 'active' : '' }}">
                <a href="{!! route('customFields.index') !!}"><i class="fa fa-file-text-o"></i><span>Custom Fields</span></a>
            </li>
            <li class="{{ Request::is('admin/advanced/file-types*') ? 'active' : '' }}">
                <a href="{!! route('fileTypes.index') !!}"><i
                        class="fa fa-file-o"></i><span>{{ ucfirst(config('settings.file_label_singular')) }}
                        Types</span></a>
            </li>
        </ul>
    </li> --}}
{{-- @endif --}}
