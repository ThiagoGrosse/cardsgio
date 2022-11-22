previewBannerFull = (input) => {

    let idImg = input.id
    let imgPreview = idImg.replace('bannerFull0', '')

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
                document.querySelector(`#preView-banner-full-0${imgPreview}`).src = e.target.result
            }
            reader.readAsDataURL(input.files[0])
        }
    }
}

previewBannerMini = (input) => {

    let idImg = input.id
    let imgPreview = idImg.replace('mini-banner-0', '')

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
                document.querySelector(`#preView-mini-banner-0${imgPreview}`).src = e.target.result
            }
            reader.readAsDataURL(input.files[0])
        }
    }
}

previewBannerMedio = (input) => {

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
                document.querySelector('#preView-banner-medio').src = e.target.result
            }
            reader.readAsDataURL(input.files[0])
        }
    }
}

getBanner = () => {

    getBanners().then(data => {

        let full = data.msg.full
        let mini = data.msg.mini
        let medio = data.msg.medio

        for (i = 0; i < full.length; i++) {

            if (full[i].ordem == 1) {

                document.querySelector('#preView-banner-full-01').src = baseBanner + full[i].diretorio
            } else if (full[i].ordem == 2) {

                document.querySelector('#preView-banner-full-02').src = baseBanner + full[i].diretorio
            } else {

                document.querySelector('#preView-banner-full-03').src = baseBanner + full[i].diretorio
            }
        }

        for (i = 0; i < mini.length; i++) {

            if (mini[i].ordem == 1) {

                document.querySelector('#preView-mini-banner-01').src = baseBanner + mini[i].diretorio
            } else {

                document.querySelector('#preView-mini-banner-02').src = baseBanner + mini[i].diretorio
            }
        }

        document.querySelector('#preView-banner-medio').src = baseBanner + medio[0].diretorio

    })
}


$('#form-banner-full-01').submit(function (e) {
    e.preventDefault()

    var dados = new FormData(this)

    let link = document.querySelector('#link-banner-full-01').value
    let tipoBanner = 'full'
    let ordem = 1

    dados.append('link', link)
    dados.append('tipo', tipoBanner)
    dados.append('ordem', ordem)

    $.ajax({
        url: 'http://localhost/siteNovoGio/adminNovo/public/uploadbanner',
        data: dados,
        type: 'POST',
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function (data) {

            if (data.tipo == 'sucesso') {

                $.ajax({
                    url: cadastraBanner,
                    data: JSON.stringify(data.msg),
                    type: 'POST',
                    contentType: 'application/json',
                    processData: false,
                    dataType: "JSON",
                    success: function (data) {
                        console.log(data)
                    }, error: function (error) {
                        console.log(error)
                    }
                })
            }

        },
        error: function (error) {
            console.log(error)
        }
    })
})

$('#form-banner-full-02').submit(function (e) {
    e.preventDefault()

    var dados = new FormData(this)

    let link = document.querySelector('#link-banner-full-02').value
    let tipoBanner = 'full'
    let ordem = 2

    dados.append('link', link)
    dados.append('tipo', tipoBanner)
    dados.append('ordem', ordem)

    $.ajax({
        url: 'http://localhost/siteNovoGio/adminNovo/public/uploadbanner',
        data: dados,
        type: 'POST',
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function (data) {

            if (data.tipo == 'sucesso') {

                $.ajax({
                    url: cadastraBanner,
                    data: JSON.stringify(data.msg),
                    type: 'POST',
                    contentType: 'application/json',
                    processData: false,
                    dataType: "JSON",
                    success: function (data) {
                        console.log(data)
                    }, error: function (error) {
                        console.log(error)
                    }
                })
            }

        },
        error: function (error) {
            console.log(error)
        }
    })
})

$('#form-banner-full-03').submit(function (e) {
    e.preventDefault()

    var dados = new FormData(this)

    let link = document.querySelector('#link-banner-full-03').value
    let tipoBanner = 'full'
    let ordem = 3

    dados.append('link', link)
    dados.append('tipo', tipoBanner)
    dados.append('ordem', ordem)

    $.ajax({
        url: 'http://localhost/siteNovoGio/adminNovo/public/uploadbanner',
        data: dados,
        type: 'POST',
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function (data) {

            if (data.tipo == 'sucesso') {

                $.ajax({
                    url: cadastraBanner,
                    data: JSON.stringify(data.msg),
                    type: 'POST',
                    contentType: 'application/json',
                    processData: false,
                    dataType: "JSON",
                    success: function (data) {
                        console.log(data)
                    }, error: function (error) {
                        console.log(error)
                    }
                })
            }

        },
        error: function (error) {
            console.log(error)
        }
    })
})

$('#form-mini-banner-01').submit(function (e) {
    e.preventDefault()

    var dados = new FormData(this)

    let link = document.querySelector('#link-mini-banner-01').value
    let tipoBanner = 'mini'
    let ordem = 1

    dados.append('link', link)
    dados.append('tipo', tipoBanner)
    dados.append('ordem', ordem)

    $.ajax({
        url: 'http://localhost/siteNovoGio/adminNovo/public/uploadbanner',
        data: dados,
        type: 'POST',
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function (data) {

            if (data.tipo == 'sucesso') {

                $.ajax({
                    url: cadastraBanner,
                    data: JSON.stringify(data.msg),
                    type: 'POST',
                    contentType: 'application/json',
                    processData: false,
                    dataType: "JSON",
                    success: function (data) {
                        console.log(data)
                    }, error: function (error) {
                        console.log(error)
                    }
                })
            }

        },
        error: function (error) {
            console.log(error)
        }
    })
})

$('#form-mini-banner-02').submit(function (e) {
    e.preventDefault()

    var dados = new FormData(this)

    let link = document.querySelector('#link-mini-banner-02').value
    let tipoBanner = 'mini'
    let ordem = 2

    dados.append('link', link)
    dados.append('tipo', tipoBanner)
    dados.append('ordem', ordem)

    $.ajax({
        url: 'http://localhost/siteNovoGio/adminNovo/public/uploadbanner',
        data: dados,
        type: 'POST',
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function (data) {

            if (data.tipo == 'sucesso') {

                $.ajax({
                    url: cadastraBanner,
                    data: JSON.stringify(data.msg),
                    type: 'POST',
                    contentType: 'application/json',
                    processData: false,
                    dataType: "JSON",
                    success: function (data) {
                        console.log(data)
                    }, error: function (error) {
                        console.log(error)
                    }
                })
            }

        },
        error: function (error) {
            console.log(error)
        }
    })
})

$('#form-banner-medio').submit(function (e) {
    e.preventDefault()

    var dados = new FormData(this)

    let link = document.querySelector('#link-banner-medio').value
    let tipoBanner = 'medio'
    let ordem = 1

    dados.append('link', link)
    dados.append('tipo', tipoBanner)
    dados.append('ordem', ordem)

    $.ajax({
        url: 'http://localhost/siteNovoGio/adminNovo/public/uploadbanner',
        data: dados,
        type: 'POST',
        processData: false,
        contentType: false,
        dataType: "JSON",
        success: function (data) {

            if (data.tipo == 'sucesso') {

                $.ajax({
                    url: cadastraBanner,
                    data: JSON.stringify(data.msg),
                    type: 'POST',
                    contentType: 'application/json',
                    processData: false,
                    dataType: "JSON",
                    success: function (data) {
                        console.log(data)
                    }, error: function (error) {
                        console.log(error)
                    }
                })
            }

        },
        error: function (error) {
            console.log(error)
        }
    })
})


getBanner()