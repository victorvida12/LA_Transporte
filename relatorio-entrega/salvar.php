<?php
require "../config.php";

$local = $_POST["local"] ?? "";
$data = $_POST["data"] ?? null;
$status = $_POST["status"] ?? "";
$descricao = $_POST["descricao"] ?? "";

$stmt = $conn->prepare("
    INSERT INTO relatorio_entregas (local, data, status, descricao)
    VALUES (?, ?, ?, ?)
");

$stmt->bind_param("ssss", $local, $data, $status, $descricao);

if ($stmt->execute()) {
    header("Location: index.php");
    exit;
} else {
    echo "ERRO: " . $stmt->error;
}

?>
