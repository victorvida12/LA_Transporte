<?php
require "../config.php";

$id = $_POST["id"];
$tipo = strtolower($_POST["tipo"]);
$descricao = $_POST["descricao"];
$valor = floatval($_POST["valor"]);
$data = $_POST["data_lancamento"];

$stmt = $conn->prepare("UPDATE financeiro SET tipo=?, descricao=?, valor=?, data_lancamento=? WHERE id=?");
$stmt->bind_param("ssdsi", $tipo, $descricao, $valor, $data, $id);
$stmt->execute();

header("Location: finance.php");
exit;
?>
