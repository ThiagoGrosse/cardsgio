<?= $render('head'); ?>

<body>

    <?= $render('header'); ?>

    <main>

        <?= $render('carrinho'); ?>


        <!-- Carrousel de banner -->

        <section id="carouselBanners" class="carousel slide carousel-fade carousel-dark" data-bs-ride="carousel" data-bs-ride="true">
        </section>

        <!-- Regua -->
        <section class="bgClaro mb-5 mt-5">
            <div class="container">
                <div class="regua d-flex justify-content-between">
                    <div class="item-regua-fill mb-3 mt-3">
                        <img src="assets/icons/compra-segura.png" alt="Compra Segura">
                        <div class="texto-regua">
                            <h5>Compra Segura</h5>
                            <span class="small">Garantimos segurança de seus dados</span>
                        </div>
                    </div>
                    <div class="item-regua-fill mb-3 mt-3">
                        <img src="assets/icons/atendimento.png" alt="Atendimento">
                        <div class="texto-regua">
                            <h5>Atendimento Direto e Fácil</h5>
                            <span class="small">Atendimento direto pelo WhatsApp</span>
                        </div>
                    </div>
                    <div class="item-regua-fill mb-3 mt-3">
                        <img src="assets/icons/preco-baixo.png" alt="Compra Segura">
                        <div class="texto-regua">
                            <h5>Preço Baixo</h5>
                            <span class="small">Menores preços</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Mini Banner -->
        <section class="container">
            <div class="content-mini-banner mb-5 mt-5">
                <div class="mini-banner">
                    <img src="" id="mini-banner-01" alt="Mini Banner 01">
                </div>
                <div class="mini-banner">
                    <img src="" id="mini-banner-02" alt="Mini Banner 02">
                </div>
            </div>
        </section>


        <!-- Produtos Destaque -->
        <section class="container" id="produtosDestaques">
        </section>

        <!-- Banner Médio -->
        <section class="container">
            <div class="content-banner-medio mt-5 mb-5">
                <img id="banner-medio" src="" alt="Banner Medio">
            </div>
        </section>


        <!-- Produtos Destaque 02 -->

        <div class="container" id="produtosDestaques2">
        </div>

    </main>

    <?php
    $render('footer');
    $render('script');
    ?>

    <script type="text/javascript" src="https://code.jquery.com/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

    <script src="<?= $base; ?>/assets/js/home.js"></script>



</body>

</html>