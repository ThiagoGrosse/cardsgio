<?php

session_start();

require_once 'database/login.php';
require_once 'model/pedidos.php';

$maximo = 20;

$p = new Pedidos;

if (!empty($_GET['pedido'])) {
    $pedido = $_GET['pedido'];
} else {

    $pedido = "1";
}

$inicio = $pedido - 1;
$inicio = $maximo * $inicio;

if (!empty($_GET['id-pedido'])) {

    /**
     * Get orders by ID
     */

    $search = $_GET['id-pedido'];

    $dados = $p->getOrdersID($search, $inicio, $maximo);

    $total = $dados['total'];
    $result = $dados['result'];
    $numRows = $total;
} elseif (!empty($_GET['cliente'])) {

    if (!empty($_GET['status'])) {

        /**
         * Get orders by Cliente and Status
         */
        $cliente = $_GET['cliente'];
        $status = $_GET['status'];

        $dados = $p->getOrderClienteStatus($cliente, $status, $inicio, $maximo);

        $total = $dados['total'];
        $result = $dados['result'];
        $numRows = $total;
    } else {

        /**
         * Get orders by Cliente
         */
        $search = $_GET['cliente'];

        $dados = $p->getOrdersCliente($search, $inicio, $maximo);

        $total = $dados['total'];
        $result = $dados['result'];
        $numRows = $total;
    }
} elseif (!empty($_GET['status'])) {

    /**
     * Get orders by status
     */
    $search = $_GET['status'];

    $dados = $p->getOrderStatus($search, $inicio, $maximo);

    $total = $dados['total'];
    $result = $dados['result'];
    $numRows = $total;
} else {
    /**
     * Get all orders
     */
    $dados = $p->getAllOrders($inicio, $maximo);

    $result = $dados['result'];
    $numRows = $dados['numero_linhas'];
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

                <div class="search-pedido">
                    <form action="<?php echo URL::getBase() ?>pedidos?" method="GET">
                        <input type="text" id="pedido" name="id-pedido" class="input-search-pedidos" placeholder="ID Pedido">
                        <input type="text" id="cliente" name="cliente" class="input-search-pedidos" placeholder="Nome cliente">
                        <select name="status" id="status" class="input-search-pedidos">
                            <option value="#" disabled selected>Status</option>
                            <option value="aguardando-pagamento">Aguardando pagamento</option>
                            <option value="pago">Pago</option>
                            <option value="finalizado">Finalizado</option>
                            <option value="cancelado">Cancelado</option>
                        </select>
                        <button><i class="fa fa-search"></i></button>
                    </form>
                </div>
                <?php
                if ($numRows > 0) { ?>

                    <table class="table table-pedidos">
                        <thead>
                            <th>ID Pedido</th>
                            <th>Cliente</th>
                            <th>Status</th>
                            <th>Data</th>
                            <th>Valor</th>
                        </thead>
                        <tbody>
                            <?php foreach ($result as $i) {
                                $id_pedido = $i['id_pedido'];
                                $cliente = $i['cliente'];
                                $status_pedido = $i['status_pedido'];
                                $data_pedido = date("d/m/Y H:i:s", strtotime($i['data_pedido']));
                                $valor_pedido = str_replace(".", ",", $i['valor_pedido']);
                            ?>
                                <tr>
                                    <td><?php echo $id_pedido; ?></td>
                                    <td><?php echo $cliente; ?></td>
                                    <td><?php echo $status_pedido; ?></td>
                                    <td><?php echo $data_pedido; ?></td>
                                    <td><?php echo 'R$ ' . $valor_pedido; ?></td>
                                    <td>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#ordersModal" onclick="editarStatus('<?php echo $id_pedido; ?>', '<?php echo $cliente; ?>', '<?php echo $i['id_status']; ?>', '<?php echo $data_pedido; ?>', '<?php echo $valor_pedido; ?>')">
                                            <i class="fas fa-pencil-alt"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php
                }

                $menos = $pedido - 1;
                $mais = $pedido + 1;

                $pgs = ceil($numRows / $maximo);
                ?>
                <div class="container">
                    <?php
                    if (isset($total)) {
                        $linhas = $total;
                    } else {
                        $linhas  = $numRows;
                    }
                    echo 'Página ' . $pedido . ' de ' . $pgs . ' - ' . $linhas . ' pedidos';
                    ?>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-end">
                            <li class="page-item <?php if ($pedido == 1) {
                                                        echo 'disabled';
                                                    } ?>">
                                <a class="page-link" href="<?php echo URL::getBase(); ?>pedidos?pedido=<?php echo $menos; ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                                <?php
                                for ($i = 1; $i <= $pgs; $i++) {
                                    $estilo = "";
                                    if ($pedido == $i) {
                                        $estilo = "active";
                                    }
                                ?>
                            </li>
                            <li class="page-item <?php echo $estilo ?>"><a class="page-link" href="<?php echo URL::getBase(); ?>pedidos?pedido=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                        <?php } ?>

                        <li class="page-item <?php if ($pedido == $pgs) {
                                                    echo 'disabled';
                                                } ?>">
                            <a class="page-link" href="<?php echo URL::getBase(); ?>pedidos?pedido=<?php echo $i; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <!-- Modal -->
            <div class="modal fade" id="ordersModal" tabindex="-1" aria-labelledby="ordersModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="modalPedidos"></form>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    </div>
    </div>
    <!-- /.container-fluid -->

    </div>
    <!-- End of Main Content -->

    <?php require_once 'views/footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script>
        function editarStatus(idPedido, cliente, idStatus, dataPedido, valorPedido) {

            $.ajax({
                url: 'controller/buscaProdutosPedido.php',
                type: 'POST',
                data: {
                    'idPedido': idPedido
                },
                dataType: 'json',
                success: function(data) {

                    var dadosModalPedido = `
                                            <div class="modal-content-pedidos">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="ordersModalLabel">Pedido ${idPedido}</h5>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="info-group">
                                                        <label for="cliente">Cliente</label>
                                                        <div id="cliente">${cliente}</div>
                                                    </div>

                                                    <div class="div-group">
                                                        <div class="info-group">
                                                            <label for="data_pedido">Data</label>
                                                            <div id="data_pedido">${dataPedido}</div>
                                                        </div>

                                                        <div class="info-group">
                                                            <label for="valor_pedido">Valor</label>
                                                            <div id="valor_pedido">R$ ${valorPedido}</div>
                                                        </div>
                                                    </div>
                                                    <div class="select-status">
                                                        <input type="text" id="pedidoModal" name="pedidoModal" value="${idPedido}">
                                                        <label for="status">Status</label>
                                                        <select name="status" id="status">
                                                            <option value="#" selected disabled>Selecione</option>
                                                            <option value="APG">Aguardando Pagamento</option>
                                                            <option value="PAG">Pago</option>
                                                            <option value="ENT">Entregue</option>
                                                            <option value="CAN">Cancelado</option>
                                                        </select>
                                                    </div>                    
                                            <div class="table-produtos-pedido">
                                            <h6>Produtos</h6>
                                            <table class="table" id="table">
                                                <thead>
                                                    <th>ID</th>
                                                    <th>Título</th>
                                                    <th>Quantidade</th>
                                                    <th>Preço</th>
                                                </thead>
                                                <tbody>
                                            `

                    for (i = 0; i < data.length; i++) {

                        dadosModalPedido += `
                                            <tr>
                                                <td>${data[i].sku}</td>
                                                <td>${data[i].nome}</td>
                                                <td>${data[i].quantidade}</td>
                                                <td>R$ ${data[i].preco}</td>
                                            </tr>`
                    }

                    dadosModalPedido += `
                                            </tbody>
                                        </table>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                                            <button class="btn btn-success" >Salvar</button>
                                        </div>
                                        `


                    $("#modalPedidos").html(dadosModalPedido)
                }
            })

        }

        $("#modalPedidos").submit(function(e) {
            e.preventDefault()

            var obj = new FormData(this)

            $.ajax({
                url: "controller/atualizaPedido.php",
                type: "POST",
                data: obj,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(data) {

                    if (data.Sucesso) {
                        alertaStatusAtualizado('success', data.Sucesso)
                    } else {
                        alertaErroStatus('error', data.Erro)
                    }
                }
            })
        })

        function alertaStatusAtualizado(icon, title) {
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

        function alertaErroStatus(icon, title) {
            Swal.fire({
                icon: icon,
                title: title,
                confirmButtonText: 'Ok'
            })
        }
    </script>