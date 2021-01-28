<?php
session_start();

require_once 'database/login.php';

$maximo = 10;

if (!empty($_GET['paginaProduto'])) {
    $paginaProduto = $_GET['paginaProduto'];
} else {

    $paginaProduto = "1";
}

$inicio = $paginaProduto - 1;
$inicio = $maximo * $inicio;

if (!empty($_GET['sc-produto'])) {

    $search = $_GET['sc-produto'];

    $conn = dbON();

    $query = 'SELECT pc.sku, pc.nome, pc.conjunto, pc.condicao, pc.nome_img, pc.dir_img, ppe.estoque, ppe.preco FROM produto_cadastro pc 
                INNER JOIN produto_preco_estoque ppe ON pc.sku = ppe.sku
                WHERE pc.nome LIKE "%' . $search . '%" OR pc.conjunto LIKE "%' . $search . '%" OR pc.sku LIKE "%' . $search . '%" OR pc.condicao LIKE "%' . $search . '%"
                ORDER BY pc.last_update DESC
                LIMIT ' . $inicio . ',' . $maximo;

    $dados = $conn->query($query);
    $result = mysqli_fetch_all($dados, MYSQLI_ASSOC);
    $numRows = mysqli_num_rows($dados);

    $conn->close();

    $total = $numRows;
} else {
    $conn = dbON();

    $query = 'SELECT pc.sku, pc.nome, pc.condicao, pc.conjunto, pc.nome_img, pc.dir_img, ppe.estoque, ppe.preco FROM produto_cadastro pc 
                INNER JOIN produto_preco_estoque ppe ON pc.sku = ppe.sku
                ORDER BY pc.last_update DESC
                LIMIT ' . $inicio . ',' . $maximo;

    $dados = $conn->query($query);
    $result = mysqli_fetch_all($dados, MYSQLI_ASSOC);
    $numRows = mysqli_num_rows($dados);

    $numTotal = $conn->query('SELECT COUNT(pc.sku) as total FROM produto_cadastro pc 
                        INNER JOIN produto_preco_estoque ppe ON pc.sku = ppe.sku
                        WHERE ppe.estoque > 0
                        ORDER BY pc.last_update DESC');

    $rows = mysqli_fetch_assoc($numTotal);

    $conn->close();

    $total = $rows['total'];
}

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

                <div class="search-produto">
                    <form action="produtos?buscaProduto" method="GET">
                        <div class="form-group">
                            <input type="text" id="sc-produto" name="sc-produto" class="form-control" placeholder="Buscar Produto">
                            <button><i class="fa fa-search"></i></button>
                        </div>
                    </form>
                </div>
                <?php
                if ($numRows > 0) { ?>
                    <table class="table">
                        <thead>
                            <th>Sku</th>
                            <th>Título</th>
                            <th>Conjunto</th>
                            <th>Condição</th>
                            <th>Preço</th>
                            <th>Estoque</th>
                            <th>Imagem</th>
                            <th>Opções</th>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $i) {
                                $sku = $i['sku'];
                                $titulo = $i['nome'];
                                $conjunto = $i['conjunto'];
                                $condicao = $i['condicao'];
                                $img = '../' . $i['dir_img'] . '/' . $i['nome_img'] . '?' . strtotime(date('H:i:s'));
                                $preco = 'R$ ' . str_replace(".", ",", $i['preco']);
                                $estoque = $i['estoque'];
                            ?>
                                <tr>
                                    <td><?php echo $sku; ?></td>
                                    <td><?php echo $titulo; ?></td>
                                    <td><?php echo $conjunto; ?></td>
                                    <td><?php echo $condicao; ?></td>
                                    <td><?php echo $preco; ?></td>
                                    <td><?php echo $estoque; ?></td>
                                    <td><img src="<?php echo $img; ?>" alt="<?php echo $titulo; ?>" width="100" height="100"></td>
                                    <td>
                                        <button type="button" class="btn-function-table" data-bs-toggle="modal" data-bs-target="#modalEditProduto" onclick="editaProduto('<?php echo $sku; ?>', '<?php echo $titulo; ?>', '<?php echo $conjunto; ?>', '<?php echo $preco; ?>', '<?php echo $estoque; ?>')">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                        <button type="button" class="btn-function-table" onclick="removeProduto('<?php echo $sku; ?>')"><i class="fas fa-times-circle"></i></button>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                        </tbody>
                    </table>
                    <?php

                    $menos = $paginaProduto - 1;
                    $mais = $paginaProduto + 1;

                    $pgs = ceil($total / $maximo);
                    ?>
                    <div class="container">
                        <?php
                        if (isset($rows['total'])) {
                            $linhas = $rows['total'];
                        } else {
                            $linhas  = $numRows;
                        }
                        echo 'Página ' . $paginaProduto . ' de ' . $pgs . ' - ' . $linhas . ' produtos';
                        ?>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination justify-content-end">
                                <li class="page-item <?php if ($paginaProduto == 1) {
                                                            echo 'disabled';
                                                        } ?>">
                                    <a class="page-link" href="<?php echo URL::getBase(); ?>produtos?paginaProduto=<?php echo $menos; ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                    <?php
                                    for ($i = 1; $i <= $pgs; $i++) {
                                        $estilo = "";
                                        if ($paginaProduto == $i) {
                                            $estilo = "active";
                                        }
                                    ?>
                                </li>
                                <li class="page-item <?php echo $estilo ?>"><a class="page-link" href="<?php echo URL::getBase(); ?>produtos?paginaProduto=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php } ?>

                            <li class="page-item <?php if ($paginaProduto == $pgs) {
                                                        echo 'disabled';
                                                    } ?>">
                                <a class="page-link" href="<?php echo URL::getBase(); ?>produtos?paginaProduto=<?php echo $i; ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                            </ul>
                        </nav>
                    </div>
            </div>

        </div>
        <!-- /.container-fluid -->
        <!-- Modal -->
        <div class="modal fade" id="modalEditProduto" tabindex="-1" aria-labelledby="modalEditProdutoLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Editar produto</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id="form-edita-produto">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Main Content -->

    <?php require_once 'views/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        function editaProduto(sku, titulo, conjunto, preco, estoque) {

            var form = `
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" id="sku" name="sku" value="${sku}" disabled>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Titulo</span>
                                    <input type="text" class="form-control" id="titulo" name="titulo" value="${titulo}" autocomplete="off">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Conjunto</span>
                                    <input type="text" class="form-control" id="conjunto" name="conjunto" value="${conjunto}">
                                    <label class="input-group-text" for="condicao">Condição</label>
                                    <select class="form-select" id="condicao" name="condicao">
                                        <option disabled selected>Selecione</option>
                                        <option value="rara">Rara</option>
                                        <option value="semi-raro">Semi-rara</option>
                                        <option value="comum">Comum</option>
                                    </select>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-text">Preco</span>
                                    <input type="text" class="form-control" id="preco" name="preco" value="${preco}" autocomplete="off">
                                    <span class="input-group-text">Estoque</span>
                                    <input type="text" class="form-control" id="estoque" name="estoque" value="${estoque}" autocomplete="off">
                                </div>
                                <div class="input-group mb-3">
                                    <label class="input-group-text" for="file">Upload</label>
                                    <input type="file" class="form-control" id="file" name="img">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button class="btn btn-primary">Salvar alterações</button>
                                </div>`

            $("#form-edita-produto").html(form)
        }

        function removeProduto(sku) {

            var obj = {
                sku: sku
            }

            $.ajax({
                url: 'controller/removeProduto.php',
                type: 'POST',
                data: obj,
                dataType: 'json',
                success: function(data) {
                    if (data.Success) {
                        alertaRemoveProduto('success', data.Success)
                    } else {
                        alertaRemoveProduto('error', data.Erro)
                    }
                }
            })
        }

        $(document).ready(function() {
            $("#form-edita-produto").submit(function(e) {
                e.preventDefault();

                var sku = $("#sku").val()

                var obj = new FormData(this)

                obj.set("sku", sku)

                $.ajax({
                    url: 'controller/editarProduto.php',
                    type: 'POST',
                    data: obj,
                    type: 'POST',
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(data) {

                        var dados = `
                                <ul class="list-group">
                                        <li class="list-group-item">${data.produto}</li>
                                        <li class="list-group-item">${data.preco_estoque}</li>
                                        <li class="list-group-item">${data.imagem}</li>
                                        <li class="list-group-item">${data.condicao}</li>
                                </ul>
                                `

                        alertaEditaProduto(dados)
                    }
                })
            })
        })

        function alertaEditaProduto(dados) {
            Swal.fire({
                title: 'Relatório de atualização',
                html: dados,
                confirmButtonText: 'Ok'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload()
                }
            })
        }

        function alertaRemoveProduto(icon, title) {
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