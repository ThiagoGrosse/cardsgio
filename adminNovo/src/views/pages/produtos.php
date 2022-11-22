<?php $render('head'); ?>

<body class="sb-nav-fixed">

    <?= $render('navbar'); ?>

    <div id="layoutSidenav_content">

        <main>
            <div class="container-fluid px-4">
                <div class="d-flex justify-content-between mt-4 mb-3 aling-middle">
                    <h4 class="title-page">Produtos</h4>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#modalCadastro">Cadastrar Novo Produto</button>
                </div>
                <div class="row">

                    <div class="menu-pg-produtos mt-3">
                        <form action="" method="post" class="d-flex justify-content-between flex-wrap">
                            <div class="form-floating mb-3 w-20">
                                <input type="text" class="form-control" id="idProduct" placeholder="Informe o ID do Produto">
                                <label for="idProduct">ID Produto</label>
                            </div>
                            <div class="form-floating mb-3 w-75">
                                <input type="text" class="form-control" id="titleProduct" placeholder="Informe o nome do produto">
                                <label for="titleProduct">Título do produto</label>
                            </div>
                            <div class="form-floating mb-3 col-3">
                                <select class="form-select" id="selectCategoria" aria-label="Floating label select example">
                                </select>
                                <label for="selectCategoria">Filtrar por categoria</label>
                            </div>
                            <div class="form-floating mb-3 col-3">
                                <select class="form-select" id="selectStatusProduto" aria-label="Floating label select example">
                                    <option selected>Todos</option>
                                    <option value="1">Ativo</option>
                                    <option value="0">Inativo</option>
                                </select>
                                <label for="selectStatusProduto">Filtrar por status</label>
                            </div>
                            <div class="form-floating mb-3 col-3">
                                <select class="form-select" id="selectingDestaque" aria-label="Floating label select example">
                                    <option selected>Todos</option>
                                    <option value="destaque">Destaque 01</option>
                                    <option value="destaque_02">Destaque 02</option>
                                </select>
                                <label for="selectingDestaque">Filtrar por destaque</label>
                            </div>
                            <div class="buttons-filter-products d-flex justify-content-between w-20 mb-3">
                                <button class="btn btn-primary" type="button">Limpar Filtro</button>
                                <button class="btn btn-success" type="submit">Filtrar</button>
                            </div>
                        </form>
                    </div>

                </div>
                <div class="row">
                    <div class="mt-3 p-3" id="tabela-produtos">
                    </div>
                </div>

                <!-- Modal Cadastro Produto -->
                <div class="modal fade" id="modalCadastro" tabindex="-1" role="dialog" aria-labelledby="modalCadastroTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Modal title</h5>
                                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="cadastrarProduto" name="cadastrarProduto" action="" method="post" enctype="multipart/form-data">
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="form-floating mb-3 w-100">
                                            <input type="text" name="tituloProduto" class="form-control" id="tituloProduto" placeholder="Insira o título do produto" required>
                                            <label for="tituloProduto">Título do Produto</label>
                                        </div>
                                        <div class="form-floating mb-3 w-25">
                                            <input type="text" name="precoProduto" class="form-control" id="precoProduto" placeholder="Insira o preço do produto" required>
                                            <label for="precoProduto">Preço do Produto (R$)</label>
                                        </div>
                                        <div class="form-floating mb-3 w-25">
                                            <input type="number" name="saldoProduto" class="form-control" id="saldoProduto" placeholder="Insira o estoque do produto" min="0" value="0">
                                            <label for="saldoProduto">Estoque do Produto</label>
                                        </div>
                                        <div class="form-floating">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="destaque">
                                                <label class="form-check-label" for="destaque">Destacar produto primeira linha</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="destaque02">
                                                <label class="form-check-label" for="destaque02">Destacar produto segunda linha</label>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3 col-5">
                                            <select class="form-select" id="select-category" aria-label="Floating label select example" required>
                                            </select>
                                            <label for="select-category">Selecionar Categoria</label>
                                        </div>
                                        <div class="form-floating mb-3 col-5">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="statusProduto" checked>
                                                <label class="form-check-label" for="statusProduto">Ativo</label>
                                            </div>
                                        </div>
                                        <div class="form-floating w-100 mb-3">
                                            <textarea class="form-control" name="descricaoProduto" placeholder="Insira a descrição" id="descricaoProduto" style="height: 100px"></textarea>
                                            <label for="descricaoProduto">Descrição</label>
                                        </div>
                                        <div class="mb-3 w-100 d-flex justify-content-between flex-wrap">
                                            <label for="img-01">
                                                <img id="preview-01" class="label-img" src="assets/img/icon/sem-imagem.png" alt="sem imagem" title="Clique para importar imagem">
                                                <input type='file' name="img-01" id="img-01" accept="image/png, image/jpeg" onchange="previewImgUpload(this);" hidden />
                                            </label>
                                            <label for="img-02">
                                                <img id="preview-02" class="label-img" src="assets/img/icon/sem-imagem.png" alt="sem imagem" title="Clique para importar imagem">
                                                <input type='file' name="img-02" id="img-02" accept="image/png, image/jpeg" onchange="previewImgUpload(this);" hidden />
                                            </label>
                                            <label for="img-03">
                                                <img id="preview-03" class="label-img" src="assets/img/icon/sem-imagem.png" alt="sem imagem" title="Clique para importar imagem">
                                                <input type='file' name="img-03" id="img-03" accept="image/png, image/jpeg" onchange="previewImgUpload(this);" hidden />
                                            </label>
                                            <label for="img-04">
                                                <img id="preview-04" class="label-img" src="assets/img/icon/sem-imagem.png" alt="sem imagem" title="Clique para importar imagem">
                                                <input type='file' name="img-04" id="img-04" accept="image/png, image/jpeg" onchange="previewImgUpload(this);" hidden />
                                            </label>
                                            <label for="img-05">
                                                <img id="preview-05" class="label-img" src="assets/img/icon/sem-imagem.png" alt="sem imagem" title="Clique para importar imagem">
                                                <input type='file' name="img-05" id="img-05" accept="image/png, image/jpeg" onchange="previewImgUpload(this);" hidden />
                                            </label>
                                            <label for="img-06">
                                                <img id="preview-06" class="label-img" src="assets/img/icon/sem-imagem.png" alt="sem imagem" title="Clique para importar imagem">
                                                <input type='file' name="img-06" id="img-06" accept="image/png, image/jpeg" onchange="previewImgUpload(this);" hidden />
                                            </label>
                                        </div>
                                        <div class="mb-3 w-100 preview-img-uploaded d-flex justify-content-around flex-wrap">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary w-100 p-3">Salvar</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">Cancelar</button>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Edição de produto -->
                <div class="modal fade" id="modalEditProduto" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Editar Produto</h5>
                                <button type="button" class="close btn" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true"><i class="fa fa-times"></i></span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form id="form-edit-produto" name="form-edit-produto" action="" method="post" enctype="multipart/form-data">
                                    <div class="d-flex flex-wrap justify-content-between">
                                        <div class="form-floating mb-3 w-20">
                                            <input type="text" name="idProdutoEdicao" class="form-control" id="idProdutoEdicao" placeholder="Insira o título do produto" disabled>
                                            <label for="idProdutoEdicao">SKU Produto</label>
                                        </div>
                                        <div class="form-floating mb-3 w-75">
                                            <input type="text" name="editarTituloProduto" class="form-control" id="editarTituloProduto" placeholder="Insira o título do produto" required>
                                            <label for="editarTituloProduto">Título do Produto</label>
                                        </div>
                                        <div class="form-floating mb-3 w-25">
                                            <input type="text" name="editarPrecoProduto" class="form-control" id="editarPrecoProduto" placeholder="Insira o preço do produto" required>
                                            <label for="editarPrecoProduto">Preço do Produto</label>
                                        </div>
                                        <div class="form-floating mb-3 w-25">
                                            <input type="number" name="editarSaldoProduto" class="form-control" id="editarSaldoProduto" placeholder="Insira o estoque do produto" min="0" value="0">
                                            <label for="editarSaldoProduto">Estoque do Produto</label>
                                        </div>
                                        <div class="form-floating">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="editarDestaque">
                                                <label class="form-check-label" for="editarDestaque">Destacar produto primeira linha</label>
                                            </div>
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="editarDestaque02">
                                                <label class="form-check-label" for="editarDestaque02">Destacar produto segunda linha</label>
                                            </div>
                                        </div>
                                        <div class="form-floating mb-3 col-5">
                                            <select class="form-select" id="editCategoriaProduto" aria-label="Floating label select example" required>
                                            </select>
                                            <label for="editCategoriaProduto">Selecionar Categoria</label>
                                        </div>
                                        <div class="form-floating mb-3 col-5 mt-2">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="statusProdutoEditar">
                                                <label class="form-check-label" for="statusProdutoEditar">Exibir produto no site</label>
                                            </div>
                                        </div>
                                        <div class="form-floating w-100 mb-3">
                                            <textarea class="form-control" name="descricaoProdutoEdicao" placeholder="Insira a descrição" id="descricaoProdutoEdicao" style="height: 100px"></textarea>
                                            <label for="descricaoProdutoEdicao">Descrição</label>
                                        </div>
                                        <div class="mb-3 w-100 d-flex justify-content-between flex-wrap">
                                            <label for="edicaoImg01">
                                                <img id="preview-01-edicao" class="label-img" src="assets/img/icon/sem-imagem.png" alt="sem imagem" title="Clique para importar imagem">
                                                <input type='file' name="edicaoImg01" id="edicaoImg01" accept="image/png, image/jpeg" onchange="previewImgUploadEdition(this);" hidden />
                                            </label>
                                            <label for="edicaoImg02">
                                                <img id="preview-02-edicao" class="label-img" src="assets/img/icon/sem-imagem.png" alt="sem imagem" title="Clique para importar imagem">
                                                <input type='file' name="edicaoImg02" id="edicaoImg02" accept="image/png, image/jpeg" onchange="previewImgUploadEdition(this);" hidden />
                                            </label>
                                            <label for="edicaoImg03">
                                                <img id="preview-03-edicao" class="label-img" src="assets/img/icon/sem-imagem.png" alt="sem imagem" title="Clique para importar imagem">
                                                <input type='file' name="edicaoImg03" id="edicaoImg03" accept="image/png, image/jpeg" onchange="previewImgUploadEdition(this);" hidden />
                                            </label>
                                            <label for="edicaoImg04">
                                                <img id="preview-04-edicao" class="label-img" src="assets/img/icon/sem-imagem.png" alt="sem imagem" title="Clique para importar imagem">
                                                <input type='file' name="edicaoImg04" id="edicaoImg04" accept="image/png, image/jpeg" onchange="previewImgUploadEdition(this);" hidden />
                                            </label>
                                            <label for="edicaoImg05">
                                                <img id="preview-05-edicao" class="label-img" src="assets/img/icon/sem-imagem.png" alt="sem imagem" title="Clique para importar imagem">
                                                <input type='file' name="edicaoImg05" id="edicaoImg05" accept="image/png, image/jpeg" onchange="previewImgUploadEdition(this);" hidden />
                                            </label>
                                            <label for="edicaoImg06">
                                                <img id="preview-06-edicao" class="label-img" src="assets/img/icon/sem-imagem.png" alt="sem imagem" title="Clique para importar imagem">
                                                <input type='file' name="edicaoImg06" id="edicaoImg06" accept="image/png, image/jpeg" onchange="previewImgUploadEdition(this);" hidden />
                                            </label>
                                        </div>
                                        <div class="mb-3 w-100 preview-img-uploaded d-flex justify-content-around flex-wrap">
                                        </div>
                                    </div>
                                    <button type="submit" id="enviarEdicao" class="btn btn-primary w-100 p-3">Salvar</button>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary w-100" data-dismiss="modal">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
        </main>

        <?= $render('footer'); ?>
    </div>

    <?php $render('scripts'); ?>
    <script src="assets/js/produtos.js"></script>
</body>

</html>