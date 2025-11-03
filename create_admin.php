<?php
include "config.php";

$nome = "Admin";
$email = "admin@teste.com";
$senha = "123456"; // senha que você quer

$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $nome, $email, $senha_hash);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Usuário criado com sucesso!";
} else {
    echo "Erro ao criar usuário: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
