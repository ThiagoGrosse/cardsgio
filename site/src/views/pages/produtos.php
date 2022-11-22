<?= $render('head'); ?>

<body>

    <?= $render('header'); ?>

    <main>
        <div class="models">
            <div class="card" style="width: 15rem;">
                <div class="image">
                    <a class="link-card" href="" title="Ver Produto">
                        <img src="" class="card-img-top" alt="">
                    </a>
                    <button type="button" class="btn-comprar">
                        Comprar
                    </button>
                </div>
                <div class="card-body">
                    <h5 class="card-title"></h5>
                    <p class="card-text">R$ <span></span></p>
                </div>
            </div>
        </div>
        <div class="container">
            <div id="paginate">
                <div class="list d-flex justify-content-between flex-wrap mt-5 mb-5">
                </div>
                <div class="pagination-footer">
                    <div class="controls">
                        <div class="first">
                            <i class="fa fa-angle-double-left"></i>
                        </div>
                        <div class="prev">
                            <i class="fa fa-angle-left"></i>
                        </div>
                        <div class="numbers">
                            <div>1</div>
                        </div>
                        <div class="next">
                            <i class="fa fa-angle-right"></i>
                        </div>
                        <div class="last">
                            <i class="fa fa-angle-double-right"></i>
                        </div>
                    </div>
                    <span class="small">Exibindo <span id="perPage"></span> produtos de <span id="totalPage"></span></span>
                </div>
            </div>
        </div>
        </div>

    </main>

    <?php
    $render('footer');
    $render('script');
    ?>

    <script src="<?= $base; ?>/assets/js/produtos.js"></script>

</body>

</html>