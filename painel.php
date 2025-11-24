<?php
session_start();
include "config.php";

$funcionarios = $conn->query("SELECT id, nome, status FROM motoristas ORDER BY id ASC");
$veiculos = $conn->query("SELECT id, modelo, placa, status FROM veiculos ORDER BY id ASC");
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



</head>
<body>

<!-- SIDEBAR -->
<div class="sidebar">

    <div class="sidebar-header">
        <img src="img/logo-branca.png" class="logo">
        <span>LA Transportes</span>
    </div>

    <nav class="nav flex-column">
        <a class="nav-link active" href="painel.php"><i class="bi bi-house"></i> Painel</a>
        <a class="nav-link" href="agenda.html"><i class="bi bi-folder"></i> Agenda</a>
        <a class="nav-link" href="relatorio-entrega/index.php"><i class="bi bi-truck"></i> Entregas</a>
        <a class="nav-link" href="veiculos.php"><i class="bi bi-car-front"></i> Veículos</a>
        <a class="nav-link" href="relatorio-financeiro/finance.php"><i class="bi bi-currency-dollar"></i> Financeiro</a>
        <a class="nav-link" href="locacao.php"><i class="bi bi-tools"></i> Locação</a>
        <a class="nav-link" href="relatorio/relatorio.php"><i class="bi bi-bar-chart"></i> Relatório</a>
        <a class="nav-link" href="func.php"><i class="bi bi-people"></i> Funcionários</a>
    </nav>

    <div class="bottom">
        <a class="nav-link" href="#"><i class="bi bi-box-arrow-left"></i> Sair</a>
    </div>

</div>

<!-- CONTEÚDO -->
<div class="content">
    <div class="panel">

        <div class="panel-header">Painel de Funcionários</div>

        <table class="status-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>

            <?php if($funcionarios->num_rows > 0): ?>
                <?php while($f = $funcionarios->fetch_assoc()): ?>
                <tr>
                    <td><?= $f['id'] ?></td>
                    <td><?= htmlspecialchars($f['nome']) ?></td>
                    <td class="<?= $f['status']=='Disponível' ? 'status-available' : 'status-in-service' ?>">
                        <?= $f['status'] ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="3">Nenhum funcionário cadastrado.</td></tr>
            <?php endif; ?>

            </tbody>
        </table>

        <hr>

        <div class="panel-header">Veículos</div>

        <div class="cards-container">

        <?php if($veiculos->num_rows > 0): ?>
            <?php while($v = $veiculos->fetch_assoc()): ?>

            <?php
            $cor = 
                $v['status'] == 'Disponível' ? 'status-disponivel' :
                ($v['status'] == 'Em serviço' ? 'status-em-servico' : 'status-indisponivel');
            ?>

            <div class="card-item">
                <div class="card-panel">
                    <h4><?= htmlspecialchars($v['modelo']) ?></h4>
                    <p><b>Placa:</b> <?= htmlspecialchars($v['placa']) ?></p>
                    <p><b>Status:</b> <span class="<?= $cor ?>"><?= $v['status'] ?></span></p>
                </div>
            </div>

            <?php endwhile; ?>

        <?php else: ?>
            <div class="card-item"><div class="card-panel">Nenhum veículo cadastrado.</div></div>
        <?php endif; ?>

        </div>

        <hr>

        <div class="panel-header">Maquinário</div>
        <div class="cards-container">
            <div class="card-item">
                <div class="card-panel">Informações de maquinário serão exibidas aqui</div>
            </div>
        </div>

    </div>
</div>

</body>
</html>
