
/**
 * Produtos
 */
categorias = async () => {

    let response = await fetch(consultaCategorias)
    let data = await response.json()

    return data
}

buscaProdutoID = async (id) => {

    let response = await fetch(consultaProdutoID + id)
    let data = await response.json()

    return data
}

getBanner = async () => {

    let response = await fetch(consultaBanner)
    let data = await response.json()

    return data
}

getTodosOsProdutos = async () => {

    let response = await fetch(consultaTodosProdutos)
    let data = await response.json()

    return data
}