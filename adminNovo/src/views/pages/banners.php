<?php $render('head'); ?>

<body class="sb-nav-fixed">

    <?= $render('navbar'); ?>

    <div id="layoutSidenav_content">

        <main>
            <div class="container-fluid mt-4 px-4">
                <h4 class="title-page mb-4">Banners</h4>

                <!-- Banner Principal -->
                <div class="bannerPrincipal content-btn-collapse mb-5">
                    <button class="btn btn-collapse" type="button" data-bs-toggle="collapse" data-bs-target="#bannerPrincipal" aria-expanded="false" aria-controls="bannerPrincipal">
                        Banner Full Desktop
                    </button>
                </div>
                <div class="collapse mt-3" id="bannerPrincipal">

                    <!-- Banner full 01 -->
                    <form action="" id="form-banner-full-01" name="formBannerFull01" class="mb-3" method="POST" enctype="multipart/form-data">

                        <div class="content-input">
                            <div class="content-inputs w-50">
                                <div class="mb-3">
                                    <label for="bannerFull01" class="form-label">
                                        <h4>Banner Full 01</h4>
                                    </label>
                                    <input type="file" class="form-control form-control-sm" id="bannerFull01" name="bannerFull01" onchange="previewBannerFull(this)" accept="image/png, image/jpeg">
                                </div>
                                <div class="mb-3">
                                    <input class="form-control form-control-sm" type="text" name="link-banner-full-01" id="link-banner-full-01" placeholder="Link">
                                </div>
                            </div>
                            <div class="content-button">
                                <button class="btn btn-salva-banner" type="submit">Salvar</button>
                            </div>
                        </div>
                        <div class="exibeImagem">
                            <img id="preView-banner-full-01" src="assets/img/banners/banner01.jpg" alt="">
                        </div>

                    </form>

                    <!-- Banner full 02 -->
                    <form action="" id="form-banner-full-02" class="mb-3" name="formBannerFull02" method="POST" enctype="multipart/form-data">

                        <div class="content-input">
                            <div class="content-inputs w-50">
                                <div class="mb-3">
                                    <label for="bannerFull02" class="form-label">
                                        <h4>Banner Full 02</h4>
                                    </label>
                                    <input type="file" class="form-control form-control-sm" id="bannerFull02" name="bannerFull02" onchange="previewBannerFull(this)" accept="image/png, image/jpeg">
                                </div>
                                <div class=" mb-3">
                                    <input class="form-control form-control-sm" type="text" name="link-banner-full-02" id="link-banner-full-02" placeholder="Link">
                                </div>
                            </div>
                            <div class="content-button">
                                <button class="btn btn-salva-banner" type="submit">Salvar</button>
                            </div>
                        </div>
                        <div class="exibeImagem">
                            <img id="preView-banner-full-02" src="assets/img/banners/banner02.jpg" alt="">
                        </div>

                    </form>

                    <!-- Banner full 03 -->
                    <form action="" id="form-banner-full-03" class="mb-3" name="formBannerFull03" method="POST" enctype="multipart/form-data">

                        <div class="content-input">
                            <div class="content-inputs w-50">
                                <div class="mb-3">
                                    <label for="bannerFull03" class="form-label">
                                        <h4>Banner Full 03</h4>
                                    </label>
                                    <input type="file" class="form-control form-control-sm" id="bannerFull03" name="bannerFull03" onchange="previewBannerFull(this)" accept="image/png, image/jpeg">
                                </div>
                                <div class=" mb-3">
                                    <input class="form-control form-control-sm" type="text" name="link-banner-full-03" id="link-banner-full-03" placeholder="Link">
                                </div>
                            </div>
                            <div class="content-button">
                                <button class="btn btn-salva-banner" type="submit">Salvar</button>
                            </div>
                        </div>
                        <div class="exibeImagem">
                            <img id="preView-banner-full-03" src="assets/img/banners/banner03.jpg" alt="">
                        </div>

                    </form>
                </div>

                <!-- Mini Banners -->
                <div class="miniBanners content-btn-collapse mb-5">
                    <button class="btn btn-collapse" type="button" data-bs-toggle="collapse" data-bs-target="#miniBanners" aria-expanded="false" aria-controls="miniBanners">
                        Mini Banner
                    </button>
                </div>
                <div class="collapse mt-3" id="miniBanners">

                    <!-- Mini Banner 01 -->
                    <form action="" id="form-mini-banner-01" class="mb-3" name="form-mini-banner-01" method="POST" enctype="multipart/form-data">

                        <div class="content-input">
                            <div class="content-inputs w-50">
                                <div class="mb-3">
                                    <label for="mini-banner-01" class="form-label">
                                        <h4>Mini Banner 01</h4>
                                    </label>
                                    <input class="form-control form-control-sm" id="mini-banner-01" type="file" name="mini-banner-01" onchange="previewBannerMini(this)" accept="image/png, image/jpeg">
                                </div>
                                <div class="mb-3">
                                    <input class="form-control form-control-sm" type="text" id="link-mini-banner-01" name="link-mini-banner-01" placeholder="Link">
                                </div>
                            </div>
                            <div class="content-button">
                                <button class="btn btn-salva-banner" type="submit">Salvar</button>
                            </div>
                        </div>
                        <div class="exibeImagem">
                            <img id="preView-mini-banner-01" src="" alt="">
                        </div>

                    </form>

                    <!-- Mini Banner 02 -->
                    <form action="" id="form-mini-banner-02" class="mb-3" name="form-mini-banner-02" method="POST" enctype="multipart/form-data">

                        <div class="content-input">
                            <div class="content-inputs w-50">
                                <div class="mb-3">
                                    <label for="mini-banner-02" class="form-label">
                                        <h4>Mini Banner 02</h4>
                                    </label>
                                    <input class="form-control form-control-sm" id="mini-banner-02" type="file" name="mini-banner-02" onchange="previewBannerMini(this)" accept="image/png, image/jpeg">
                                </div>
                                <div class="mb-3">
                                    <input class="form-control form-control-sm" type="text" id="link-mini-banner-02" name="link-mini-banner-02" placeholder="Link">
                                </div>
                            </div>
                            <div class="content-button">
                                <button class="btn btn-salva-banner" type="submit">Salvar</button>
                            </div>
                        </div>
                        <div class="exibeImagem">
                            <img id="preView-mini-banner-02" src="" alt="">
                        </div>

                    </form>
                </div>


                <!-- Banners Médio -->
                <div class="bannerMedio content-btn-collapse mb-5">
                    <button class="btn btn-collapse" type="button" data-bs-toggle="collapse" data-bs-target="#bannerMedio" aria-expanded="false" aria-controls="bannerMedio">
                        Banner Médio
                    </button>
                </div>
                <div class="collapse mt-3" id="bannerMedio">

                    <!-- Banner Medio -->
                    <form action="" id="form-banner-medio" class="mb-3" name="form-banner-medio" method="POST" enctype="multipart/form-data">

                        <div class="content-input">
                            <div class="content-inputs w-50">
                                <div class="mb-3">
                                    <label for="mini-banner-01" class="form-label">
                                        <h4>Banner Medio</h4>
                                    </label>
                                    <input class="form-control form-control-sm" id="banner-medio" type="file" name="banner-medio" onchange="previewBannerMedio(this)" accept="image/png, image/jpeg">
                                </div>
                                <div class="mb-3">
                                    <input class="form-control form-control-sm" type="text" id="link-banner-medio" name="link-banner-medio" placeholder="Link">
                                </div>
                            </div>
                            <div class="content-button">
                                <button class="btn btn-salva-banner" type="submit">Salvar</button>
                            </div>
                        </div>
                        <div class="exibeImagem">
                            <img id="preView-banner-medio" src="" alt="">
                        </div>

                    </form>
                </div>
        </main>

        <?= $render('footer'); ?>
    </div>
    </div>

    <?php $render('scripts'); ?>

    <script src="assets/js/banners.js" defer></script>
</body>

</html>