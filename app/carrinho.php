<?php

session_start();

require_once 'views/head.php';
require_once 'controller/calculaCarrinho.php';
if (isset($_SESSION['carrinho'])) {

    $quantidadeCarrinho = array_sum(array_column($_SESSION['carrinho'], 'quantidade'));
} else {
    $quantidadeCarrinho = 0;
}
$nomePagina = explode('/', $_SERVER['REQUEST_URI']);
?>

<body class="bg-gradient-light <?php if ($nomePagina[2] == 'carrinho') {
                                    echo 'full-body';
                                } ?>">
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-black">
            <div class="container">
                <a class="navbar-brand" href="<?php echo URL::getBase(); ?>">Card's Gio</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample08" aria-controls="navbarsExample08" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-end" id="navbarsExample08">
                    <ul class="navbar-nav">
                        <li class="nav-item link-carrinho">
                            <a class="nav-link active" href="#"><i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i><sup><?php echo $quantidadeCarrinho; ?></sup></a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">
            <?php if (!empty($_SESSION['carrinho'])) { ?>
                <div class="row">
                    <table class="table table-carrinho">
                        <thead>
                            <th colspan="2">Produto</th>
                            <th>Preço (R$)</th>
                            <th>Quantidade</th>
                            <th>Total (R$)</th>
                        </thead>
                        <tbody>
                            <?php

                            foreach ($_SESSION['carrinho'] as $i) { ?>
                                <tr>
                                    <td><img src="<?php echo $i['img']; ?>" width="100" height="100"></td>
                                    <td><?php echo $i['nome']; ?></td>
                                    <td><?php echo str_replace(".", ",", $i['valor']); ?></td>
                                    <td><input class="input-qt" type="number" min="1" id="<?php echo $i['sku']; ?>" value="<?php echo $i['quantidade']; ?>" onchange="att_qt('<?php echo $i['sku']; ?>','<?php echo $i['sku'] . strtotime(date('H:i:s')); ?>')"></td>
                                    <td id="<?php echo $i['sku'] . strtotime(date("H:i:s")); ?>"><?php echo str_replace('.', ',', $i['total']); ?></td>
                                    <td><button type="button" class="remove-item-carrinho" onclick="removeItem('<?php echo $i['sku']; ?>')"><i class="fa fa-times"></i></button></td>
                                </tr>
                            <?php
                            } ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="buttons">
                        <a href="<?php echo URL::getBase(); ?>"><button type="button" class="btn btn-primary">Continuar comprando</button></a>
                        <button type="button" class="btn btn-danger" onclick="limpaCarrinho('<?php echo $i['sku'] ?>')">Limpar carrinho</button>
                        <div class="result-total-pedido">
                            <div class="total-carrinho d-flex justify-content-end">
                                <p>Valor total do pedido: <span id="total-pedido"> R$ <?php echo calculaCarrinho(); ?></span></p>
                            </div>
                            <div class="total-carrinho d-flex justify-content-end">
                                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                    Fechar pedido
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php
            } else { ?>
                <div class="msg-carrinho">
                    <div class="row">
                        <div class="aling-icon">
                            <i class="fa fa-frown-o fa-4x"></i>
                        </div>
                    </div>
                    <span>Seu carrinho está vazio</span><a href="<?php echo URL::getBase(); ?>"><button class="btn btn-primary">Voltar página inicial</button></a>
                </div>
            <?php } ?>
        </div>
    </main>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Concluir pedido</h5>
                </div>
                <div class="modal-body">
                    <form id="form-pedido">
                        <label for="nome">Nome</label>
                        <input class="form-control" type="text" id="nome" name="nome" required>
                        <label for="email">Email</label>
                        <input class="form-control" type="text" id="email" name="email" required>
                        <label for="contato">Telefone para contato</label>
                        <input class="form-control" type="text" id="contato" name="contato" required>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
                            <button class="btn btn-success">Enviar pedido</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <?php
    require_once 'views/rodape.php';
    ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

    <script type="text/javascript">
        function att_qt(sku, id) {
            var qt = $("#" + sku).val()

            var obj = {
                sku: sku,
                qt: qt
            }

            $.ajax({
                url: 'app/controller/carrinho.php',
                type: 'POST',
                data: obj,
                dataType: 'json',
                success: function(data) {
                    if (data[0].tipo == 'Error') {
                        $("#" + id).html(data[0].msg)
                        $("#" + id).css('color', 'red')
                        $("#total-pedido").html(' - ')

                    } else {
                        $("#" + id).html(data[0].msg)
                        $("#" + id).css('color', '#000')
                        $("#total-pedido").html('R$ ' + data.carrinho)
                    }
                },
                error: function(error) {
                    console.log(error)
                }
            })

        }

        function limpaCarrinho() {
            $.ajax({
                url: 'app/controller/limpaCarrinho.php',
                type: 'POST',
                dataType: 'JSON',
                success: function(data) {
                    console.log(data)
                    location.reload()
                }
            })
        }

        function removeItem(sku) {
            var obj = {
                sku: sku
            }
            $.ajax({
                url: 'app/controller/removeItem.php',
                type: 'POST',
                data: obj,
                dataType: 'JSON',
                success: function(data) {
                    console.log(data)
                    location.reload()
                }
            })
        }

        $("#form-pedido").submit(function(e) {
            e.preventDefault()

            var obj = {
                nome: $("#nome").val(),
                email: $("#email").val(),
                contato: $("#contato").val()
            }

            $.ajax({
                url: 'app/controller/criaPedido.php',
                type: 'POST',
                data: obj,
                dataType: 'json',
                success: function(data) {
                    console.log(data)
                    if (data.Sucesso) {
                        Swal.fire({
                            icon: 'success',
                            title: data.Sucesso,
                            text: "Entraremos em contato para combinar pagamento e entrega da(s) carta(s)",
                            confirmButtonText: 'Concluir'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload()
                            }
                        })
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Opppss...',
                            text: data.Erro,
                            confirmButtonText: 'Concluir'
                        })
                    }

                }
            })
        })
    </script>