<?php

class Pedidos
{
    public function getAllOrders($inicio, $maximo)
    {
        $conn = dbON();

        $query = 'SELECT * FROM pedidos
                    ORDER BY data_pedido DESC
                    LIMIT ' . $inicio . ',' . $maximo;

        $dados = $conn->query($query);
        $result = mysqli_fetch_all($dados, MYSQLI_ASSOC);
        $numRows = mysqli_num_rows($dados);

        $conn->close();

        return [
            'result' => $result,
            'numero_linhas' => $numRows
        ];
    }

    public function getOrdersID($search, $inicio, $maximo)
    {
        $conn = dbON();

        $query = 'SELECT p.id_pedido, p.cliente, p.status_pedido, p.email, p.contato, p.valor_pedido, p.data_pedido, i.sku, i.quantidade FROM pedidos p
                    INNER JOIN itens_pedido i ON i.id_pedido = p.id_pedido
                    AND p.id_pedido LIKE "%' . $search . '%"
                    ORDER BY p.data_pedido DESC
                    LIMIT ' . $inicio . ',' . $maximo;

        $dados = $conn->query($query);
        $result = mysqli_fetch_all($dados, MYSQLI_ASSOC);
        $numRows = mysqli_num_rows($dados);

        $conn->close();

        $total = $numRows;

        return [
            'result' => $result,
            'total' => $total
        ];
    }

    public function getOrdersCliente($search, $inicio, $maximo)
    {
        $conn = dbON();

        $query = 'SELECT p.id_pedido, p.cliente, p.status_pedido, p.email, p.contato, p.valor_pedido, p.data_pedido, i.sku, i.quantidade FROM pedidos p
                    INNER JOIN itens_pedido i ON i.id_pedido = p.id_pedido
                    AND p.cliente LIKE "%' . $search . '%"
                    ORDER BY p.data_pedido DESC
                    LIMIT ' . $inicio . ',' . $maximo;

        $dados = $conn->query($query);
        $result = mysqli_fetch_all($dados, MYSQLI_ASSOC);
        $numRows = mysqli_num_rows($dados);

        $conn->close();

        $total = $numRows;

        return [
            'result' => $result,
            'total' => $total
        ];
    }

    public function getOrderClienteStatus($cliente, $status, $inicio, $maximo)
    {
        $conn = dbON();

        $query = 'SELECT p.id_pedido, p.cliente, p.status_pedido, p.email, p.contato, p.valor_pedido, p.data_pedido, i.sku, i.quantidade FROM pedidos p
                    INNER JOIN itens_pedido i ON i.id_pedido = p.id_pedido
                    WHERE p.status_pedido = "' . $status . '"
                    AND p.cliente LIKE "%' . $cliente . '%"
                    ORDER BY p.data_pedido DESC
                    LIMIT ' . $inicio . ',' . $maximo;

        $dados = $conn->query($query);
        $result = mysqli_fetch_all($dados, MYSQLI_ASSOC);
        $numRows = mysqli_num_rows($dados);

        $conn->close();

        $total = $numRows;

        return [
            'result' => $result,
            'total' => $total
        ];
    }

    public function getOrderStatus($search, $inicio, $maximo)
    {
        $conn = dbON();

        $query = 'SELECT p.id_pedido, p.cliente, p.status_pedido, p.email, p.contato, p.valor_pedido, p.data_pedido, i.sku, i.quantidade FROM pedidos p
                    INNER JOIN itens_pedido i ON i.id_pedido = p.id_pedido
                    AND p.status_pedido LIKE "%' . $search . '%"
                    ORDER BY p.data_pedido DESC
                    LIMIT ' . $inicio . ',' . $maximo;

        $dados = $conn->query($query);
        $result = mysqli_fetch_all($dados, MYSQLI_ASSOC);
        $numRows = mysqli_num_rows($dados);

        $conn->close();

        $total = $numRows;

        return [
            'result' => $result,
            'total' => $total
        ];
    }

    public function getItensPedido($idPedido)
    {
        $conn = dbON();

        $dados = $conn->query('SELECT i.sku, p.nome, i.quantidade, i.preco FROM itens_pedido i
                                INNER JOIN produto_cadastro p ON p.sku = i.sku
                                WHERE i.id_pedido = ' . $idPedido);

        if ($conn->error) {
            $result = $conn->error;
        } else {
            $result = mysqli_fetch_all($dados, MYSQLI_ASSOC);
        }
        $conn->close();

        return $result;
    }

    public function atualizaPedido($id_pedido, $id_status)
    {
        $statusPedido = $this->getStatusPorID($id_status);

        $conn = dbON();

        $dados = $conn->query('SELECT id_status FROM pedidos WHERE id_pedido = ' . $id_pedido);

        $statusAtualPedido = mysqli_fetch_assoc($dados);

        if ($statusAtualPedido['id_status'] == 'CAN' || $statusAtualPedido['id_status'] == 'ENT') {

            $statusNaoAlterar = $this->getStatusPorID($statusAtualPedido['id_status']);

            $result = ['Erro' => 'Não foi possível atualizar status do pedido. Status atual: ' . $statusNaoAlterar];
        } else {

            $conn->query('UPDATE pedidos SET id_status = "' . $id_status . '", status_pedido = "' . $statusPedido . '" WHERE id_pedido=' . $id_pedido);

            if ($erro = $conn->error) {

                $result = ["Erro" => $erro];
            } else {

                $result = ["Sucesso" => "Status de pedido atualizado"];
            }
        }

        $conn->close();

        return $result;
    }

    public function getStatusPorID($id_status)
    {

        if ($id_status == 'APG') {

            return "Aguardando Pagamento";
        } elseif ($id_status == 'PAG') {

            return 'Pago';
        } elseif ($id_status == 'ENT') {

            return 'Entregue';
        } elseif ($id_status == 'CAN') {

            return 'Cancelado';
        }
    }

    public function reduzEstoque($itens)
    {
        $conn = dbON();

        foreach ($itens as $i) {
            $sku = $i['sku'];
            $qt = $i['quantidade'];

            $conn->query('UPDATE produto_preco_estoque SET estoque = estoque + ' . $qt . ' WHERE sku = ' . $sku);
        }

        $conn->close();
    }
}
