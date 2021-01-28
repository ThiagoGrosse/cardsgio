<?php
$url = $_SERVER['REQUEST_URI'];
$pagina = explode("/", $url);
$semParams = explode("?", $pagina[3]);
?>
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-black sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo URL::getBase(); ?>">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?php if (!$pagina[3]) {
                            if ($pagina[2] == "admin") {
                                echo "active";
                            }
                        } ?>">
        <a class="nav-link" href="<?php echo URL::getBase(); ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Produtos
    </div>

    <li class="nav-item <?php if ($pagina[3] == "produto-cadastro") {
                            echo "active";
                        } ?>">
        <a class="nav-link" href="<?php echo URL::getBase(); ?>produto-cadastro">
            <i class="fas fa-pen"></i>
            <span>Cadastrar</span></a>
    </li>

    <li class="nav-item <?php if ($pagina[3] == "produtos" || $semParams[0] == 'produtos') {
                            echo "active";
                        } ?>">
        <a class="nav-link" href="<?php echo URL::getBase(); ?>produtos">
            <i class="fas fa-cubes"></i>
            <span>Produtos</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
        Vendas
    </div>

    <li class="nav-item <?php if ($pagina[3] == "pedidos" || $semParams[0] == 'pedidos') {
                            echo "active";
                        } ?>">
        <a class="nav-link" href="<?php echo URL::getBase(); ?>pedidos">
            <i class="fas fa-file"></i>
            <span>Pedidos</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Configurações
    </div>

    <li class="nav-item <?php if ($pagina[3] == "banners") {
                            echo "active";
                        } ?>">
        <a class="nav-link" href="<?php echo URL::getBase(); ?>banners">
            <i class="fas fa-eye"></i>
            <span>Banner's</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->