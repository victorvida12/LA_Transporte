<?php
require "../config.php";
$id = $_GET['id'];

$sql = "DELETE FROM financeiro WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if($stmt->execute()){
    echo json_encode(['success'=>true]);
} else {
    echo json_encode(['success'=>false]);
}
