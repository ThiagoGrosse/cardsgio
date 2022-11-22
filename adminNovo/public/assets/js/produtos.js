
/**
 * Imprime lista de produtos na tela
 */
imprimeTabelaProdutos = () => {

    getProdutos().then(data => {

        let dataTime = new Date()
        let time = dataTime.getTime()

        let dados = data.msg
        let tabela = `<table class="table table-striped w-100">
                            <thead>
                                <tr>
                                    <th colspan="3">Produto</th>
                                    <th>Status</th>
                                    <th>Vendidos</th>
                                    <th>Destaque 01</th>
                                    <th>Destaque 02</th>
                                    <th>Estoque</th>
                                    <th>Preço</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                        `
        for (i = 0; i < dados.length; i++) {

            let destaque = dados[i].destaque
            let destaque02 = dados[i].destaque02
            let imagem = dados[i].imagem01

            if (dados[i].statusProduto == 1) { produtoStatus = 'Ativo' } else { produtoStatus = 'Inativo' }

            if (imagem == null) { imagem = 'http://localhost/siteNovoGio/adminNovo/public/assets/img/sem-imagem.png?' + time } else { imagem = `assets/img/produtos/${imagem}?${time}` }

            if (destaque) { destaque = "Sim" } else { destaque = "Não" }

            if (destaque02) { destaque02 = "Sim" } else { destaque02 = "Não" }

            tabela += `<tr class="linhaTable">
                            <td>${dados[i].SKU}</td>
                            <td><img src="${imagem}" alt="${dados[i].tituloProduto}" width="80"></td>
                            <td>${dados[i].tituloProduto}</td>
                            <td>${produtoStatus}</td>
                            <td>${dados[i].quantidadeVendida}</td>
                            <td>${destaque}</td>
                            <td>${destaque02}</td>
                            <td>${dados[i].saldo}</td>
                            <td>R$ ${dados[i].preco.replace('.', ',')}</td>
                            <td>
                                <button 
                                    class="btn btn-ac-cat" 
                                    title="Editar" 
                                    type="button"
                                    data-toggle="modal"
                                    data-target="#modalEditProduto"
                                    onclick="editarProduto('${dados[i].SKU}')">
                                    <i class="fas fa-pen"></i>
                                </button>
                                
                                <button
                                    class="btn btn-ac-cat"
                                    title="Excluir"
                                    type="button"
                                    onclick="excluirProduto('${dados[i].SKU}')"
                                    >
                                    <i class="fas fa-times"></i>
                                </button>
                            </td>
                        </tr>`
        }



        document.querySelector('#tabela-produtos').innerHTML = tabela
    })
}

/**
 * Imprime opções de categorias ativas
 */
imprimeCategoria = () => {
    getCategoriaAtiva().then(data => {

        let cPrincipal = data.msg
        let contCat = cPrincipal.length
        let option = `<option value="0" selected disabled>Todas</option>`

        for (i = 0; i < contCat; i++) {

            option += `<option value="${cPrincipal[i].id_principal}">${cPrincipal[i].titulo}</option>`

            let sub = cPrincipal[i].subcategorias

            if (sub) {

                for (x = 0; x < sub.length; x++) {

                    option += `<option value="${sub[x].id_sub}"> - ${sub[x].subcategoria}</option>`
                }
            }

        }
        document.querySelector('#selectCategoria').innerHTML = option
        document.querySelector('#select-category').innerHTML = option
        document.querySelector('#editCategoriaProduto').innerHTML = option
    })
}

/**
 * Salva imagens na pasta
 */
salvaImagens = (formData) => {

    $.ajax({
        url: 'http://localhost/siteNovoGio/adminNovo/public/uploadfile',
        data: formData,
        type: 'POST',
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function (data) {

            gravaImagensBanco(JSON.stringify(data))
        },
        error: function (error) {
            console.log(error)
        }
    })
}

/**
 * Grava dados da imagem no banco
 */
gravaImagensBanco = (dadosImagem) => {

    $.ajax({
        url: cadastraImagens,
        data: dadosImagem,
        type: 'POST',
        contentType: 'application/json',
        processData: false,
        dataType: "JSON",
        success: function (data) {
            console.log(data)
            location.reload()
        },
        error: function (error) {
            console.log(error)
        }
    })
}

/**
 * Função que busca dados do produto e exibe no modal
 */
