/**
 * Adiciona produtos ao carrinho
 */
adicionaProdutoCarrinho = (sku) => {

    buscaProdutoID(sku).then(data => {

        carrinho.setCarrinho(sku)

        // adicionar tela carrinho

        let procurarIDProduto = document.querySelector(`[id='${sku}']`)

        if (procurarIDProduto == null) {

            let itemCarrinho = document.querySelector('.exemple .item-carrinho').cloneNode(true)

            itemCarrinho.id = data.msg.SKU
            itemCarrinho.querySelector('.id-produto-carrinho img').src = `${urlImagem}/${data.imagens.img_01}`
            itemCarrinho.querySelector('.id-produto-carrinho img').setAttribute('alt', data.msg.tituloProduto)
            itemCarrinho.querySelector('.titulo-produto-carrinho span').innerHTML = data.msg.tituloProduto
            itemCarrinho.querySelector('span .fa-times').addEventListener('click', () => {
                removerItemCarrinho(data.msg.SKU)
            })
            itemCarrinho.querySelector('.qtItemCarrinho').addEventListener('change', (e) => {

                var quantidadeAtual = e.target.value

                atualzaValorTotalProduto(data.msg.SKU, quantidadeAtual)
                atualizaValorTotalCarrinho()
            })
            itemCarrinho.querySelector('.qtItemCarrinho').value = 1
            itemCarrinho.querySelector('.qtItemCarrinho').setAttribute('min', 1)
            itemCarrinho.querySelector('.qtItemCarrinho').setAttribute('max', data.msg.saldo)
            itemCarrinho.querySelector('.preco-produto-carrinho span').innerHTML = data.msg.preco.replace('.', ',')
            itemCarrinho.querySelector('.total-produto span').innerHTML = data.msg.preco.replace('.', ',')

            document.querySelector('#lista-produtos-carrinho').append(itemCarrinho)

            atualizaValorTotalCarrinho()
        } else {

            // Pega preco e quantidade atual
            var quantidadeAtual = procurarIDProduto.querySelector('.qtItemCarrinho').value
            var valorAtual = procurarIDProduto.querySelector('.total-produto span').innerHTML.replace(',', '.')

            // Trabalha os valore e calcula novo valor
            var novaQuantidade = parseInt(quantidadeAtual) + 1
            var ajustePreco = parseFloat(valorAtual)
            var valorAtualizado = ajustePreco * novaQuantidade
            valorAtualizado = valorAtualizado.toFixed(2)

            // Atualiza dados na página
            procurarIDProduto.querySelector('.qtItemCarrinho').value = novaQuantidade
            procurarIDProduto.querySelector('.total-produto span').innerHTML = valorAtualizado.replace('.', ',')

            atualizaValorTotalCarrinho()
        }
        verificaCarrinho()
    })
}

/**
 * Remove produto do carrinho
 */
removerItemCarrinho = (sku) => {

    let itemRemover = document.querySelector(`[id='${sku}']`)

    itemRemover.remove()

    atualizaValorTotalCarrinho()
}

/**
 * Atualiza valor total por produto
 */
atualzaValorTotalProduto = (sku, qt) => {

    var itemCarrinho = document.querySelector(`[id='${sku}']`)
    var preco = itemCarrinho.querySelector('.preco-produto-carrinho span')
    var getPreco = preco.innerHTML.replace(',', '.')

    getPreco = parseFloat(getPreco)

    var precoTotal = getPreco * qt

    itemCarrinho.querySelector('.total-produto span').innerHTML = precoTotal.toFixed(2).replace('.', ',')
}

/**
 * Atualiza Valor total do carrinho
 */
atualizaValorTotalCarrinho = () => {


    let todosOsPreços = document.querySelectorAll('.total-produto span')
    let total = 0
    let preco = 0

    for (i = 1; i < todosOsPreços.length; i++) {

        preco = todosOsPreços[i].innerHTML.replace(',', '.')
        let preco2 = parseFloat(preco)

        total = total + preco2
    }

    var novoTotal = total.toFixed(2)
    novoTotal = 'R$ ' + novoTotal.replace('.', ',')

    document.querySelector('.total-carrinho span').innerHTML = novoTotal
}

/**
 * Imprime categorias
 */
buscaCategorias = () => {

    categorias().then(data => {

        if (data.tipo == 'sucesso') {

            var categorias = data.msg
            var maxCat = 4
            var linkCat = ''

            for (i = 0; i < maxCat; i++) {

                var sub = categorias[i].subcategorias

                linkCat += `<li class="nav-item item-menu-categoria">
                                <a class="nav-link link-cat-menu" href="${baseUrlProduto}categoria/${categorias[i].id_principal}">${categorias[i].titulo}</a>`

                if (sub.length > 0) {

                    linkCat += `<ul class="navbar-nav subLista">`

                    for (a = 0; a < sub.length; a++) {
                        linkCat += `<li class="nav-item">
                                        <a class="link-subcat-menu" href="${baseUrlProduto}categoria/${sub[a].id_sub}">${sub[a].subcategoria}</a>
                                    </li>`
                    }

                    linkCat += `</ul>`
                }

                linkCat += `</li>`

            }

            if (categorias.length > maxCat) {

                linkCat += `<li class="nav-item item-menu-categoria">
                                <a class="nav-link link-cat-menu" href="">Mais Categorias</a>
                                <ul class="navbar-nav subLista">`

                for (x = maxCat; x < categorias.length; x++) {

                    linkCat += `<li class="nav-item">
                                        <a class="link-subcat-menu" href="${baseUrlProduto}categoria/${categorias[x].id_principal}">${categorias[x].titulo}</a>
                                </li>`
                }

                linkCat += `      </ul>
                            </li>`
            }

            document.querySelector('#lista-categorias').innerHTML = linkCat
        }
    })
}

/**
 * Busca valor do Cookie
 */
getCookie = (cname) => {
    let name = cname + "=";
    let decodedCookie = decodeURIComponent(document.cookie);
    let ca = decodedCookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

let cookies = document.cookie

let cookieCarrinho = getCookie('tokenCarrinho')


/**
 * Adiciona Item
 */
const carrinho = {
    setCarrinho(sku) {

        let getTokenCarrinho = getCookie('tokenCarrinho')

        if (!getTokenCarrinho) {

            let obj = {
                token: null,
                sku: sku
            }

            carrinho.request(obj)


            //document.cookie = `tokenCarrinho=${criarCarrinho}`

        } else {

            carrinho.updateCarrinho(sku, getTokenCarrinho)
        }


    },
    updateCarrinho(sku, tokenCarrinho) {

        let obj = {
            token: tokenCarrinho,
            sku: sku
        }

        carrinho.request(obj)

    },
    deleteCarrinho(token) {

    },
    removerProdutoCarrinho(sku) {

    },
    request(obj) {

        $.ajax({
            url: criaCarrinho,
            data: JSON.stringify(obj),
            type: 'POST',
            contentType: 'application/json',
            processData: false,
            success: function (data) {

                if (cookieCarrinho === data.msg) {

                    console.log('data.msg')
                } else {

                    // cria cookie do token do carrinho
                    // document.cookie = `tokenCarrinho=${criarCarrinho}`
                }

            }, error: function (error) {
                console.log(error)
            }
        })
    }
}

console.log(cookieCarrinho)