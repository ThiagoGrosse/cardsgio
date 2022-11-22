<?= $render('head'); ?>

<body>

    <?= $render('header'); ?>

    <main>
        <div class="container">
            <div class="row mt-5">
                <div class="col w-25">
                    <div class="content-img-produto" id="slide-img-produto"></div>
                </div>
                <div class="col dados-pg-produto">
                    <h1 id="titulo-produto"></h1>
                    <div class="preco-pg-produto">
                        <p>R$
                            <span id="preco-pg-item"></span>
                        </p>
                    </div>
                    <div class="qt-pg-produto">
                        <span>Quantidade:</span>
                        <input type="number" class="input-qt-pg-produto" min="1" value="1" onchange="atualizaQtPgItem(this)">
                    </div>
                    <div class="total-pg-produto">
                        <p>Valor total: R$
                            <span id="total-pg-item"></span>
                        </p>
                    </div>
                    <div class="mt-5 mb-5">
                        <button class="comprarProduto">Comprar</button>
                    </div>

                </div>
            </div>
<hr>
            <div class="row mt-5">
                <h4 id="titulo-produto-desc" class="mb-5"></h4>
                <div class="desc-produto">
                    <p id="desc-produto">

                    </p>
                </div>
            </div>
        </div>
    </main>

    <?php
    $render('footer');
    $render('script');
    ?>

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script src="<?= $base; ?>/assets/js/produto.js"></script>

    <input type="text" class="ocultar" id="link-diretório" value="<?= $base; ?>" disabled>
</body>

</html>