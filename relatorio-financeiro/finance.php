<?php
require "../config.php";

// LISTAR REGISTROS
$sql = "SELECT * FROM financeiro ORDER BY id DESC";
$result = $conn->query($sql);

$registros = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $registros[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Relatório Financeiro</title>
  <link rel="stylesheet" href="finance.css" />
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
<div class="layout">

  <!-- SIDEBAR -->
  <div class="sidebar d-flex flex-column">
      <div class="col">  
          <div class="sidebar-header col">
              <img src="../img/logo-branca.png" alt="" class="logo col">
              <span class="col">LA Transportes</span>
          </div>
      </div>

      <div class="search-box row">
          <i class="bi bi-search col"></i>
          <input type="text" placeholder="         Procurar" class="col search-box">
      </div>

      <nav class="nav flex-column">
          <a class="nav-link" href="../painel.php"><i class="bi bi-house"></i> Painel</a>
          <a class="nav-link" href="../agenda.php"><i class="bi bi-folder"></i> Agenda</a>
          <a class="nav-link" href="../entregas.php"><i class="bi bi-truck"></i> Entregas</a>
          <a class="nav-link" href="../veiculos.index"><i class="bi bi-car-front"></i> Veículos</a>
          <a class="nav-link active" href="finance.php"><i class="bi bi-currency-dollar"></i> Financeiro</a>
          <a class="nav-link" href="../locacao.php"><i class="bi bi-tools"></i> Locação</a>
          <a class="nav-link" href="../relatorio/relatorio.php"><i class="bi bi-bar-chart"></i> Relatório</a>
          <a class="nav-link" href="../func.php"><i class="bi bi-people"></i> Funcionários</a>
      </nav>

      <div class="bottom">
          <a class="nav-link" href="#"><i class="bi bi-box-arrow-left"></i> Sair</a>
      </div>
  </div>


  <div class="container">

    <header>
      <h2>Financeiro</h2>

      <div class="btn-group" style="position: relative;">
        <button id="btnExportar">Exportar ▼</button>
        <div id="exportOptions" class="export-options" style="display:none;">
          <button onclick="exportToPDF()">Exportar PDF</button>
          <button onclick="exportToExcel()">Exportar Excel</button>
        </div>
      </div>
    </header>

    <!-- TABELA -->
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Tipo</th>
          <th>Descrição</th>
          <th>Valor (R$)</th>
          <th>Data</th>
          <th>Ações</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach ($registros as $r): ?>
        <tr>
          <td><?= $r["id"] ?></td>
          <td><?= $r["tipo"] ?></td>
          <td><?= $r["descricao"] ?></td>
          <td>R$ <?= number_format($r["valor"], 2, ",", ".") ?></td>
          <td><?= $r["data_lancamento"] ?></td>
          <td>

              <a class="btn btn-danger btn-sm" href="excluir.php?id=<?= $r["id"] ?>" onclick="return confirm('Excluir registro?')">Excluir</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <!-- FORM ADICIONAR -->
    <h3>Adicionar Lançamento</h3>

    <form class="form-add" method="POST" action="salvar.php">

      <select name="tipo" required>
          <option value="">Selecione</option>
          <option value="Entrada">Entrada</option>
          <option value="Saida">Saída</option>
      </select>

      <input type="number" name="valor" placeholder="Valor R$" step="0.01" required />
      <input type="text" name="descricao" placeholder="Descrição" />
      <input type="date" name="data_lancamento" required />

      <button type="submit">Adicionar</button>
    </form>

  </div>

</div>

<!-- Bibliotecas exportação -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
<script src="finance.js"></script>

</body>
</html>
