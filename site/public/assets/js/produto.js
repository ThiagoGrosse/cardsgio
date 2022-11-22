var query = window.location.href.split("/")
var t = query.length
var id = query[t - 1];

getDadosProdutoPorID = (id) => {
    buscaProdutoID(id).then(data => {

        let imagens = [
            data.imagens.img_01,
            data.imagens.img_02,
            data.imagens.img_03,
            data.imagens.img_04,
            data.imagens.img_05,
            data.imagens.img_06,
        ]
        let dados = data.msg
        let slideImgProduto = ''


        document.querySelector("#titulo-produto").innerHTML = dados.tituloProduto
        document.querySelector('#titulo-produto-desc').innerHTML = dados.tituloProduto
        document.querySelector('#desc-produto').innerHTML = dados.descricao
        document.querySelector('#preco-pg-item').innerHTML = dados.preco.replace('.', ',')
        document.querySelector('#total-pg-item').innerHTML = dados.preco.replace('.', ',')

        slideImgProduto += `<div class="slider slider-for">`


        for (i = 0; i < imagens.length; i++) {

            if (imagens[i] != null) {

                slideImgProduto += `<div class="slick-slide"><img class="img-principal" src="${urlImagem + imagens[i]}"></div>`
            }
        }

        slideImgProduto += `</div>
                                <div class="slider slider-nav">`

        for (y = 0; y < imagens.length; y++) {

            if (imagens[y] != null) {
                slideImgProduto += `<div class="slick-slide slick-slide-nav"><img src="${urlImagem + imagens[y]}"></div>`
            }
        }

        slideImgProduto += '</div>'

        document.querySelector("#slide-img-produto").innerHTML = slideImgProduto

        $('.slider-for').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.slider-nav'
        })

        $('.slider-nav').slick({
            slidesToShow: 3,
            slidesToScroll: 1,
            asNavFor: '.slider-for',
            centerMode: true,
            focusOnSelect: true
        })
    })
}

atualizaQtPgItem = (input) => {

    var valorProduto = document.querySelector('#preco-pg-item').innerHTML
    var convertValor = parseFloat(valorProduto.replace(',', '.'))
    var qtAtual = input.value
    var soma = qtAtual * convertValor

    document.querySelector('#total-pg-item').innerHTML = parseFloat(soma).toFixed(2).replace('.', ',')
}

getDadosProdutoPorID(id)

buscaCategorias()