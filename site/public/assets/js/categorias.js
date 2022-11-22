var query = window.location.href.split("/")
var t = query.length
var id = query[t - 1];

buscaCategorias()

buscarTodosProdutos = () => {

    var xhttp = new XMLHttpRequest()
    xhttp.open("GET", consultaProdutoCategoriaID + id, false)
    xhttp.send()

    let result = JSON.parse(xhttp.responseText)

    return result.msg
}

let data = buscarTodosProdutos()
let perPage = 20

const state = {
    page: 1,
    perPage,
    totalpages: Math.ceil(data.length / perPage),
    maxVisibleButtons: 5
}

document.querySelector('#perPage').innerHTML = perPage
document.querySelector('#totalPage').innerHTML = data.length

const html = {
    get(element) {
        return document.querySelector(element)
    }
}

const controls = {
    next() {
        state.page++

        if (state.page > state.totalpages) {
            state.page--
        }
    },
    prev() {
        state.page--

        if (state.page < 1) {
            state.page++
        }
    },
    gotTo(page) {
        if (page < 1) {
            page = 1
        }

        state.page = +page

        if (page > state.totalpages) {
            state.page = state.totalpages
        }
    },
    createListeners() {
        html.get('.first').addEventListener('click', () => {
            controls.gotTo(1)
            update()
        })

        html.get('.last').addEventListener('click', () => {
            controls.gotTo(state.totalpages)
            update()
        })

        html.get('.next').addEventListener('click', () => {
            controls.next()
            update()
        })

        html.get('.prev').addEventListener('click', () => {
            controls.prev()
            update()
        })
    }
}

const list = {
    create(item) {

        let card = html.get('.models .card').cloneNode(true)

        card.querySelector('.card-img-top').src = urlImagem + item.imagemPrincipal
        card.querySelector('.card-img-top').alt = item.titulo
        card.querySelector('.card-title').innerHTML = item.titulo
        card.querySelector('.card-text span').innerHTML = item.preco.replace('.', ',')

        card.querySelector('.btn-comprar').addEventListener('click', () => {
            adicionaProdutoCarrinho(item.sku)
        })

        html.get('.list').append(card)
    },
    update() {
        html.get('.list').innerHTML = ""

        let page = state.page - 1
        let start = page * state.perPage
        let end = start + state.perPage

        const paginatedItems = data.slice(start, end)

        paginatedItems.forEach(list.create)
    }
}

const buttons = {
    element: html.get('.controls .numbers'),
    create(number) {

        const button = document.createElement('div')

        button.innerHTML = number

        if (state.page == number) {
            button.classList.add('btn-pgn-active')
        }

        button.addEventListener('click', (event) => {
            const page = event.target.innerText

            controls.gotTo(page)
            update()
        })

        buttons.element.appendChild(button)
    },
    update() {
        buttons.element.innerHTML = ""

        const { maxLeft, maxRight } = buttons.calculateMaxVisible()

        for (let page = maxLeft; page <= maxRight; page++) {

            buttons.create(page)
        }

    },
    calculateMaxVisible() {

        const { maxVisibleButtons } = state

        let maxLeft = (state.page - Math.floor(maxVisibleButtons / 2))
        let maxRight = (state.page + Math.floor(maxVisibleButtons / 2))

        if (maxLeft < 1) {
            maxLeft = 1
            maxRight = maxVisibleButtons
        }

        if (maxRight > state.totalpages) {
            maxLeft = state.totalpages - (maxVisibleButtons - 1)
            maxRight = state.totalpages

            if (maxLeft < 1) maxLeft = 1
        }

        return { maxLeft, maxRight }
    }
}

update = () => {
    list.update()
    list.update()
    buttons.update()
}

init = () => {
    update()
    controls.createListeners()
}

if (data.length !== 0) {
    init()

} else {

    let msg = ` <div class="msg-produto-nao-encontrado">
                    <span>Nenhum produto encontrado</span>
                </div>`

    document.querySelector('.list').innerHTML = msg
}


