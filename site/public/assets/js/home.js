var limitador = 5

/**
 * Imprime itens destaque
 */
buscaProdutosDestaque = () => {

    fetch(consultaProdutosDestaque).then((res) => {

        res.json().then((data) => {

            var slide = '<div class="destaqueProdutos01 mb-5 mt-5">'
            var totalItens = data.msg.destaque.length
            var ItensDestaque = data.msg.destaque


            for (i = 0; i < totalItens; i++) {


                var preco = ItensDestaque[i].preco
                var preco2 = preco.replace('.', ',')

                slide += `
                <div class="mySlide">
                    <div class="card" style="width: 15rem;">
                        <div class="image">
                            <a class="link-card" href="${baseUrlProduto}produto/${ItensDestaque[i].sku}" title="Ver Produto">
                                <img src="${urlImagem}/${ItensDestaque[i].imagemPrincipal}" class="card-img-top" alt="${ItensDestaque[i].titulo}">    
                            </a>
                            <button
                                type="button"
                                class="btn-comprar"
                                onclick="adicionaProdutoCarrinho('${ItensDestaque[i].sku}')" 
                                data-bs-toggle="offcanvas"
                                data-bs-target="#telaCarrinho" 
                                aria-controls="telaCarrinho"
                            >
                                Comprar
                            </button>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">${ItensDestaque[i].titulo}</h5>
                            <p class="card-text">R$ <span>${preco2}</span></p>
                        </div>
                    </div>
                </div>`
            }

            document.querySelector('#produtosDestaques').innerHTML = slide + '</div>'


            var slide2 = '<div class="destaqueProdutos02 mb-5 mt-5">'
            var totalItens2 = data.msg.destaque2.length
            var ItensDestaque2 = data.msg.destaque2


            for (i = 0; i < totalItens2; i++) {


                var preco = ItensDestaque2[i].preco
                var preco2 = preco.replace('.', ',')

                slide2 += `
                <div class="mySlide">
                    <div class="card" style="width: 15rem;">
                        <div class="image">
                            <a class="link-card" href="${baseUrlProduto}produto/${ItensDestaque2[i].sku}" title="Ver Produto">
                                <img src="${urlImagem}/${ItensDestaque2[i].imagemPrincipal}" class="card-img-top" alt="${ItensDestaque2[i].titulo}">
                            </a>
                            <button
                                type="button"
                                class="btn-comprar"
                                onclick="adicionaProdutoCarrinho('${ItensDestaque2[i].sku}')" 
                                data-bs-toggle="offcanvas"
                                data-bs-target="#telaCarrinho" 
                                aria-controls="telaCarrinho"
                            >
                                Comprar
                            </button>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">${ItensDestaque2[i].titulo}</h5>
                            <p class="card-text">R$ <span>${preco2}</span></p>
                        </div>
                    </div>
                </div>`
            }

            document.querySelector('#produtosDestaques2').innerHTML = slide2 + '</div>'

            $(".destaqueProdutos01").slick({
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 1
            })

            $(".destaqueProdutos02").slick({
                infinite: true,
                slidesToShow: 4,
                slidesToScroll: 1
            })
        })
    })
}

/**
 * Busca Banners
 */
buscaBanners = () => {
    getBanner().then(data => {

        var full = data.msg.full
        var mini = data.msg.mini
        var medio = data.msg.medio

        document.querySelector("#mini-banner-01").src = baseBanner + mini[0].diretorio
        document.querySelector("#mini-banner-02").src = baseBanner + mini[1].diretorio

        document.querySelector("#banner-medio").src = baseBanner + medio[0].diretorio

        var bannerFull = ``

        bannerFull += `<div class="carousel-inner">`

        /**
         * Monta os banners
         */
        for (x = 0; x < full.length; x++) {

            if (x == 0) {
                bannerFull += ` <div class="carousel-item active">
                                    <a href="${full[x].link}">
                                        <img src="${baseBanner + full[x].diretorio}" class="d-block w-100" alt="Banner 01">
                                    </a>
                                </div>`
            } else {

                bannerFull += ` <div class="carousel-item">
                                    <a href="${full[x].link}">
                                        <img src="${baseBanner + full[x].diretorio}" class="d-block w-100" alt="Banner ${x}">
                                    </a>
                                </div>`
            }
        }

        bannerFull += ` </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#carouselBanners" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselBanners" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>`

        document.querySelector("#carouselBanners").innerHTML = bannerFull

    })
}

/**
 * Verifica se existe itens no carrinho
 */
verificaCarrinho = () => {

    var itensCarrinho = document.querySelectorAll('.item-carrinho .id-produto-carrinho')

    if (itensCarrinho.length <= 1) {

        document.querySelector('#carrinhoVazio').style.display = 'block'
    } else {
        document.querySelector('#carrinhoVazio').style.display = 'none'
    }
}

buscaProdutosDestaque()
verificaCarrinho()
buscaCategorias()
buscaBanners()