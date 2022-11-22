        <!-- Carrinho -->

        <div class="offcanvas offcanvas-end primarybg" tabindex="-1" id="telaCarrinho" aria-labelledby="telaCarrinhoDireita">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title electrolize" id="telaCarrinhoDireita">Carrinho</h5>
                <button type="button" class="btn-close-carrinho" data-bs-dismiss="offcanvas" aria-label="Close"><i class="fa fa-times"></i></button>
            </div>
            <div class="offcanvas-body">
                <div class="small mt-5 ms-5" id="carrinhoVazio">
                    Poxa! Seu carrinho está vazio.
                </div>
                <div class="exemple">
                    <li class="item-carrinho pb-2 pt-2">
                        <div class="id-produto-carrinho">
                            <img src="" alt="" width="50">
                            <div class="titulo-produto-carrinho"><span></span></div>
                            <span><i class="fa fa-times red"></i></span>
                        </div>
                        <div class="saldo-preco-carrinho">
                            <span class="small">Quantidade</span>
                            <input type="number" class="qtItemCarrinho">
                            <div class="preco-produto-carrinho small">R$ <span></span></div>
                            <div class="total-produto small">R$ <span></span></div>
                        </div>
                    </li>
                </div>
                <div id="itensCarrinho">
                    <ul class="lista-produtos-carrinho" id="lista-produtos-carrinho">

                    </ul>
                </div>
                <div class="content-button-carrinho">
                    <div class="total-carrinho pb-2 pt-2 mt-2 mb-2 small">Total da compra: <span> R$ 0,00</span></div>
                    <button type="button" class="btn btn-finaliza-carrinho w-100">Concluir Compra</button>
                </div>
            </div>
        </div>