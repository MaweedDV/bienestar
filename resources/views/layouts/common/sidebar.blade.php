<nav id="sidebar" aria-label="Main Navigation">
    <div class="bg-header-dark">
        <div class="content-header bg-white-5">
            <a class="fw-semibold text-white tracking-wide" href="/">
                <span class="smini-visible">
                    B<span class="opacity-75">TR</span>
                </span>
                <span class="smini-hidden">
                    BIENE<span class="opacity-75">STAR</span>
                </span>
            </a>
            <div>
                <button type="button" class="btn btn-sm btn-alt-secondary" data-toggle="class-toggle"
                    data-target="#dark-mode-toggler" data-class="far fa" onclick="Dashmix.layout('dark_mode_toggle');">
                    <i class="far fa-moon" id="dark-mode-toggler"></i>
                </button>
                <button type="button" class="btn btn-sm btn-alt-secondary d-lg-none" data-toggle="layout"
                    data-action="sidebar_close">
                    <i class="fa fa-times-circle"></i>
                </button>

            </div>
        </div>
    </div>
    <div class="js-sidebar-scroll">
        <!-- Side Navigation -->
        <div class="content-side content-side-full">
            <ul class="nav-main">
                <li class="nav-main-item">
                    <a class="nav-main-link{{ request()->is('dashboard') ? ' active' : '' }}" href="{{route("dashboard")}}">
                        <i class="nav-main-link-icon si si-home"></i>
                        <span class="nav-main-link-name">Inicio</span>
                    </a>
                </li>
                <li class="nav-main-heading">Administrador</li>
                <li class="nav-main-item{{ request()->is('pages/*') ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="true" href="#">
                        <i class="nav-main-link-icon fa fa-box-archive"></i>
                        <span class="nav-main-link-name">Mantenedores</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('pages/datatables') ? ' active' : '' }}"
                                href="{{ route('users.index') }}">
                                <i class="nav-main-link-icon fa fa-user-group"></i>
                                <span class="nav-main-link-name">Usuarios</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-main-heading">Módulos</li>
                <li class="nav-main-item{{ request()->is('pages/*') ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="true" href="#">
                        <i class="nav-main-link-icon fa fa-ticket"></i>
                        <span class="nav-main-link-name">Vales de Gas</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('pages/datatables') ? ' active' : '' }}"
                                href="{{ route('solicitudesDeGas.index') }}">
                                <i class="nav-main-link-icon fa fa-clipboard-list"></i>
                                <span class="nav-main-link-name">Solicitudes Ingresadas</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
