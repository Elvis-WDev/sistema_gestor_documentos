<header class="main-header">

    <!-- Logo -->
    <a href="" class="hidden-xs logo">
        <span class="logo-mini"><b></b></span>
        <span class="logo-lg"><b></b></span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>

        <span
            style="display: inline-block;width: 71vw;text-align: center;font-size: 20px;line-height: 50px;color: white;"
            class="visible-xs-inline-block">
            <b></b>
        </span>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{ Auth::user()->url_img == '' ? 'https://www.uniquemedical.com.au/wp-content/uploads/2024/03/Default_pfp.svg.png' : asset('storage/' . Auth::user()->url_img) }}"
                            class="user-image" alt="User Image" />
                        <!-- hidden-xs hides the username on small devices so only the image appears. -->
                        <span class="hidden-xs">
                            {!! Auth::user()->NombreUsuario !!}
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{ Auth::user()->url_img == '' ? 'https://www.uniquemedical.com.au/wp-content/uploads/2024/03/Default_pfp.svg.png' : asset('storage/' . Auth::user()->url_img) }}"
                                class="img-circle" alt="User Image" />
                            <p>
                                {!! Auth::user()->NombreUsuario !!}
                                <small>Miembro desde <br />
                                    @php
                                        echo Carbon\Carbon::parse(Auth::user()->created_at)->translatedFormat(
                                            'd \d\e F \d\e Y',
                                        );
                                    @endphp
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left" style="margin:10px">
                                <a href="{{ route('perfil.edit') }}" class="btn btn-default btn-flat">Perfil</a>
                            </div>
                            <div class="pull-right" style="margin:10px">
                                <a href="{!! url('/logout') !!}" class="btn btn-default btn-flat"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Cerrar sesión
                                </a>
                                <form id="logout-form" action="{{ url('/logout') }}" method="POST"
                                    style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
