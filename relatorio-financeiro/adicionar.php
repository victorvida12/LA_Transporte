<?php
require "../config.php";
$data = json_decode(file_get_contents('php://input'), true);

$tipo = $data['tipo'];
$descricao = $data['descricao'];
$valor = $data['valor'];
$data_lancamento = $data['data_lancamento'];

$sql = "INSERT INTO financeiro (tipo, descricao, valor, data_lancamento) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssds", $tipo, $descricao, $valor, $data_lancamento);
if($stmt->execute()){
    echo json_encode(['id' => $stmt->insert_id]);
} else {
    echo json_encode(['id' => null]);
}
