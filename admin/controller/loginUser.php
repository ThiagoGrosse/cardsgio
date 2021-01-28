<?php

require_once 'database/login.php';

function loginUser($user, $pass)
{
    $conn = dbON();

    $dados = $conn->query('SELECT * FROM usuario_admin WHERE user = "' . $user . '"');

    if (mysqli_num_rows($dados) > 0) {
        if ($result = mysqli_fetch_all($dados, MYSQLI_ASSOC)) {
            $senha = $result[0]['user_password'];
            $conn->close();

            if ($senha == $pass) {
                return ['Success'=>'Logar usuário'];
            } else {
                return ["Erro"=>"Senha incorreta"];
            }
        }
    } else {
        return ["Erro"=>"Usuário não encontrado"];
    }
}
