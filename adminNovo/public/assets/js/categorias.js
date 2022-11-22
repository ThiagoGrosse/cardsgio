
/**
 * Lista categorias no campo select
 */
listarCategoriaSelect = () => {
    getCategoriaAtiva().then(data => {

        let categoriaPrincipal = data.msg

        var option = `<option value="0" selected>Cadastrar como categoria principal</option>`

        for (i = 0; i < categoriaPrincipal.length; i++) {

            option += `<option value="${categoriaPrincipal[i].id_principal}">${categoriaPrincipal[i].titulo}</option>`
        }

        document.querySelector('#nivel-categoria').innerHTML = option
    })
}

/**
 * Edita Categoria
 */
editarCategoria = (id, titulo, status) => {

    let tituloForm = document.querySelector('#edit-nome-categoria')
    let statusForm = document.querySelector('#edit-status-categoria')

    tituloForm.value = titulo

    if (status == 1) {
        statusForm.checked = true
    }

    $('#form-edita-categoria').submit(function (e) {
        e.preventDefault()

        let obj = {
            idCategoria: id,
            tituloCategoria: tituloForm.value,
            statusCategoria: statusForm.checked,
        }

        $.ajax({
            url: editaCategoria,
            data: JSON.stringify(obj),
            type: 'POST',
            contentType: 'application/json',
            processData: false,
            dataType: "JSON",
            success: function (data) {

                location.reload()

            }, error: function (error) {
                console.log(error)
            }
        })
    })
}


removeCategoria = (id) => {


    categoriaDeletar(id).then(data => {

        if (data.tipo == 'sucesso') {
            listarTodasCategorias()
        }
    })
}

listarTodasCategorias = () => {
    getCategoria().then(data => {

        let categorias = data.msg
        let html = ''
        let statusString = ''

        for (i = 0; i < categorias.length; i++) {

            if (categorias[i].status == 1) { statusString = "Ativo" } else { statusString = "Inativo" }

            html += `   <div class="accordion-item">
                            <h2 class="accordion-header" id="${categorias[i].id_principal}">
                                <div class="d-flex">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse-${i}" aria-expanded="false" aria-controls="panelsStayOpen-collapse-${i}">
                                       ${categorias[i].id_principal} - ${categorias[i].titulo}
                                       <span class="statusCategoriaLista">${statusString}</span>
                                    </button>
                                    <div class="d-flex">
                                        <button type="button" class="btn acoes-categorias" onclick="editarCategoria('${categorias[i].id_principal}','${categorias[i].titulo}','${categorias[i].status}')" data-bs-toggle="modal" data-bs-target="#editarCategoria"><i class="fa fa-pen"></i></button>
                                        <button type="button" class="btn acoes-categorias" onclick="removeCategoria(${categorias[i].id_principal})"><i class="fa fa-times"></i></button>
                                    </div>
                                </div>
                            </h2>
                            <div id="panelsStayOpen-collapse-${i}" class="accordion-collapse collapse" aria-labelledby="${categorias[i].id_principal}" data-bs-parent="#accordionExample">
                                <div class="accordion-body">
                                    <ul class="list-group">`

            let subcategoria = categorias[i].subcategorias

            for (x = 0; x < subcategoria.length; x++) {

                if (subcategoria[x].status == 1) { statusString = "Ativo" } else { statusString = "Inativo" }

                html += `  <li class="list-group-item d-flex justify-content-between align-items-center">
                                ${subcategoria[x].id_sub} - ${subcategoria[x].subcategoria}
                                <span>${statusString}</span>
                                <div class="d-flex">
                                    <button type="button" class="btn acoes-categorias" onclick="editarCategoria('${subcategoria[x].id_sub}','${subcategoria[x].subcategoria}','${subcategoria[x].status}')" data-bs-toggle="modal" data-bs-target="#editarCategoria"><i class="fa fa-pen"></i></button>
                                    <button type="button" class="btn acoes-categorias" onclick="removeCategoria(${subcategoria[x].id_sub})"><i class="fa fa-times"></i></button>
                                </div>
                            </li>`
            }
            html += `
                                </ul>
                            </div>
                        </div>
                    </div>`
        }


        document.querySelector('#acordeon-categorias').innerHTML = html
    })
}

listarCategoriaSelect()
listarTodasCategorias()

/**
 * Função que cadastra categoria
 */

$("#form-cadastra-categoria").submit(function (e) {
    e.preventDefault()


    var obj = {
        idCategoriaPrincipal: $("#nivel-categoria option:selected").val(),
        tituloCategoria: $('#nome-categoria').val(),
        statusCategoria: $('#status-categoria').is(":checked")
    }

    $.ajax({
        url: cadastraCategorias,
        data: JSON.stringify(obj),
        type: 'POST',
        contentType: 'application/json',
        processData: false,
        dataType: "JSON",
        success: function (data) {

            location.reload()

        }, error: function (error) {
            console.log(error)
        }
    })
})