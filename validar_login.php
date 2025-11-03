<?php
session_start();
include "config.php";

$email = $_POST['email'];
$senha = $_POST['senha'];

// Usando prepared statement para segurança
$stmt = $conn->prepare("SELECT id, nome, senha FROM usuarios WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();

    // Verifica senha hash
    if (password_verify($senha, $user['senha'])) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario_nome'] = $user['nome'];
        header("Location: painel.php");
        exit;
    }
}

// Se chegou aqui, login inválido
echo "<script>alert('Login inválido'); window.location='login.php';</script>";
?>
