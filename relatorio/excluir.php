<?php
require "../config.php";

$id = $_GET["id"];

// PREPARE
$sql = "DELETE FROM relatorio_entregas WHERE id = ?";
$stmt = $conn->prepare($sql);

// BIND
$stmt->bind_param("i", $id);

// EXECUTE
$stmt->execute();
$stmt->close();

// REDIRECIONA
header("Location: relatorio.php");
exit;
?>
