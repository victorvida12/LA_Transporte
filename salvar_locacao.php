<?php
require "config.php";

header('Content-Type: application/json');

// 1. Receber e decodificar os dados JSON
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Verifica se os dados necessários estão presentes
if (!$data || !isset($data['veiculo_id'], $data['periodo_inicio'], $data['periodo_fim'])) {
    echo json_encode(['success' => false, 'message' => 'Dados incompletos ou inválidos.']);
    exit;
}

$veiculo_id = $data['veiculo_id'];
$periodo_inicio = $data['periodo_inicio'];
$periodo_fim = $data['periodo_fim'];

// 2. Inserir no banco de dados (Tabela 'maquinario')
$sql = "INSERT INTO maquinario (veiculo_id, periodo_inicio, periodo_fim) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iss", $veiculo_id, $periodo_inicio, $periodo_fim);

if ($stmt->execute()) {
    $novo_id = $stmt->insert_id;
    $stmt->close();

    // 3. Buscar informações adicionais do veículo para o retorno AJAX
    $sql_veiculo = "SELECT modelo, placa FROM veiculos WHERE id = ?";
    $stmt_veiculo = $conn->prepare($sql_veiculo);
    $stmt_veiculo->bind_param("i", $veiculo_id);
    $stmt_veiculo->execute();
    $result_veiculo = $stmt_veiculo->get_result();
    $veiculo_info = $result_veiculo->fetch_assoc();
    $stmt_veiculo->close();

    // 4. Retornar sucesso e dados para atualização da tabela
    echo json_encode([
        'success' => true,
        'id' => $novo_id,
        'modelo' => $veiculo_info['modelo'],
        'placa' => $veiculo_info['placa'],
        'periodo_inicio' => $periodo_inicio, // Adicionado para o JS
        'periodo_fim' => $periodo_fim // Adicionado para o JS
    ]);
} else {
    // 5. Retornar erro
    echo json_encode(['success' => false, 'message' => 'Erro ao inserir no banco de dados: ' . $stmt->error]);
}

$conn->close();
?>
