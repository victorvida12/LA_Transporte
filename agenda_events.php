<?php
require "config.php";

// Buscar locações com dados do veículo
$sql = "SELECT m.id, v.modelo, m.periodo_inicio, m.periodo_fim
        FROM maquinario m
        JOIN veiculos v ON m.veiculo_id = v.id";
$result = $conn->query($sql);

$events = [];
while($row = $result->fetch_assoc()) {
    $events[] = [
        'title' => $row['modelo'], // título do evento
        'start' => $row['periodo_inicio'], // início
        'end' => date('Y-m-d', strtotime($row['periodo_fim'].' +1 day')) // FullCalendar não inclui o último dia
    ];
}

header('Content-Type: application/json');
echo json_encode($events);
?>
