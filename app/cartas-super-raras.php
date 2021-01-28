<?php
include 'app/database/login.php';

$maximo = 20;

if (!empty($_GET['pagina'])) {
    $pagina = $_GET['pagina'];
} else {

    $pagina = "1";
}

$inicio = $pagina - 1;
$inicio = $maximo * $inicio;

$conn = dbON();

$query = 'SELECT pc.sku, pc.nome, pc.conjunto, pc.conjunto, pc.nome_img, pc.dir_img, ppe.estoque, ppe.preco FROM produto_cadastro pc 
    INNER JOIN produto_preco_estoque ppe ON pc.sku = ppe.sku
    WHERE ppe.estoque > 0
    AND pc.condicao = "super-raro"
    ORDER BY last_update DESC
    LIMIT ' . $inicio . ',' . $maximo;

$dados = $conn->query($query);
$result = mysqli_fetch_all($dados, MYSQLI_ASSOC);
$numRows = mysqli_num_rows($dados);

$conn->close();

require_once 'views/head.php';
require_once 'views/menu-top.php';
?>

<main>
    <div class="container">
        <div class="cardCartas">
            <div class="row" id="produtos">
                <?php if ($numRows > 0) {
                    foreach ($result as $i) {
                        $img = $i['dir_img'] . '/' . $i['nome_img'];
                ?>

                        <div class="card">
                            <img class="card-img-top" src="<?php echo $img; ?>" alt="<?php echo $i['nome']; ?>">
                            <div class="card-body">
                                <h4 class="card-title"><?php echo $i['nome'] ?></h4>
                                <p class="card-text">R$ <?php echo $i['preco']; ?></p>
                                <span>Coleção <?php echo $i['conjunto'] ?></span>
                            </div>
                            <button class="btn btn-success" onclick="carrinho('<?php echo $i['sku']; ?>','<?php echo $i['nome']; ?>','<?php echo $i['preco']; ?>','<?php echo $img; ?>')">Comprar <i class="fa fa-shopping-cart" aria-hidden="true"></i></button>
                        </div>

                <?php }
                }

                $menos = $pagina - 1;
                $mais = $pagina + 1;

                $pgs = ceil($numRows / $maximo);
                ?>

                <div class="container">
                    <?php

                    echo 'Página ' . $pagina . ' de ' . $pgs . ' - ' . $numRows . ' produtos';

                    ?>
                    <nav aria-label="Navegação de página exemplo">
                        <ul class="pagination justify-content-end">
                            <li class="page-item <?php if ($pagina == 1) {
                                                        echo 'disabled';
                                                    } ?>"><a class="page-link" href="<?php echo URL::getBase(); ?>cartas-semi-raras?pagina=<?php echo $menos; ?>">Anterior</a></li>
                            <?php
                            for ($i = 1; $i <= $pgs; $i++) {
                                $estilo = "";
                                if ($pagina == $i) {
                                    $estilo = "active";
                                }
                            ?>
                                <li class="page-item <?php echo $estilo ?>"><a class="page-link" href="<?php echo URL::getBase(); ?>cartas-semi-raras?pagina=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                            <?php } ?>
                            <li class="page-item <?php if ($pagina == $pgs) {
                                                        echo 'disabled';
                                                    } ?>"><a class="page-link" href="<?php echo URL::getBase(); ?>cartas-semi-raras?pagina=<?php echo $mais; ?>">Próximo</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</main>
<?php

require_once 'views/rodape.php';
?>

<script src="assets/js/jquery-3.5.1.min.js"></script>
<script type="text/javascript">
    function carrinho(sku, nome, preco, img) {

        var obj = {
            sku: sku,
            nome: nome,
            preco: preco,
            img: img,
            qt: 1
        }

        $.ajax({
            url: 'app/controller/adicionaCarrinho.php',
            type: 'POST',
            data: obj,
            dataType: 'json',
            success: function(data) {
                window.location.href = 'carrinho'
            }
        })

    }
</script>