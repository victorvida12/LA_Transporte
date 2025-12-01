<?php
require "../config.php";

$id = $_POST["id"];
$local = $_POST["local"];
$data = $_POST["data"];
$status = $_POST["status"];
$descricao = $_POST["descricao"];

$sql = "UPDATE relatorio_entregas 
        SET local = ?, data = ?, status = ?, descricao = ? 
        WHERE id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssi", $local, $data, $status, $descricao, $id);

$stmt->execute();
$stmt->close();

header("Location: relatorio.php");
exit;
?>
