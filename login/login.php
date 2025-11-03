<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - LA Transportes</title>
    <link rel="stylesheet" href="style_login.css" />
</head>
<body>
    <div class="login-wrapper">
        <div class="login-left">
        </div>

        <div class="login-right">
            <form class="login-form" action="../validar_login.php" method="POST">
                <h1>SEJA BEM-VINDO!</h1>
                <p class="sub-title">Preencha seus dados.</p>

                <input type="email" name="email" placeholder="E-mail" required />
                <input type="password" name="senha" placeholder="Senha" required />

                <div class="options">
                    <label>Lembrar-me<input type="checkbox" name="rememberMe"/> </label>
                    
                </div>
                <button type="submit">Entrar</button>
            </form>

            <div class="login-footer">
                <p>Não tem conta? <a href="cadastro.php">Inscrever-se</a></p>
            </div>
        </div>
    </div>
</body>
</html>
