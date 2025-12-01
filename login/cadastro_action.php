<?php
session_start();
include "../config.php"; // mesmo usado no login

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome = trim($_POST['userNome']);
    $email = trim($_POST['userEmail']);
    $senha = trim($_POST['password']);

    if(empty($nome) || empty($email) || empty($senha)) {
        echo "<script>alert('Preencha todos os campos!'); history.back();</script>";
        exit;
    }

    // Verifica se email já existe
    $check = $conn->prepare("SELECT id FROM usuarios WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if($check->num_rows > 0){
        echo "<script>alert('E-mail já cadastrado!'); history.back();</script>";
        exit;
    }

    // Criptografa senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Insere no banco com campo nome
    $sql = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
    $sql->bind_param("sss", $nome, $email, $senhaHash);

    if($sql->execute()){
        echo "<script>
                alert('Cadastro realizado com sucesso!');
                window.location.href='login.php';
              </script>";
    } else {
        echo "<script>alert('Erro ao cadastrar'); history.back();</script>";
    }

}
?>
