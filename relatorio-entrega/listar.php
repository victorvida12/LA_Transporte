<?php
require "../config.php";

header("Content-Type: application/json; charset=utf-8");

$sql = $conn->query("SELECT * FROM entregas ORDER BY id DESC");

$lista = [];

while ($row = $sql->fetch_assoc()) {
    $lista[] = $row;
}

echo json_encode($lista);
?>
