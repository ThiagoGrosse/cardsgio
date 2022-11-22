
const baseUrl = 'http://localhost/siteNovoGio/api'
const baseBanner = 'http://localhost/siteNovoGio/adminNovo/public/assets/img/banners/'

/**
 * EFETUAR CADASTRO
 */
const cadastraProduto = `${baseUrl}/produto/cadastrar`
const consultaProdutos = `${baseUrl}/consulta/produtos`
const consultaProdutoID = `${baseUrl}/consulta/produto/`
const atualizaProduto = `${baseUrl}/produto/atualizar`
const deletarProduto = `${baseUrl}/produto/deletar/`

/**
 * CATEGORIAS
 */
const cadastraCategorias = `${baseUrl}/categoria/criar`
const editaCategoria = `${baseUrl}/categoria/atualizar`
const consultaCategorias = `${baseUrl}/consulta/categorias`
const consultaCategoriasAtivas = `${baseUrl}/consulta/categorias/ativas`
const deletarCategoria = `${baseUrl}/categoria/deletar/`

/**
 * IMAGENS
 */
const cadastraImagens = `${baseUrl}/imagem/produto`


/**
 * BANNER
 */
const cadastraBanner = `${baseUrl}/banner`
const consultaBanner = `${baseUrl}/consulta/banner`


/**
 * CARRINHO
 */
const carrinho = `${baseUrl}/carrinho`

/**
 * SALDO
 */
const atualizaSaldo = `${baseUrl}/saldo/atualiza`

/**
 * PREÇO
 */
const atualizaPreco = `${baseUrl}/preco/atualiza`