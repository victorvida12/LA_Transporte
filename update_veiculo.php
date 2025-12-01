<?php
require "config.php";

$id     = $_POST['id'];
$modelo = $_POST['modelo'];
$placa  = $_POST['placa'];
$ano    = $_POST['ano'];
$tipo   = $_POST['tipo'];
$status = $_POST['status'];

$stmt = $conn->prepare("UPDATE veiculos SET placa=?, modelo=?, ano=?, tipo=?, status=? WHERE id=?");
$stmt->bind_param("ssissi", $placa, $modelo, $ano, $tipo, $status, $id);
$stmt->execute();

header("Location: veiculos.php");
exit;
?>
