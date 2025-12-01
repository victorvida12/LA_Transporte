<?php
require "config.php";

$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $id = $data['id'] ?? null;
    $veiculo_id = $data['veiculo'] ?? null;
    $periodo_inicio = $data['periodo_inicio'] ?? null;
    $periodo_fim = $data['periodo_fim'] ?? null;

    if (!$id || !$veiculo_id || !$periodo_inicio || !$periodo_fim) {
        http_response_code(400);
        echo json_encode(["error"=>"Campos obrigatórios"]);
        exit;
    }

    $stmt = $conn->prepare("UPDATE maquinario SET veiculo_id=?, periodo_inicio=?, periodo_fim=? WHERE id=?");
    $stmt->bind_param("issi", $veiculo_id, $periodo_inicio, $periodo_fim, $id);

    if ($stmt->execute()) {
        echo json_encode(["success"=>true]);
    } else {
        http_response_code(500);
        echo json_encode(["error"=>$stmt->error]);
    }
} else {
    http_response_code(400);
    echo json_encode(["error"=>"Dados inválidos"]);
}
?>
