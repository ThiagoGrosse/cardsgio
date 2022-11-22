function previewImgUpload(input) {

    var idImagem = input.id
    var imgPreview = idImagem.replace("img-", "")

    var arquivo = input.files[0].name;
    var split = arquivo.split('.');
    var extensao = split[split.length - 1];
    var nome = arquivo.replace('.' + extensao, '');
    var tamanho = (input.files[0].size / 1024).toFixed(2);

    if (tamanho > 350) {

        alert(`Imagem ${nome} está com tamanho acima do permitido. ${tamanho}`)

    } else {

        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.querySelector(`#preview-${imgPreview}`).src = e.target.result
            }
            reader.readAsDataURL(input.files[0])
        }
    }
}

function previewImgUploadEdition(input) {

    var idImagem = input.id
    var imgPreview = idImagem.replace("edicaoImg", "")

    var arquivo = input.files[0].name;
    var split = arquivo.split('.');
    var extensao = split[split.length - 1];
    var nome = arquivo.replace('.' + extensao, '');
    var tamanho = (input.files[0].size / 1024).toFixed(2);

    if (tamanho > 350) {

        alert(`Imagem ${nome} está com tamanho acima do permitido. ${tamanho}`)

    } else {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                document.querySelector(`#preview-${imgPreview}-edicao`).src = e.target.result
            }
            reader.readAsDataURL(input.files[0])
        }
    }
}

window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});


