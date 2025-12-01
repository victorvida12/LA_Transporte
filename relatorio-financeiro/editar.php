<?php
require "../config.php";
$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'];
$tipo = $data['tipo'];
$descricao = $data['descricao'];
$valor = $data['valor'];
$data_lancamento = $data['data_lancamento'];

$sql = "UPDATE financeiro SET tipo=?, descricao=?, valor=?, data_lancamento=? WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssdsi", $tipo, $descricao, $valor, $data_lancamento, $id);

if($stmt->execute()){
    echo json_encode(['success'=>true]);
} else {
    echo json_encode(['success'=>false]);
}
