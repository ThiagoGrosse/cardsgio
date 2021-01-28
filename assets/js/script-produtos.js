/**
 * JimCarreys
 */

$(document).ready(function () {
  $.ajax({
    url: "controller/getProdutos.php",
    type: "POST",
    dataType: "json",
    success: function (data) {
      var table = `
                <table class="table table-striped">
                  <thead class="thead-dark">
                        <th>SKU</th>
                        <th>Título produto</th>
                        <th>Estoque</th>
                        <th>Preco</th>
                        <th>Imagem</th>
                        <th colspan="2">Opções</th>
                    </thead>
                    <tbody>`;

      now = new Date();

      for (i = 0; i < data.length; i++) {
        var img =
          data[i].dir_img + "/" + data[i].nome_img + "?" + now.getTime();

        var vlProduto = "R$ " + data[i].preco;
        var preco = vlProduto.replace(".", ",");

        table += `
                <tr>
                    <td><b>${data[i].sku}</b></td>
                    <td>${data[i].nome}</td>
                    <td>${data[i].estoque}</td>
                    <td>${preco}</td>
                    <td><img src="${img}" width="100" heigth="100"></td>
                    <td><button type="button" class="btn-cadastro" data-toggle="modal" data-target="#exampleModal" onclick="edit('${data[i].sku}','${data[i].nome}','${data[i].estoque}','${data[i].preco}','${img}')"><i class="fas fa-pencil-alt"></i></button></td>
                    <td><button type="button" class="btn-cadastro" onclick="remove('${data[i].sku}')"><i class="fas fa-times-circle"></i></button></td>
                </tr>
              `;
      }

      table += `</tbody>
                    </table`;

      $("#table").html(table);
    },
  });

  $("#formEditProduto").submit(function (e) {
    e.preventDefault();

    var sku = $("#sku").val();
    var obj = new FormData(this);

    obj.set("sku", sku);

    $.ajax({
      url: "controller/atualizaProduto.php",
      type: "POST",
      data: obj,
      dataType: "json",
      contentType: false,
      processData: false,
      success: function (data) {
        if (data.produto.Success) {
          alerta(data.produto.Success, "success");
        } else {
          alerta(data.produto.Erro, "error");
        }
      },
    });
  });
});

/**
 * Functions
 */
function remove(sku) {

  Swal.fire({
    title: 'Deseja remover o produto?',
    text: "Este processo não é reversível!",
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Sim, exclua o produto!'
  }).then((result) => {
    if (result.isConfirmed) {

      var obj = {
        sku: sku,
      };
    
      $.ajax({
        url: "controller/removeProduto.php",
        type: "POST",
        data: obj,
        dataType: "json",
        success: function (data) {
          
          if (data.Success) {
            alerta(data.Success, "success");
          } else {
            alerta(data.Erro, 'error' )
          }
        },
      });
    }
  })

}

function edit(sku, nome, estoque, preco, img) {
  $("#titulo-produto-modal").html("Editar produto");

  var inputModal = `
      <div class="imgProduto">
          <img src="${img}" alt="${nome}" width="200" heigth="200">
      </div>
      <label class="title-input" for="#sku">SKU</label>
      <div class="form-group">
        <input type="text" class="form-control" id="sku" name="sku" value="${sku}" disabled>
      </div>
      <label class="title-input" for="#titulo">Título Produto</label>
      <div class="form-group">
          <input type="text" class="form-control" id="titulo" name="titulo" value="${nome}">
      </div>
      <div class="content-input">
          <div class="form-group">
              <label class="title-input" for="#estoque">Estoque</label>
              <input type="text" class="form-control" id="estoque" name="estoque" value="${estoque}">
          </div>
          <div class="form-group">
              <label class="title-input" for="#preco">Preço</label>
              <input type="text" class="form-control" id="preco" name="preco" value="${preco}">
          </div>
      </div>
      <label class="title-input" for="#img">Imagem produto</label>
      <div class="form-group">
          <input type="file" id="img" name="img">
      </div>
      <button id="btn-salvar-att" class="btn btn-primary">Salvar</button>
`;

  $("#formEditProduto").html(inputModal);
}

function alerta(msg, tipo) {
  Swal.fire({
    position: "top-end",
    icon: tipo,
    title: msg,
    showConfirmButton: false,
    timer: 1500,
  })
}