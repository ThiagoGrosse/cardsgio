<?php $paginaAtual = $GLOBALS['pagina-atual']; ?>

<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="index.html">Card's Gio</a>

    <!-- Sidebar Toggle-->
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!"><i class="fas fa-bars"></i></button>

</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <a class="nav-link <?php if ($paginaAtual == "") {
                                            echo 'active';
                                        } ?>" href="<?= $base; ?>">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <a class="nav-link collapsed <?php if ($paginaAtual == "produtos" || $paginaAtual == "categorias") {
                                                        echo 'active';
                                                    } ?>" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
                        <div class="sb-nav-link-icon"><i class="fas fa-boxes"></i></div>
                        Produtos
                        <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                        <nav class="sb-sidenav-menu-nested nav">
                            <a class="nav-link" href="<?= $base; ?>/produtos">Lista de produtos</a>
                            <a class="nav-link" href="<?= $base; ?>/categorias">Categorias</a>
                        </nav>
                    </div>
                    <a class="nav-link" href="<?=$base;?>/pedidos">
                        <div class="sb-nav-link-icon"><i class="fas fa-briefcase"></i></div>
                        Pedidos
                    </a>
                    <a class="nav-link" href="<?= $base; ?>/banners">
                        <div class="sb-nav-link-icon"><i class="fas fa-image"></i></div>
                        Banners
                    </a>


                    <hr class="sidebar-divisor">

                    <a class="nav-link" href="<?= $base; ?>/logout">
                        <div class="sb-nav-link-icon"><i class="fa fa-sign-out-alt"></i></div>
                        Logout
                    </a>
                </div>
            </div>
            <div class="sb-sidenav-footer">
                <div class="small">Logado como:</div>
                Thiago Grosse
            </div>
        </nav>
    </div>