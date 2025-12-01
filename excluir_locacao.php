<?php
require "config.php";

header('Content-Type: application/json');

// Verifica se o ID foi passado via GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode(['success' => false, 'message' => 'ID de locação inválido.']);
    exit;
}

$id = $_GET['id'];

// Prepara e executa a exclusão
$sql = "DELETE FROM maquinario WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Verifica se alguma linha foi afetada (se a exclusão realmente ocorreu)
    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true, 'message' => 'Locação excluída com sucesso.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Locação não encontrada.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Erro ao excluir locação: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
