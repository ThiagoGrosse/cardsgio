<?php

if (!$_SESSION['usuario']) {
    header('Location: ' . URL::getBase().'login');
    exit();
}

?>

<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

    <!-- Sidebar Toggle (Topbar) -->
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    <!-- Topbar Navbar -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" href="controller/logout.php">
                <p class="userName">Olá <?php echo $_SESSION['usuario']; ?> </p>
            </a>
        </li>

        <!-- Nav Item - User Information -->
        <li class="nav-item">
            <a class="nav-link" href="<?php echo URL::getBase(); ?>login">
                <i class="fa fa-sign-out-alt"></i>
                Logout
            </a>
        </li>

    </ul>

</nav>
<!-- End of Topbar -->