<?php
require "config.php";

// Buscar locações com dados do veículo
$sql = "SELECT m.id, m.periodo_inicio, m.periodo_fim, v.modelo, v.placa 
        FROM maquinario m
        JOIN veiculos v ON m.veiculo_id = v.id
        ORDER BY m.periodo_inicio ASC";
$result = $conn->query($sql);

$eventos = [];
while($row = $result->fetch_assoc()) {
    $eventos[] = [
        'id' => $row['id'],
        'title' => $row['modelo'] . " - " . $row['placa'],
        'start' => $row['periodo_inicio'],
        'end' => date('Y-m-d', strtotime($row['periodo_fim'] . ' +1 day')) // inclui o último dia
    ];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>LA Transportes - Painel</title>

<link rel="stylesheet" href="css/painel.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/style2.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://uicdn.toast.com/tui-calendar/v1.15.0/tui-calendar.css">
<script src="https://uicdn.toast.com/tui-calendar/v1.15.0/tui-calendar.js"></script>





</head>

<style>
    body { font-family: Arial, sans-serif; margin:0; padding:0; }
    .content { margin-left: 220px; padding: 20px; }
    #calendar { max-width: 900px; margin: 0 auto; }
</style>
<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="sidebar-header">
        <img src="img/logo-branca.png" class="logo">
        <span>LA Transportes</span>
    </div>

    <nav class="nav flex-column">
        <a class="nav-link" href="painel.php"><i class="bi bi-house"></i> Painel</a>
        <a class="nav-link active" href="agenda.html"><i class="bi bi-folder"></i> Agenda</a>
        <a class="nav-link" href="relatorio-entrega/index.php"><i class="bi bi-truck"></i> Entregas</a>
        <a class="nav-link" href="veiculos.php"><i class="bi bi-car-front"></i> Veículos</a>
        <a class="nav-link" href="relatorio-financeiro/finance.php"><i class="bi bi-currency-dollar"></i> Financeiro</a>
        <a class="nav-link" href="maquinario.php"><i class="bi bi-tools"></i> Locação</a>
        <a class="nav-link" href="func.php"><i class="bi bi-people"></i> Funcionários</a>
    </nav>

    <div class="bottom">
        <a class="nav-link" href="#"><i class="bi bi-box-arrow-left"></i> Sair</a>
    </div>

</div>

<!-- CONTEÚDO -->
<div class="content">
    <h2>Agenda de Locação de Maquinário</h2>
    <div id="calendar"></div>
</div>
</body>
<script src="https://uicdn.toast.com/tui-calendar/latest/tui-calendar.js"></script>
<script>
    const calendar = new tui.Calendar('#calendar', {
        defaultView: 'month',
        taskView: false,
        scheduleView: ['time'],
        useCreationPopup: false,
        useDetailPopup: true
    });

    const eventos = <?php echo json_encode($eventos); ?>;

    eventos.forEach(e => {
        calendar.createSchedules([{
            id: e.id.toString(),
            calendarId: '1',
            title: e.title,
            category: 'time',
            start: e.start,
            end: e.end
        }]);
    });
</script>
</html>
