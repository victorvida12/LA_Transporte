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
  <link rel="stylesheet" href="relatorio.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body>

<div class="sidebar d-flex flex-column">
  <div class="col">  
      <div class="sidebar-header col"><img src="../img/logo-branca.png" alt="" class="logo col"><span class="col">LA Transportes</span></div>
  </div>
  <div class="search-box row">
      <i class="bi bi-search col"></i>
      <input type="text" placeholder="         Procurar" class="col search-box">
  </div>

  <nav class="nav flex-column">
      <a class="nav-link active" href="../painel.php"><i class="bi bi-house"></i> Painel</a>
      <a class="nav-link" href="../agenda.php"><i class="bi bi-folder"></i> Agenda</a>
      <a class="nav-link" href="../relatorio-entrega/index.php"><i class="bi bi-truck"></i> Entregas</a>
      <a class="nav-link" href="../veiculos.php"><i class="bi bi-car-front"></i> Veículos</a>
      <a class="nav-link" href="../rolatorio-financeiro/finance.php"><i class="bi bi-currency-dollar"></i> Financeiro</a>
      <a class="nav-link" href="../locacao.php"><i class="bi bi-tools"></i> Locação</a>
      <a class="nav-link" href="relatorio.php"><i class="bi bi-bar-chart"></i> Relatório</a>
      <a class="nav-link" href="../func.php"><i class="bi bi-people"></i> Funcionários</a>
  </nav>

  <div class="bottom">
      <a class="nav-link" href="#"><i class="bi bi-box-arrow-left"></i> Sair</a>
  </div>
</div>

<div class="container">

<header>
  <h2>Relatório de Entregas</h2>
</header>

<table class="table table-striped">
  <thead>
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
          <td><?= $e["local"] ?></td>
          <td><?= $e["data"] ?></td>
          <td><?= $e["status"] ?></td>
          <td><?= $e["descricao"] ?></td>

          <td>
              <a class="btn btn-danger btn-sm" href="excluir.php?id=<?= $e["id"] ?>" onclick="return confirm('Excluir registro?')">Excluir</a>
          </td>
      </tr>
      <?php endforeach; ?>
  </tbody>
</table>

<h3>Adicionar Nova Entrega ao Relatório</h3>
<form method="POST" action="salvar.php" class="form-add">
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
</body>
</html>
