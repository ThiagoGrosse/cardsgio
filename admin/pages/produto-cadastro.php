<?php
session_start();

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

                <div class="panel panel-primary">
                    <div class="panel-heading">Cadastro de Produtos</div>
                </div>
                <form id="form-cadastro-produto">

                    <div class="form-group">
                        <label class="control-label" for="titulo">Titulo</label>
                        <div class="col-md-10">
                            <input id="titulo" name="titulo" class="form-control input-md" required type="text">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="conjunto">Conjunto</label>
                        <div class="col-md-4">
                            <input id="conjunto" name="conjunto" placeholder="" class="form-control input-md" required type="text">
                        </div>

                        <label class="control-label" for="condicao">Condição</label>
                        <div class="col-md-4">
                            <select name="condicao" id="condicao" class="form-control">
                                <option value="#" disabled selected>-- Selecione --</option>
                                <option value="super-rara">Super-Rara</option>
                                <option value="rara">Rara</option>
                                <option value="comum">Comum</option>
                                <option value="dourada">Dourada</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label" for="preco">Preço</label>
                        <div class="col-md-2">
                            <input id="preco" name="preco" placeholder="0,00" class="form-control input-md" required type="text">
                        </div>

                        <label class="control-label" for="estoque">Estoque</label>
                        <div class="col-md-2">
                            <input id="estoque" name="estoque" placeholder="" class="form-control input-md" required type="text">
                        </div>

                        <label class="control-label" for="img">Imagem</label>
                        <div class="col-md-4">
                            <input id="img" name="img" placeholder="" class="form-control input-md" required type="file">
                        </div>
                        <button class="btn btn-success">Salvar produto</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php require_once 'views/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        $(document).ready(function() {
            $("#form-cadastro-produto").submit(function(e) {
                e.preventDefault();

                var dados = new FormData(this);

                $.ajax({
                    url: 'controller/cadastra-produto.php',
                    data: dados,
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data) {
                        if(data.Sucesso){
                            alertaCadastro('success', data.Sucesso)
                        }else{
                            alertaCadastro('error', data.Erro)
                        }
                    }
                })
            })
        })

        function alertaCadastro(icon,title) {
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