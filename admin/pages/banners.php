<?php
session_start();

$time = base64_encode(strtotime(date('Y-m-d H:i:s')));

require_once 'views/head.php'; ?>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <?php require_once 'views/menu-lateral.php'; ?>

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <?php require_once 'views/menu-top.php'; ?>

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <div class="update-banner">
                    <h4>Upload Banner</h4>
                    <form id="formBanner" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="file" id="banenr" name="banner" class="form-control" required>
                            <div class="col-md-4">
                                <select name="ordem" id="ordem" class="form-control">
                                    <option value="#" selected disabled>Ordem</option>
                                    <option value="1">1°</option>
                                    <option value="2">2°</option>
                                    <option value="3">3°</option>
                                </select>
                            </div>
                            <button class="btn btn-primary">Enviar</button>
                        </div>
                        <span>* Tamanho do banner deve ser 1300x350 pixels</span>
                    </form>
                </div>
                <div class="banners">
                    <div class="title-banner">
                        <h4>Banner 01</h4>
                    </div>
                    <img src="../assets/img/banners/banner01.jpg?<?php echo $time?>" alt="Banner01" width="1300" height="350">
                    <div class="title-banner">
                        <h4>Banner 02</h4>
                    </div>
                    <img src="../assets/img/banners/banner02.jpg?<?php echo $time?>" alt="Banner02" width="1300" height="350">
                    <div class="title-banner">
                        <h4>Banner 03</h4>
                    </div>
                    <img src="../assets/img/banners/banner03.jpg?<?php echo $time?>" alt="Banner03" width="1300" height="350">
                </div>
            </div>
        </div>
    </div>
    </div>

    <?php require_once 'views/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        $("#formBanner").submit(function(e) {
            e.preventDefault();

            var dados = new FormData(this);

            $.ajax({
                url: 'controller/atualizaBanner.php',
                data: dados,
                type: 'POST',
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(data) {
                    if (data.Sucesso) {
                        alertaAtualizacaoBanner("success", data.Sucesso)
                    } else {
                        alertaAtualizacaoBanner("error", data.Erro)
                    }
                }
            })
        })

        function alertaAtualizacaoBanner(icon, title) {
            Swal.fire({
                icon: icon,
                title: title,
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload()
                }
            })
        }
    </script>