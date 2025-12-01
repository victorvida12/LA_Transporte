<?php
require "../config.php";

header("Content-Type: application/json; charset=utf-8");

$result = $conn->query("SELECT * FROM entregas ORDER BY id DESC");

$dados = [];

while ($row = $result->fetch_assoc()) {
    $dados[] = $row;
}

echo json_encode($dados);
?>
