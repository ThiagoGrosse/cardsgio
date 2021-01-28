<?php

class Pedidos
{
    public $idPedido;

    public function creatOrder($itens, $valorCarrinho, $cliente, $email, $contato)
    {
        $this->getLastOrder();

        $this->reduzEstoque($itens);

        $conn = dbON();
        $conn->query('INSERT INTO pedidos(id_pedido, status_pedido, cliente, email, contato, valor_pedido) 
                        VALUES ("' . $this->idPedido . '", "Aguardando Pagamento" ,"' . $cliente . '", "' . $email . '", "' . $contato . '", "' . $valorCarrinho . '")');
        if ($conn->error) {
            $msg = ['Erro' => $conn->error];
        } else {
            foreach ($itens as $i) {
                $conn->query('INSERT INTO itens_pedido(id_pedido, sku, quantidade, preco) VALUES ("' . $this->idPedido . '","' . $i['sku'] . '","' . $i['quantidade'] . '", "' . $i['valor'] . '")');
            }
            $msg = ['Sucesso' => 'Pedido ' . $this->idPedido . ' cadastrado'];
        }

        $conn->close();

        return $msg;
    }

    private function getLastOrder()
    {
        $conn = dbON();
        $dados = $conn->query("SELECT id_pedido FROM pedidos ORDER BY id_pedido DESC LIMIT 1");
        if ($result = mysqli_fetch_assoc($dados)) {
            $this->idPedido = $result['id_pedido'] + 1;
        } else {
            $this->idPedido = 50000;
        }
        $conn->close();
    }

    public function getPedidosDash($dataInicial, $dataFinal)
    {
        $conn = dbON();
        $dados = $conn->query('SELECT sum(valor_pedido) as valor, data_pedido FROM pedidos
                                WHERE data_pedido BETWEEN "' . $dataInicial . ' 00:00:00" AND "' . $dataFinal . ' 23:59:59"
                                GROUP BY DATE(data_pedido)');
        $result = mysqli_fetch_all($dados, MYSQLI_ASSOC);
        $conn->close();

        return $result;
    }

    public function getPedidosStatus()
    {
        $conn = dbON();
        $dados = $conn->query('SELECT COUNT(id_pedido) as quantidade, status_pedido FROM pedidos
                                GROUP BY status_pedido');
        $result = mysqli_fetch_all($dados, MYSQLI_ASSOC);
        $conn->close();

        return $result;
    }

    private function reduzEstoque($itens)
    {
        $conn = dbON();

        foreach ($itens as $i) {
            $sku = $i['sku'];
            $qt = $i['quantidade'];

            $dado = $conn->query("SELECT estoque FROM produto_preco_estoque WHERE sku = " . $sku);

            $oldEstoque = mysqli_fetch_assoc($dado);

            $novoEstoque = $oldEstoque['estoque'] - $qt;

            $conn->query('UPDATE produto_preco_estoque SET estoque = "' . $novoEstoque . '" WHERE sku = ' . $sku);
        }

        $conn->close();
    }
}
