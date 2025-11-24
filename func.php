<?php
session_start();
include "config.php";

// Buscar todos os motoristas
$sql = "SELECT * FROM motoristas ORDER BY id ASC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>LA Transportes - Funcionários</title>
<link rel="stylesheet" href="func.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/style2.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

</head>
<body>

<div class="sidebar d-flex flex-column">

    <div class="sidebar-header">
        <img src="img/logo-branca.png" class="logo">
        <span>LA Transportes</span>
    </div>

    <nav class="nav flex-column">
        <a class="nav-link" href="painel.php"><i class="bi bi-house"></i> Painel</a>
        <a class="nav-link" href="relatorio-entrega/index.php"><i class="bi bi-truck"></i> Entregas</a>
        <a class="nav-link" href="veiculos.php"><i class="bi bi-car-front"></i> Veículos</a>
        <a class="nav-link" href="relatorio-financeiro/finance.php"><i class="bi bi-currency-dollar"></i> Financeiro</a>
        <a class="nav-link" href="maquinario.php"><i class="bi bi-tools"></i> Locação</a>
        <a class="nav-link active" href="func.php"><i class="bi bi-people"></i> Funcionários</a>
    </nav>

    <div class="bottom">
        <a class="nav-link" href="#"><i class="bi bi-box-arrow-left"></i> Sair</a>
    </div>
</div>

<div class="content">
    <div class="panel">

        <div class="panel-header">Funcionários</div>

        <form action="motoristas_status_action.php" method="POST">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Telefone</th>
                        <th>Categoria</th>
                        <th>Validade CNH</th>
                        <th>Status</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>

                <?php if($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row["id"] ?></td>
                        <td><?= htmlspecialchars($row["nome"]) ?></td>
                        <td><?= htmlspecialchars($row["telefone"]) ?></td>
                        <td><?= htmlspecialchars($row["categoria_cnh"]) ?></td>
                        <td><?= htmlspecialchars($row["validade_cnh"]) ?></td>

                        <td>
                            <select name="status[<?= $row['id'] ?>]">
                                <option value="Disponível" <?= $row['status']=="Disponível"?"selected":"" ?>>Disponível</option>
                                <option value="Em Serviço" <?= $row['status']=="Em Serviço"?"selected":"" ?>>Em Serviço</option>
                            </select>
                        </td>

                        <td>
                            <a href="func.php?edit=<?= $row['id'] ?>">✏️</a>
                            <a href="motoristas_action.php?delete=<?= $row['id'] ?>" onclick="return confirm('Excluir?')">❌</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>

                <?php else: ?>
                    <tr><td colspan="7">Nenhum motorista encontrado.</td></tr>
                <?php endif; ?>

                </tbody>
            </table>

            <div style="text-align:center;">
                <button class="botao-simples">Atualizar Status</button>
            </div>
        </form>

        <hr>

        <div class="subtitulo">
            <?= isset($_GET["edit"]) ? "Editar Motorista" : "Adicionar Motorista" ?>
        </div>

        <?php
        $edit_id = 0; 
        $edit_nome = $edit_telefone = $edit_cnh = $edit_categoria = $edit_validade = "";

        if(isset($_GET["edit"])) {
            $edit_id = intval($_GET["edit"]);
            $q = $conn->query("SELECT * FROM motoristas WHERE id=$edit_id");
            if($q->num_rows > 0) {
                $e = $q->fetch_assoc();
                $edit_nome = $e["nome"];
                $edit_telefone = $e["telefone"];
                $edit_categoria = $e["categoria_cnh"];
                $edit_validade = $e["validade_cnh"];
            }
        }
        ?>

        <form action="motoristas_action.php" method="POST">
            <input type="hidden" name="id" value="<?= $edit_id ?>">

            <div class="adicionar-row">
                <input type="text" name="nome" placeholder="Nome" value="<?= $edit_nome ?>" required>
                <input type="text" name="telefone" placeholder="Telefone" value="<?= $edit_telefone ?>">

                <select name="categoria_cnh">
                    <option value="">Categoria</option>
                    <option value="Maquinário" <?= $edit_categoria=="Maquinário"?"selected":"" ?>>Maquinário</option>
                    <option value="Caminhão" <?= $edit_categoria=="Caminhão"?"selected":"" ?>>Caminhão</option>
                </select>

                <input type="date" name="validade_cnh" value="<?= $edit_validade ?>">
            </div>

            <div style="text-align:center; margin-top:10px;">
                <button class="botao-simples"><?= $edit_id ? "Atualizar" : "Adicionar" ?></button>
            </div>

        </form>

    </div>
</div>

</body>
</html>
