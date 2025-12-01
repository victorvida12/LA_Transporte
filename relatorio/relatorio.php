<?php
require_once "../config.php";

// LISTAR
$sql = "SELECT * FROM relatorio_entregas ORDER BY id DESC";
$result = $conn->query($sql);
$entregas = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $entregas[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title>Relatório de Entregas</title>


  <link rel="stylesheet" href="../css/relatorio.css" />
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/style2.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">


</head>
<body>

<div class="sidebar d-flex flex-column">

    <div class="sidebar-header">
        <img src="../img/logo-branca.png" class="logo">
        <span>LA Transportes</span>
    </div>

    <nav class="nav flex-column">
        <a class="nav-link" href="../painel.php"><i class="bi bi-house"></i> Painel</a>
        <a class="nav-link" href="../agenda.php"><i class="bi bi-folder"></i> Agenda</a>
        <a class="nav-link" href="../relatorio-entrega/index.php"><i class="bi bi-truck"></i> Entregas</a>
        <a class="nav-link" href="../veiculos.php"><i class="bi bi-car-front"></i> Veículos</a>
        <a class="nav-link" href="../relatorio-financeiro/finance.php"><i class="bi bi-currency-dollar"></i> Financeiro</a>
        <a class="nav-link" href="../locacao.php"><i class="bi bi-tools"></i> Locação</a>
        <a class="nav-link active" href="relatorio.php"><i class="bi bi-bar-chart"></i> Relatório</a>
        <a class="nav-link" href="../func.php"><i class="bi bi-people"></i> Funcionários</a>
    </nav>

    <div class="bottom">
        <a class="nav-link" href="#"><i class="bi bi-box-arrow-left"></i> Sair</a>
    </div>
</div>


<!-- ===========================
     CONTEÚDO
=========================== -->
<div class="main-content">

<div class="box-panel">

<header>
  <h2>Relatório de Entregas</h2>
</header>

<table class="table table-striped table-bordered align-middle">
  <thead class="table-light">
      <tr>
          <th>ID</th>
          <th>Local</th>
          <th>Data</th>
          <th>Status</th>
          <th>Descrição</th>
          <th>Ações</th>
      </tr>
  </thead>
  <tbody>
      <?php foreach($entregas as $e): ?>
      <tr>
          <td><?= $e["id"] ?></td>
          <td><?= htmlspecialchars($e["local"]) ?></td>
          <td><?= htmlspecialchars($e["data"]) ?></td>
          <td><?= htmlspecialchars($e["status"]) ?></td>
          <td><?= htmlspecialchars($e["descricao"]) ?></td>
          <td>
              <a class="btn btn-danger btn-sm" 
                 href="excluir.php?id=<?= $e["id"] ?>" 
                 onclick="return confirm('Excluir registro?')">
                 Excluir
              </a>
          </td>
      </tr>
      <?php endforeach; ?>
  </tbody>
</table>

<hr>

<h3>Adicionar Nova Entrega</h3>

<form method="POST" action="salvar.php" class="form-add d-flex flex-wrap">
    <input type="text" name="local" placeholder="Local" required>
    <input type="date" name="data" required>
    <select name="status" required>
        <option value="">Status</option>
        <option>Concluído</option>
        <option>Pendente</option>
    </select>
    <input type="text" name="descricao" placeholder="Descrição">
    <button type="submit">Adicionar</button>
</form>

</div>

</div>

</body>
</html>
