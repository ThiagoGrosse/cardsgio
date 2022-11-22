<?php $render('head'); ?>

<body class="sb-nav-fixed">

    <?= $render('navbar'); ?>

    <div id="layoutSidenav_content">

        <main>
            <div class="container-fluid px-4">
                <div class="d-flex justify-content-between m-2">
                    <h4 class="title-page mt-4 mb-4">Categorias</h4>
                </div>
                <div class="row">

                    <div class="content-button-criar-categoria mt-4">
                        <button type="button" class="btn btn-primary w-20" data-bs-toggle="modal" data-bs-target="#inclirCategoria">
                            Incluir categoria
                        </button>
                    </div>

                    <!-- Modal cadastra categoria -->
                    <div class="modal fade" id="inclirCategoria" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="inclirCategoriaLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered w-50">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="inclirCategoriaLabel">Incluir categoria</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST" id="form-cadastra-categoria" name="form-cadastra-categoria">
                                        <div class="form-floating mb-3">
                                            <select class="form-select" id="nivel-categoria" aria-label="Nivel categoria">
                                            </select>
                                            <label for="nivel-categoria">Selecione o nível da categoria</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="nome-categoria" placeholder="Nome da Categoria">
                                            <label for="nome-categoria">Nome da categoria</label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="status-categoria" checked>
                                            <label class="form-check-label" for="status-categoria">Ativo</label>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- Lista de categorias -->
                    <div class="accordion w-75" id="acordeon-categorias">
                    </div>

                    <!-- Modal Edita categoria -->
                    <div class="modal fade" id="editarCategoria" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editarCategoriaLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered w-50">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editarCategoriaLabel">Incluir categoria</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="" method="POST" id="form-edita-categoria" name="form-edita-categoria">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" id="edit-nome-categoria" placeholder="Nome da Categoria">
                                            <label for="nome-categoria">Nome da categoria</label>
                                        </div>
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" role="switch" id="edit-status-categoria">
                                            <label class="form-check-label" for="edit-status-categoria">Ativo</label>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-primary">Salvar</button>
                                        </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </main>

        <?= $render('footer'); ?>
    </div>
    </div>

    <?php $render('scripts'); ?>
    <script src="assets/js/categorias.js"></script>
</body>

</html>