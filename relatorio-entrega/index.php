<?php
require "../config.php";

// Buscar entregas no banco
$sql = "SELECT * FROM relatorio_entregas ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <title>Relatório de Entregas</title>

  <!-- Estilos -->
  <link rel="stylesheet" href="relatorio.css" />
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>

<body>
  <div class="layout">

    <!-- Sidebar -->
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
            <a class="nav-link" href="../agenda.html"><i class="bi bi-folder"></i> Agenda</a>
            <a class="nav-link active" href="../relatorio-entrega/index.php"><i class="bi bi-truck"></i> Entregas</a>
            <a class="nav-link" href="../veiculos.html"><i class="bi bi-car-front"></i> Veículos</a>
            <a class="nav-link" href="../financeiro.html"><i class="bi bi-currency-dollar"></i> Financeiro</a>
            <a class="nav-link" href="../locacao.html"><i class="bi bi-tools"></i> Locação de Maquinário</a>
            <a class="nav-link" href="index.php"><i class="bi bi-bar-chart"></i> Relatório</a>
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

        <!-- Tabela -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th></th>
                    <th>ID</th>
                    <th>Local</th>
                    <th>Data</th>
                    <th>Status</th>
                    <th>Descrição</th>
                    <th>Ação</th>
                </tr>
            </thead>

            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><input type="checkbox"></td>
                            <td><?= $row["id"] ?></td>
                            <td><?= $row["local"] ?></td>
                            <td><?= $row["data"] ?></td>
                            <td><?= $row["status"] ?></td>
                            <td><?= $row["descricao"] ?></td>
                            <td>
                                <a href="deletar.php?id=<?= $row['id'] ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Deseja excluir esta entrega?');">
                                   Excluir
                                </a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr><td colspan="7">Nenhuma entrega cadastrada.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Formulário -->
        <form class="form-add mt-4" action="salvar.php" method="POST">
            <input type="text" name="local" placeholder="Local" class="form-control mb-2" required>
            
            <label>Data:</label>
            <input type="date" name="data" class="form-control mb-2" required>
            
            <select name="status" class="form-control mb-2" required>
                <option value="Concluído">Concluído</option>
                <option value="Pendente">Pendente</option>
            </select>
            
            <input type="text" name="descricao" placeholder="Descrição" class="form-control mb-2">

            <button type="submit" class="btn btn-primary">Adicionar</button>
        </form>

    </div>

  </div>

  <!-- Scripts -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
  <script src="https://cdn.sheetjs.com/xlsx-latest/package/dist/xlsx.full.min.js"></script>
  <script src="relatorio.js"></script>
</body>
</html>
