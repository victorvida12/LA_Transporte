<?php
require "../config.php";

$local = $_POST["local"];
$data = $_POST["data"];
$status = $_POST["status"];
$descricao = $_POST["descricao"];

$sql = "INSERT INTO relatorio_entregas (local, data, status, descricao) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $local, $data, $status, $descricao);

$stmt->execute();
$stmt->close();

header("Location: relatorio.php");
exit;
?>
