$(document).ready(function () {
  /**
   * Atualiza dados do arquivo no imput
   */
  $("#banner").change(function () {
    var arquivo = document.getElementById("banner").files[0].name;
    $("#labBan").html(arquivo);
  });

  /**
   * Envia novo nome do site
   */

  $("#formNameSite").submit(function (e) {
    e.preventDefault();

    var obj = {
      nome: $("#nomeSite").val(),
    };

    $.ajax({
      url: "controller/config-site.php",
      type: "POST",
      data: obj,
      dataType: "json",
      async: false,
      success: function (data) {

        if(data.Success){
          alerta(data.Success, 'success')
        }else{
          alerta(data.Error, 'error')
        }

      },
    });
  });

  /**
   * Atualiza banner do site
   */
  $("#formBanner").submit(function (e) {
    e.preventDefault();

    var select = $("#selectOrdem option:selected").val();
    var form = new FormData(this);

    form.set("ordem", select);

    $.ajax({
      url: "controller/updateBanners.php",
      method: "POST",
      data: form,
      dataType: "json",
      processData: false,
      contentType: false,
      async: false,
      success: function (data) {
        console.log(data)
        if(data.Erro){
          alerta(data.Erro, 'error')
        }else{
          alerta(data, 'success')
        }
        
      },
    });
  });
});

/**
 * Busca nome do site
 */
$.ajax({
  url: "controller/config-site.php",
  type: "GET",
  dataType: "json",
  success: function (data) {

    var form = `<label for="nomeSite">Nome do site</label>
                    <div class="input-group">
                        <input type="text" class="form-control" id="nomeSite" name="nomeSite" placeholder="${data[0].nome_site}">
                        <div class="input-group-append">
                            <button class="btn btn-info" id="btn-nome-site" >Salvar</button>
                        </div>
                    </div>`;

    $("#formNameSite").html(form);
  },
});

function alerta(msg, tipo){
  Swal.fire({
    position: 'top-end',
    icon: tipo,
    title: msg,
    showConfirmButton: false,
    timer: 1500
  })
}