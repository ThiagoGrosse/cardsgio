$(document).ready(function () {
  $("#form-cadastro").submit(function (e) {
    e.preventDefault();

    var formFile = new FormData(this);

    $.ajax({
      url: "controller/cadastroProduto.php",
      type: "POST",
      data: formFile,
      contentType: false,
      processData: false,
      dataType: "JSON",
      success: function (data) {
        if (data.Success) {
          alerta(data.Success, "success");
        } else {
          alerta(data.Erro, "error");
        }
      },
    });
  });
});

function alerta(msg, tipo) {
  Swal.fire({
    position: "top-end",
    icon: tipo,
    title: msg,
    showConfirmButton: false,
    timer: 1500,
  });
}
