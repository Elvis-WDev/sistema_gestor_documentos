<aside class="main-sidebar" id="sidebar-wrapper">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ Auth::user()->url_img == '' ? 'https://www.uniquemedical.com.au/wp-content/uploads/2024/03/Default_pfp.svg.png' : asset(Auth::user()->url_img) }}"
                    class="img-circle" alt="User Image" />
            </div>
            <div class="pull-left info">
                <p>{{ Auth::user()->NombreUsuario }}</p>
                {{-- @if (Auth::guest())
                    <p>{{ config('settings.system_title') }}</p>
                @else
                    <p>{{ Auth::user()->name }}</p>
                @endif --}}
                <!-- Status -->
                <a href="{{ route(config('rol')[Auth::user()->id_rol] . '.perfil.edit') }}"><i
                        class="fa fa-circle text-success"></i> {{ config('rol')[Auth::user()->id_rol] }}</a>
            </div>
        </div>

        <!-- search form (Optional) -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Buscar..." />
                <span class="input-group-btn">
                    <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i
                            class="fa fa-search"></i>
                    </button>
                </span>
            </div>
        </form>
        <!-- Sidebar Menu -->

        <ul class="sidebar-menu" data-widget="tree">
            @include('layouts.menu')
        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
