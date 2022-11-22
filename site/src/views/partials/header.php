    <header>
        <!-- Menu principal -->
        <nav class="navbar navbar-expand-lg primarybg menu-superior">
            <div class="container">
                <a class="navbar-brand electrolize link" href="<?= $base; ?>">Card's Gio</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <div class="content-menu-top">
                        <form class="d-flex w-50" role="search">
                            <input class="input-search me-2" type="search" placeholder="Digite aqui o que você procura" aria-label="Search">
                            <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                        </form>
                        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                            <button class="btn" type="button" data-bs-toggle="offcanvas" data-bs-target="#telaCarrinho" aria-controls="telaCarrinho">
                                <i class="fas fa-shopping-cart"></i>
                            </button>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Menu categorias -->
        <nav class="navbar navbar-expand-lg secundarybg">
            <div class="container">
                <ul class="navbar-nav justify-content-between d-flex w-100" id="lista-categorias">
                </ul>
            </div>
        </nav>

    </header>