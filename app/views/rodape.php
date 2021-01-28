<footer class="sticky-footer bg-black">
    <div class="container my-auto">
        <div class="copyright text-center my-auto">
            <span>Copyright &copy; <span class="nomeSite"></span> 2020</span><br><br>
            <a href='https://br.freepik.com/vectors/fundo'>Vetores criado por starline - br.freepik.com</a>
        </div>
    </div>
</footer>
</body>

</html>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

<script>
    function mensagem(nome, sku) {
        $(".modal").css('display', 'block')
        var inputsForm = `
<div class="form-group">
<label for="nome" class="col-form-label">Seu nome:</label>
<input type="text" class="form-control" id="nome" name="nome" autocomplete="off" required>
</div>
<div class="modal-footer">
<div className="produto">
<span>${nome}</span>
</div>
<button type="button" onClick="sendMessage('${nome}','${sku}')" class="btn btn-success">Enviar</button></a>
<button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
</div>`;

        $("#formMensagem").html(inputsForm);
    }

    function sendMessage(nome, sku, nomeCliente) {
        var nomeCliente = document.getElementById("nome").value;
        var msg = `Olá Giovani, me chamo ${nomeCliente} e tenho interesse no produto ${nome} -> sku ${sku}`;

        window.open(
            "https://api.whatsapp.com/send/?phone=554599543826&text=" +
            msg +
            " &app_absent=0"
        );
    }
</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-DWM1TFNDNS"></script>
<script>
    window.dataLayer = window.dataLayer || [];

    function gtag() {
        dataLayer.push(arguments);
    }
    gtag('js', new Date());

    gtag('config', 'G-DWM1TFNDNS');
</script>