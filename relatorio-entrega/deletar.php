<?php
require "../config.php";

// Verificar se o ID veio pela URL
if (!isset($_GET["id"])) {
    die("ID inválido.");
}

$id = intval($_GET["id"]);

// Preparar e executar DELETE
$stmt = $conn->prepare("DELETE FROM relatorio_entregas WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Redirecionar de volta para o relatório
    header("Location: index.php?msg=deletado");
    exit;
} else {
    echo "Erro ao deletar registro.";
}
?>
