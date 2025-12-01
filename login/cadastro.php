<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Cadastro</title>
    <link rel="stylesheet" href="style_login.css" />
</head>
<body>
    <div class="login-wrapper">
        <div class="login-left">
            
        </div>
        <div class="login-right">
            <form class="login-form" action="cadastro_action.php" method="POST">
                <h1>CADASTRE-SE</h1>
                <p class="sub-title">Preencha seus dados.</p>

                <input type="text" id="userNome" name="userNome" placeholder="Nome completo" required />
                
                <input type="email" id="userEmail" name="userEmail" placeholder="E-mail" required />
                
                <input type="password" id="password" name="password" placeholder="Senha" required />

                <button type="submit">CADASTRAR</button>
            </form>

            <div class="login-footer">
                <p>Já tem conta? <a href="login.php">Entrar</a></p>
            </div>

        </div>
    </div>
</body>

</html>
