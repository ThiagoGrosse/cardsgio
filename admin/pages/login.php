<?php
require_once 'controller/loginUser.php';

session_start();

$msg = '';

if(isset($_SESSION['usuario'])){
    session_destroy();
}


if ($_POST) {
    $user = $_POST['user'];
    $pass = $_POST['pass'];

    $login = loginUser($user, $pass);

    if (isset($login['Success'])) {
        $_SESSION['usuario'] = $user;
        Header('Location: ' . URL::getBase());
    } else {
        $_SESSION['erro'] = $login['Erro'];
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <!-- Style CSS -->
    <link rel="stylesheet" href="assets/css/login.css">

    <!-- Fonte google -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Architects+Daughter&display=swap" rel="stylesheet">

    <!-- Icons -->
    <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <title>Login</title>
</head>

<body>
    <div class="img-fundo"></div>
    <div class="container">
        <div class="container-form"></div>
        <div class="body">
            <h2>Login</h2>
            <form id="form-login" method="POST">
                <div class="form-group">
                    <div class="icon">
                        <div class="container-icon">
                            <i class="fas fa-user"></i>
                        </div>
                        <input type="text" id="user" name="user" class="form-control" placeholder="Usuário">
                    </div>
                </div>
                <div class="form-group">
                    <div class="icon">
                        <div class="container-icon">
                            <i class="fas fa-key"></i>
                        </div>
                        <input type="password" id="pass" name="pass" class="form-control" placeholder="Senha">
                    </div>
                </div>
                <button class="btn btn-success logar">Logar</button>
            </form>
            <div class="login-result">
                <span id="result">
                    <?php if (isset($_SESSION['erro'])) {
                        echo $_SESSION['erro'];
                        session_destroy();
                    } ?>
                </span>
            </div>
        </div>
    </div>


</body>

</html>

<!-- <script src="../assets/js/jquery-3.5.1.min.js"></script>

<script>

    $("#form-login").submit()

</script> -->