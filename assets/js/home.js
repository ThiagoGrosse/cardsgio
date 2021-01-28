$.ajax({
  url: "controller/getDadosHome.php",
  type: "GET",
  dataType: "json",
  success: function (data) {
    // var produtos = data.produtos;
    // var itens = "";

    // for (i = 0; i < produtos.length; i++) {
    //   if (produtos[i].estoque > 0) {
    //     itens += `
    //         <div class="card">
    //         <img src="${produtos[i].dir}" class="card-img-top" alt="${produtos[i].nome}">
    //         <div class="card-body">
    //           <p>R$ ${produtos[i].preco}</p>
    //           <h6 class="card-title">${produtos[i].nome}</h6>
    //         </div>
    //         <button class="btn btn-success" data-toggle="modal" data-target="#modal-contato" onclick="mensagem('${produtos[i].nome}','${produtos[i].sku}')"  >Comprar <i class="fa fa-whatsapp" aria-hidden="true"></i></button>
    //       </div>`;
    //   }
    // }

    // $("#produtos").html(itens);
    $(".nomeSite").html(data.nomeSite);
  },
});

// $(document).ready(function () {
//   function mensagem(nome, sku) {
//     var inputsForm = `
//                 <div class="form-group">
//                   <label for="nome" class="col-form-label">Seu nome:</label>
//                   <input type="text" class="form-control" id="nome" name="nome" autocomplete="off" required>
//                 </div>
//                 <div class="modal-footer">
//                 <div className="produto">
//                   <span>${nome}</span>
//                 </div>
//                   <button type="button" onClick="sendMessage('${nome}','${sku}')" class="btn btn-success">Enviar</button></a>
//                   <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
//                 </div>`;

//     $("#formMensagem").html(inputsForm);
//   }

//   function sendMessage(nome, sku, nomeCliente) {
//     var nomeCliente = document.getElementById("nome").value;
//     var msg = `Olá Giovani, me chamo ${nomeCliente} e tenho interesse no produto ${nome} -> sku ${sku}`;

//     window.open(
//       "https://api.whatsapp.com/send/?phone=554599543826&text=" +
//         msg +
//         " &app_absent=0"
//     );
//   }
// });
