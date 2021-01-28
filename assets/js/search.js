$(document).ready(function () {
  $("#formSearch").submit(function (e) {
    e.preventDefault();

    if ($("#search").val()) {
      var obj = {
        search: $("#search").val(),
      };

      $.ajax({
        url: "controller/search.php",
        type: "post",
        data: obj,
        dataType: "json",
        success: function (data) {
          now = new Date();
          var itens = "";

          if (data.erro) {
            $("#produtos").html(
              `<div class="container result-zero"><h4>${data.erro}</h4></div>`
            );
          } else {
            for (i = 0; i < data.length; i++) {
              var img = data[i].dir + "?" + now.getTime();

              if (data[i].estoque > 0) {
                itens += `
                  <div class="card">
                  <img src="${img}" class="card-img-top" alt="${data[i].nome}">
                  <div class="card-body">
                    <p>R$ ${data[i].preco}</p>
                    <h6 class="card-title">${data[i].nome}</h6>
                  </div>
                  <button class="btn btn-success" data-toggle="modal" data-target="#modal-contato" onclick="mensagem('${data[i].nome}','${data[i].sku}')"  >Comprar <i class="fa fa-whatsapp" aria-hidden="true"></i></button>
                </div>`;
              }
            }

            $("#produtos").html(itens);
          }
        },
      });
    }else{
      window.location.href ="index.php"
    }

  });
});
