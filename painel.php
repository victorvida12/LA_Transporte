<?php
session_start();
include "config.php";

// =========================
// Dados Funcionários
// =========================
$funcionarios = $conn->query("SELECT id, nome, status FROM motoristas ORDER BY id ASC");

// =========================
// Dados Veículos (base)
// =========================
$veiculos = []; // placeholder

// =========================
// Dados Maquinário (base)
// =========================
$maquinario = []; // placeholder
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

<div class="sidebar d-flex flex-column">
    <div class="col">  
        <div class="sidebar-header col"><img src="img/logo-branca.png" alt="" class="logo col"><span class="col">LA Transportes</span></div>
    </div>
    <div class="search-box row">
        <i class="bi bi-search col"></i>
        <input type="text" placeholder="Procurar" class="col search-box">
    </div>

    <nav class="nav flex-column">
        <a class="nav-link active" href="painel.php"><i class="bi bi-house"></i> Painel</a>
        <a class="nav-link" href="agenda.html"><i class="bi bi-folder"></i> Agenda</a>
        <a class="nav-link" href="relatorio-entrega/index.php"><i class="bi bi-truck"></i> Entregas</a>
        <a class="nav-link" href="veiculos.html"><i class="bi bi-car-front"></i> Veículos</a>
        <a class="nav-link" href="relatorio-financeiro/finance.php"><i class="bi bi-currency-dollar"></i> Financeiro</a>
        <a class="nav-link" href="locacao.html"><i class="bi bi-tools"></i> Locação de Maquinário</a>
        <a class="nav-link" href="relatorio/relatorio.php"><i class="bi bi-bar-chart"></i> Relatório</a>
        <a class="nav-link" href="func.php"><i class="bi bi-people"></i> Funcionários</a>
    </nav>

    <div class="bottom">
        <a class="nav-link" href="#"><i class="bi bi-box-arrow-left"></i> Sair</a>
    </div>
</div>

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
                    <?php while($func = $funcionarios->fetch_assoc()): ?>
                        <tr>
                            <td><?= $func['id'] ?></td>
                            <td><?= htmlspecialchars($func['nome']) ?></td>
                            <td class="<?= $func['status']=='Disponível' ? 'status-available' : 'status-in-service' ?>">
                                <?= $func['status'] ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="3">Nenhum funcionário cadastrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <hr>
        <div class="panel-header">Veículos (Base)</div>
        <div class="cards-container">
            <div class="card-item"><div class="card-panel">Informações de veículos serão exibidas aqui</div></div>
        </div>

        <hr>
        <div class="panel-header">Maquinário (Base)</div>
        <div class="cards-container">
            <div class="card-item"><div class="card-panel">Informações de maquinário serão exibidas aqui</div></div>
        </div>
    </div>
</div>

</body>
</html>
