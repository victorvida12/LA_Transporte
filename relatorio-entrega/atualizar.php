<?php
require "../config.php";

$id          = $_POST["id"] ?? 0;
$motorista   = $_POST["motorista_id"] ?? null;
$veiculo     = $_POST["veiculo_id"] ?? null;
$origem      = $_POST["origem"] ?? "";
$destino     = $_POST["destino"] ?? "";
$data_saida  = $_POST["data_saida"] ?? "";
$data_chegada = $_POST["data_chegada"] ?? "";
$status      = $_POST["status"] ?? "";

$stmt = $conn->prepare("
    UPDATE entregas 
    SET motorista_id=?, veiculo_id=?, origem=?, destino=?, data_saida=?, data_chegada=?, status=?
    WHERE id=?
");

$stmt->bind_param("iisssssi", $motorista, $veiculo, $origem, $destino, $data_saida, $data_chegada, $status, $id);

if ($stmt->execute()) {
    echo "OK";
} else {
    echo "ERRO: " . $stmt->error;
}
?>
