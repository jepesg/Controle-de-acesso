<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Assets/Login.css">
    <link rel="stylesheet" href="/Assets/Global.css">
    <title>Portaria/Acesso</title>
</head>

<body>
    <div>
        <form class="loginForm window" action="validaLogin.php" method="POST" onsubmit="return validaLogin();">
            <header class="titleLogin">Bem-vindo Colaborador(a)</header>
            <br>
            <div class="loginField" id="userLogin">
                <label for="userLogin">
                    <input required type="text" name="user" placeholder="Insira seu usuário">
                </label>
            </div>
            <div class="passLogin" id="passLogin">
                <label for="passLogin">
                    <input required type="password" name="pass" placeholder="Insira sua senha">
                </label>
            </div>
            <button id="submit" class="loginBtn">ACESSAR</button>
        </form>
    </div>
    <script src="/Assets/js/validaLogin.js"></script>
</body>

</html>