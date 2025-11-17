<?php
require "../config.php";

$tipo = strtolower(trim($_POST["tipo"]));
$descricao = $_POST["descricao"];
$valor = floatval($_POST["valor"]);
$data = $_POST["data_lancamento"];

$stmt = $conn->prepare("INSERT INTO financeiro (tipo, descricao, valor, data_lancamento) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssds", $tipo, $descricao, $valor, $data);
$stmt->execute();

header("Location: finance.php");
exit;
?>
