<?php
if (isset($_SESSION['carrinho'])) {
    $quantidadeCarrinho = array_sum(array_column($_SESSION['carrinho'], 'quantidade'));
} else {
    $quantidadeCarrinho = 0;
}
?>

<body class="bg-gradient-light">
    <header>

        <nav class="navbar navbar-expand-lg navbar-dark bg-black">
            <div class="container">
                <a class="navbar-brand" href="<?php echo URL::getBase(); ?>">Card's Gio</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarsExample08">
                    <ul class="navbar-nav">
                        <form class="form-inline" action="<?php echo URL::getBase(); ?>?a=buscar" method="GET">
                            <input class="form-control mr-sm-2" id="search" name="search" type="text" placeholder="Buscar carta" aria-label="Search">
                            <button class="btn btn-outline-success my-2 my-sm-0" type="submit"><i class="fa fa-search"></i></button>
                        </form>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Categorias
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="<?php echo URL::getBase(); ?>cartas-super-raras">Cartas Super Raras</a>
                                <a class="dropdown-item" href="<?php echo URL::getBase(); ?>cartas-raras">Cartas Raras</a>
                                <a class="dropdown-item" href="<?php echo URL::getBase(); ?>cartas-comuns">Cartas Comuns</a>
                                <a class="dropdown-item" href="<?php echo URL::getBase(); ?>cartas-douradas">Cartas Douradas</a>
                            </div>
                        </li>
                        <li class="nav-item link-carrinho">
                            <a class="nav-link active" href="<?php echo URL::getBase(); ?>carrinho"><i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i><sup><?php echo $quantidadeCarrinho; ?></sup></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="assets/img/banners/banner01.jpg" class="d-block w-100" width="1300" height="350" alt="banner01">
                </div>
                <div class="carousel-item">
                    <img src="assets/img/banners/banner02.jpg" class="d-block w-100" width="1300" height="350" alt="banner02">
                </div>
                <div class="carousel-item">
                    <img src="assets/img/banners/banner03.jpg" class="d-block w-100" width="1300" height="350" alt="banner03">
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </header>