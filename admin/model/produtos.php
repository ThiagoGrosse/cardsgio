<?php

class Produtos
{
    public function cadastra_produto($sku, $titulo, $condicao, $conjunto, $estoque, $preco, $diretorio, $novoNome)
    {
        $sku = $this->gerador_sku();

        $conn = dbON();
        $conn->query('INSERT INTO produto_cadastro (sku, nome, nome_img, dir_img, conjunto, condicao)
                        VALUES ("' . $sku . '", "' . $titulo . '", "' . $novoNome . '", "' . $diretorio . '", "' . $conjunto . '", "' . $condicao . '")');
        if ($conn->error) {
            $msg = ['Erro' => $conn->error];
        } else {
            $conn->query('INSERT INTO produto_preco_estoque (sku, estoque, preco) 
                            VALUES ("' . $sku . '", "' . $estoque . '", "' . $preco . '")');
            if ($conn->error) {
                $msg = ['Erro' => $conn->error];
            } else {
                $msg = ['Sucesso' => 'Produto cadastrado'];
            }
        }
        $conn->close();
        return $msg;
    }

    public function deleta_produto($sku)
    {
        $conn = dbON();
        $conn->query("DELETE FROM produto_cadastro WHERE sku='" . $sku . "'");

        if ($error = $conn->error) {
            $result = ["Erro" => $error];
        } else {
            $conn->query("DELETE FROM produto_preco_estoque WHERE sku='" . $sku . "'");
            if ($error = $conn->error) {
                $result = ["Erro" => $error];
            } else {
                $result = ["Success" => "Sku " . $sku . " removido com sucesso!"];
            }
        }

        $conn->close();

        return $result;
    }

    public function edita_produto($sku, $titulo, $conjunto)
    {
        $conn = dbON();
        $conn->query('UPDATE produto_cadastro 
                    SET nome="' . $titulo . '", conjunto="' . $conjunto . '"
                    WHERE sku=' . $sku);

        if ($conn->error) {
            $result = $conn->error;
        } else {
            $result = 'Produto atualizado';
        }
        $conn->close();

        return $result;
    }

    public function edita_preco_estoque($sku, $preco, $estoque)
    {
        $conn = dbON();
        $conn->query('UPDATE produto_preco_estoque
                        SET estoque="' . $estoque . '", preco="' . $preco . '"
                        WHERE sku=' . $sku);

        if ($conn->error) {
            $result = $conn->error;
        } else {
            $result = 'Preço e estoque atualizados';
        }
        $conn->close();

        return $result;
    }

    public function edita_condicacao($sku, $condicao)
    {
        $conn = dbON();
        $conn->query('UPDATE produto_cadastro 
                    SET condicao="' . $condicao . '"
                    WHERE sku=' . $sku);

        if ($conn->error) {
            $result = $conn->error;
        } else {
            $result = 'Condição atualizada';
        }
        $conn->close();

        return $result;
    }

    public function gerador_sku()
    {
        $conn = dbON();
        $lastSku = $conn->query('SELECT sku FROM produto_cadastro ORDER BY sku DESC LIMIT 1');

        if ($result = mysqli_fetch_assoc($lastSku)) {
            $msg = $result['sku'] + 1;
        } else {
            $msg = 1000;
        }

        $conn->close();

        return $msg;
    }
}
