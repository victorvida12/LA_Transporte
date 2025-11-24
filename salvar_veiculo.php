<?php
require "config.php";

$modelo = $_POST['modelo'];
$placa  = $_POST['placa'];
$ano    = $_POST['ano'];
$tipo   = $_POST['tipo'];
$status = $_POST['status'];

$stmt = $conn->prepare("INSERT INTO veiculos (placa, modelo, ano, tipo, status) VALUES (?,?,?,?,?)");
$stmt->bind_param("ssiss", $placa, $modelo, $ano, $tipo, $status);
$stmt->execute();

header("Location: veiculos.php");
exit;
?>
