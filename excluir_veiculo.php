<?php
require "config.php";

$id = $_GET['id'];

$stmt = $conn->prepare("DELETE FROM veiculos WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

header("Location: veiculos.php");
exit;
?>
