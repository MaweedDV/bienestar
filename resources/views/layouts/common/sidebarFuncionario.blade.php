<nav id="sidebar" aria-label="Main Navigation">
    <div class="bg-header-dark">
        <div class="content-header bg-white-5">
            <a class="fw-semibold text-white tracking-wide" href="{{ route('backendFuncionario.index') }}">
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
                            <a class="nav-main-link{{ request()->is('pages/datatables') ? ' active' : '' }}"
                                href="{{ route('backendFuncionario.index') }}">
                                <i class="nav-main-link-icon si si-home"></i>
                                <span class="nav-main-link-name">Inicio</span>
                            </a>
                        </li>
                <li class="nav-main-heading">Módulos</li>
                <li class="nav-main-item{{ request()->is('pages/*') ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="true" href="#">
                        <i class="nav-main-link-icon fa fa-fire-flame-curved"></i>
                        <span class="nav-main-link-name">Gas Bienestar</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('pages/datatables') ? ' active' : '' }}"
                                href="{{ route('solicitudFuncionario.index') }}">
                                <i class="nav-main-link-icon fa fa-file-pen"></i>
                                <span class="nav-main-link-name">Solicitudes de Gas</span>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-main-heading">Opciones de usuario</li>
                <li class="nav-main-item{{ request()->is('pages/*') ? ' open' : '' }}">
                    <a class="nav-main-link nav-main-link-submenu" data-toggle="submenu" aria-haspopup="true"
                        aria-expanded="true" href="#">
                        <i class="nav-main-link-icon fa fa-circle-user"></i>
                        <span class="nav-main-link-name">Mi perfil</span>
                    </a>
                    <ul class="nav-main-submenu">
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('pages/datatables') ? ' active' : '' }}"
                                href="{{route('perfilFuncionario.index')}}">
                                <i class="nav-main-link-icon fa fa-clipboard-user"></i>
                                <span class="nav-main-link-name">Información Personal</span>
                            </a>
                        </li>
                        <li class="nav-main-item">
                            <a class="nav-main-link{{ request()->is('pages/slick') ? ' active' : '' }}"
                                href="/pages/slick">
                                <i class="nav-main-link-icon fa fa-lock"></i>
                                <span class="nav-main-link-name">Cambiar contraseña</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
