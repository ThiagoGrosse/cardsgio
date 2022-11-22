
// REQUISIÇÕES


/**
 * Busca Produtos
 * @returns json
*/
getProdutos = async () => {

    let response = await fetch(consultaProdutos)
    let data = await response.json()

    return data
}

/**
 * Busca Banners
 */
getBanners = async () => {

    let response = await fetch(consultaBanner)
    let data = await response.json()

    return data
}

/**
 * Busca produto por id
 */
getProdutosByID = async (sku) => {

    let response = await fetch(consultaProdutoID + sku)
    let data = await response.json()

    return data
}

/**
 * Deletar produto
 */
produtoDeletar = async (sku) => {

    let response = await fetch(deletarProduto + sku)
    let data = await response.json()

    return data
}

/**
 * Busca categorias ativas
 */
getCategoriaAtiva = async () => {

    let response = await fetch(consultaCategoriasAtivas)
    let data = await response.json()

    return data
}

/**
 * Busca categorias
 */
getCategoria = async () => {

    let response = await fetch(consultaCategorias)
    let data = await response.json()

    return data
}

/**
 * Remove categoria
 */
categoriaDeletar = async (id) => {

    let response = await fetch(deletarCategoria + id)
    let data = await response.json()

    return data
}