<?php
require "config.php";
$data = json_decode(file_get_contents('php://input'), true);

$veiculo = intval($data['veiculo_id']);
$inicio = $conn->real_escape_string($data['periodo_inicio']);
$fim = $conn->real_escape_string($data['periodo_fim']);

// Inserir
$conn->query("INSERT INTO maquinario (veiculo_id, periodo_inicio, periodo_fim) 
              VALUES ($veiculo, '$inicio', '$fim')");
$id = $conn->insert_id;

// Buscar dados do veículo para exibir
$veiculoData = $conn->query("SELECT modelo, placa FROM veiculos WHERE id=$veiculo")->fetch_assoc();

echo json_encode(['success'=>true,'id'=>$id,'modelo'=>$veiculoData['modelo'],'placa'=>$veiculoData['placa']]);
?>