<?php
require "config.php";

// Buscar veículos
$sql = "SELECT * FROM veiculos ORDER BY id DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Veículos - LA Transportes</title>

    <link rel="stylesheet" href="css/veiculo.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style2.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>

</style>

</head>
<body>

<!-- ============================
     SIDEBAR PADRONIZADA
============================ -->
<div class="sidebar d-flex flex-column">

    <div class="sidebar-header">
        <img src="img/logo-branca.png" class="logo">
        <span>LA Transportes</span>
    </div>

    <nav class="nav flex-column">
        <a class="nav-link" href="painel.php"><i class="bi bi-house"></i> Painel</a>
        <a class="nav-link" href="relatorio-entrega/index.php"><i class="bi bi-truck"></i> Entregas</a>
        <a class="nav-link active" href="veiculos.php"><i class="bi bi-car-front"></i> Veículos</a>
        <a class="nav-link" href="relatorio-financeiro/finance.php"><i class="bi bi-currency-dollar"></i> Financeiro</a>
        <a class="nav-link" href="maquinario.php"><i class="bi bi-tools"></i> Locação</a>
        <a class="nav-link" href="func.php"><i class="bi bi-people"></i> Funcionários</a>
    </nav>

    <div class="bottom">
        <a class="nav-link" href="#"><i class="bi bi-box-arrow-left"></i> Sair</a>
    </div>
</div>

<!-- ============================
        CONTEÚDO
============================ -->
<div class="content">
<div class="panel">

    <div class="panel-header">
        <h3 style="margin:0;">Veículos</h3>
    </div>

    <!-- Atualizar status -->
    <form action="update_status_veiculo.php" method="POST">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Modelo</th>
                    <th>Placa</th>
                    <th>Ano</th>
                    <th>Tipo</th>
                    <th>Status</th>
                    <th>Ações</th>
                </tr>
            </thead>

            <tbody>
            <?php while($v = $result->fetch_assoc()): ?>

                <?php
                /* Normalização de status */
                $statusRaw = strtolower(str_replace(
                    ['á','ã','â','é','ê','í','ó','ô','ú','ç'],
                    ['a','a','a','e','e','i','o','o','u','c'],
                    $v['status']
                ));

                if ($statusRaw == "disponivel" || $statusRaw == "ativo") {
                    $statusExibido = "Disponível";
                } elseif ($statusRaw == "em servico" || $statusRaw == "manutencao") {
                    $statusExibido = "Em serviço";
                } else {
                    $statusExibido = "Indisponível";
                }
                ?>
                <tr>
                    <td><?= $v['id'] ?></td>
                    <td><?= htmlspecialchars($v['modelo']) ?></td>
                    <td><?= htmlspecialchars($v['placa']) ?></td>
                    <td><?= $v['ano'] ?></td>
                    <td><?= htmlspecialchars($v['tipo']) ?></td>

                    <td>
                        <select name="status[<?= $v['id'] ?>]">
                            <option value="Disponível"   <?= $statusExibido=="Disponível"?"selected":"" ?>>Disponível</option>
                            <option value="Em serviço"   <?= $statusExibido=="Em serviço"?"selected":"" ?>>Em serviço</option>
                            <option value="Indisponível" <?= $statusExibido=="Indisponível"?"selected":"" ?>>Indisponível</option>
                        </select>
                    </td>

                    <td>
                        <a href="editar_veiculo.php?id=<?= $v['id'] ?>" title="Editar">✎</a>
                        <a href="excluir_veiculo.php?id=<?= $v['id'] ?>"
                            onclick="return confirm('Excluir este veículo?')"
                            title="Excluir">
                            ✖
                        </a>
                    </td>
                </tr>

            <?php endwhile; ?>
            </tbody>
        </table>

        <div style="text-align:center; margin-top:15px;">
            <button class="botao-simples">Atualizar Status</button>
        </div>
    </form>

    <hr>

    <!-- Adicionar veículo -->
    <h4>Adicionar Veículo</h4>

    <form action="salvar_veiculo.php" method="POST">
        <div class="adicionar-row">
            <input type="text" name="modelo" placeholder="Modelo" required>
            <input type="text" name="placa" placeholder="Placa" required>
            <input type="number" name="ano" placeholder="Ano">
            <input type="text" name="tipo" placeholder="Tipo">

            <select name="status">
                <option value="Disponível">Disponível</option>
                <option value="Em serviço">Em serviço</option>
                <option value="Indisponível">Indisponível</option>
            </select>
        </div>

        <div style="text-align:center; margin-top:10px;">
            <button class="botao-simples">Adicionar</button>
        </div>
    </form>

</div>
</div>

</body>
</html>