editarProduto = (sku) => {

    let idProduto = document.querySelector('#idProdutoEdicao')
    let tituloProduto = document.querySelector("#editarTituloProduto")
    let precoProduto = document.querySelector("#editarPrecoProduto")
    let saldoProduto = document.querySelector('#editarSaldoProduto')
    let destaqueProduto = document.querySelector('#editarDestaque')
    let destaque02Produto = document.querySelector('#editarDestaque02')
    let selectCategory = document.querySelector('#editCategoriaProduto')
    let selectStatus = document.querySelector('#statusProdutoEditar')
    let descricaoProduto = document.querySelector('#descricaoProdutoEdicao')
    let img01 = document.querySelector('#preview-01-edicao')
    let img02 = document.querySelector('#preview-02-edicao')
    let img03 = document.querySelector('#preview-03-edicao')
    let img04 = document.querySelector('#preview-04-edicao')
    let img05 = document.querySelector('#preview-05-edicao')
    let img06 = document.querySelector('#preview-06-edicao')


    getProdutosByID(sku).then(data => {

        let imagens = data.imagens
        let dadosProduto = data.msg
        let categoria = data.categoria

        idProduto.value = dadosProduto.SKU
        tituloProduto.value = dadosProduto.tituloProduto
        precoProduto.value = dadosProduto.preco
        saldoProduto.value = dadosProduto.saldo
        descricaoProduto.value = dadosProduto.descricao

        if (dadosProduto.destaque == 1) { destaqueProduto.checked = true } else { destaqueProduto.checked = false }
        if (dadosProduto.destaque02 == 1) { destaque02Produto.checked = true } else { destaque02Produto.checked = false }
        if (dadosProduto.statusProduto == 1) { selectStatus.checked = true } else { selectStatus.checked = false }

        selectCategory.value = categoria.id

        if (imagens.img_01 !== null) { img01.src = `assets/img/produtos/${imagens.img_01}` } else { img01.src = 'http://localhost/siteNovoGio/adminNovo/public/assets/img/sem-imagem.png' }
        if (imagens.img_02 !== null) { img02.src = `assets/img/produtos/${imagens.img_02}` } else { img02.src = 'http://localhost/siteNovoGio/adminNovo/public/assets/img/sem-imagem.png' }
        if (imagens.img_03 !== null) { img03.src = `assets/img/produtos/${imagens.img_03}` } else { img03.src = 'http://localhost/siteNovoGio/adminNovo/public/assets/img/sem-imagem.png' }
        if (imagens.img_04 !== null) { img04.src = `assets/img/produtos/${imagens.img_04}` } else { img04.src = 'http://localhost/siteNovoGio/adminNovo/public/assets/img/sem-imagem.png' }
        if (imagens.img_05 !== null) { img05.src = `assets/img/produtos/${imagens.img_05}` } else { img05.src = 'http://localhost/siteNovoGio/adminNovo/public/assets/img/sem-imagem.png' }
        if (imagens.img_06 !== null) { img06.src = `assets/img/produtos/${imagens.img_06}` } else { img06.src = 'http://localhost/siteNovoGio/adminNovo/public/assets/img/sem-imagem.png' }
    })
}

/**
 * Função que remove produto
 */
excluirProduto = (id) => {
    produtoDeletar(id).then(data => {

        if (data.tipo == 'sucesso') {
            imprimeTabelaProdutos()
        }
    })
}

imprimeCategoria()
imprimeTabelaProdutos()

$(document).ready(function () {

    /**
     * Envia cadastro de produto
     */
    $("#cadastrarProduto").submit(function (e) {
        e.preventDefault()

        var dados = new FormData(this)

        var obj = {
            tituloProduto: $('#tituloProduto').val(),
            descProduto: $('#descricaoProduto').val(),
            idCategoria: $('#select-category option:selected').val(),
            saldo: $('#saldoProduto').val(),
            preco: $('#precoProduto').val().replace(',', '.'),
            destaque: $('#destaque').is(':checked'),
            destaque_02: $('#destaque02').is(':checked'),
            status: $('#statusProduto').is(':checked')
        }

        $.ajax({
            url: cadastraProduto,
            data: JSON.stringify(obj),
            type: 'POST',
            contentType: 'application/json',
            processData: false,
            dataType: "JSON",
            success: function (data) {

                if (data.tipo == 'sucesso') {

                    let id = data.sku
                    dados.append('idItem', id)

                    salvaImagens(dados)
                }

            }, error: function (error) {
                console.log(error)
            }
        })
    })


    /**
     * Envia atualização de produto, preco e estoque
     */
    $('#form-edit-produto').submit(function (e) {
        e.preventDefault()

        var form = new FormData(this)

        var salvaImagem = 0

        for (i = 1; i <= 6; i++) {

            let inputImg = $("#edicaoImg0" + i).val()

            if (inputImg.length > 1) {
                salvaImagem = 1
            }

        }

        var dados = {
            idProduto: $("#idProdutoEdicao").val(),
            tituloProduto: $('#editarTituloProduto').val(),
            descProduto: $('#descricaoProdutoEdicao').val(),
            idCategoria: $('#editCategoriaProduto option:selected').val(),
            destaque: $('#editarDestaque').is(':checked'),
            destaque_02: $('#editarDestaque02').is(':checked'),
            status: $('#statusProdutoEditar').is(':checked')
        }

        var precoAtualizar = {
            idProduto: $("#idProdutoEdicao").val(),
            preco: $('#editarPrecoProduto').val()
        }

        var saldoAtualizar = {
            id_produto: $("#idProdutoEdicao").val(),
            saldo: $('#editarSaldoProduto').val(),
        }


        /**
         * Atualiza Produto
         */
        $.ajax({
            url: atualizaProduto,
            data: JSON.stringify(dados),
            type: 'POST',
            contentType: 'application/json',
            processData: false,
            dataType: "JSON",
            success: function (data) {

                if (data.tipo == 'sucesso') {
                    if (salvaImagem == 1) {

                        let id = document.querySelector('#idProdutoEdicao').value
                        form.append('idItem', id)
                        salvaImagens(form)

                    } else {
                        location.reload()
                    }
                }
            }, error: function (error) {
                console.log(error)
            }
        })

        /**
         * Atualiza Saldo
         */
        $.ajax({
            url: atualizaSaldo,
            data: JSON.stringify(saldoAtualizar),
            type: 'POST',
            contentType: 'application/json',
            processData: false,
            dataType: "JSON",
            success: function (data) {

            }, error: function (error) {

            }
        })


        /**
         * Atualiza Preco
         */
        $.ajax({
            url: atualizaPreco,
            data: JSON.stringify(precoAtualizar),
            type: 'POST',
            contentType: 'application/json',
            processData: false,
            dataType: "JSON",
            success: function (data) {

            }, error: function (error) {

            }
        })
    })
})