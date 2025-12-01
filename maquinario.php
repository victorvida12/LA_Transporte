<?php
require "config.php";

// Buscar locações com dados do veículo
$sql = "SELECT m.id, m.periodo_inicio, m.periodo_fim, v.modelo, v.placa 
        FROM maquinario m 
        JOIN veiculos v ON m.veiculo_id = v.id
        ORDER BY m.id DESC";
$result = $conn->query($sql);

// Buscar veículos para o select
$veiculos = $conn->query("SELECT * FROM veiculos ORDER BY modelo ASC");
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<title>Locação - LA Transportes</title>

<link rel="stylesheet" href="css/veiculo.css">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" href="css/style2.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    .adicionar-row input, .adicionar-row select { margin-right: 10px; margin-bottom:5px; }
    .botao-simples { padding: 6px 15px; background:#007bff; color:#fff; border:none; border-radius:4px; cursor:pointer; }
    .botao-simples:hover { background:#0056b3; }
    table th, table td { text-align:center; }
</style>

</head>
<body>

<!-- SIDEBAR -->
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
        <a class="nav-link active" href="maquinario.php"><i class="bi bi-tools"></i> Locação</a>
        <a class="nav-link" href="func.php"><i class="bi bi-people"></i> Funcionários</a>
    </nav>

    <div class="bottom">
        <a class="nav-link" href="#"><i class="bi bi-box-arrow-left"></i> Sair</a>
    </div>
</div>

<!-- CONTEÚDO -->
<div class="content">
<div class="panel">

    <div class="panel-header">
        <h3 style="margin:0;">Locação de Maquinário</h3>
    </div>

    <!-- LISTA DE LOCAÇÕES -->
    <table class="table table-bordered table-striped align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Veículo / Placa</th>
                <th>Início</th>
                <th>Fim</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
        <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= htmlspecialchars($row['modelo']) ?> - <?= htmlspecialchars($row['placa']) ?></td>
                <td><?= $row['periodo_inicio'] ?></td>
                <td><?= $row['periodo_fim'] ?></td>
                <td>
                    <a href="editar_locacao.php?id=<?= $row['id'] ?>" title="Editar">✎</a>
                    <button class="btn btn-sm btn-danger" onclick="remover(<?= $row['id'] ?>, this)">❌ Excluir</button>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>

    <hr>

    <!-- FORMULÁRIO DE ADIÇÃO -->
    <h4>Adicionar Locação</h4>
    <form id="formAddLocacao" class="d-flex flex-wrap">
        <select name="veiculo_id" id="veiculo_id" required>
            <option value="">Selecione o Veículo</option>
            <?php while($v = $veiculos->fetch_assoc()): ?>
            <option value="<?= $v['id'] ?>"><?= htmlspecialchars($v['modelo']) ?> - <?= htmlspecialchars($v['placa']) ?></option>
            <?php endwhile; ?>
        </select>
        <input type="date" name="periodo_inicio" id="periodo_inicio" required>
        <input type="date" name="periodo_fim" id="periodo_fim" required>
        <button type="submit" class="botao-simples">Adicionar Locação</button>
    </form>


</div>
</div>

</body>

<script>
const tabela = document.querySelector("tbody");
const formAdd = document.getElementById('formAddLocacao');

// Adicionar locação
formAdd.addEventListener('submit', e => {
    e.preventDefault();
    const dados = {
        veiculo_id: document.getElementById('veiculo_id').value,
        periodo_inicio: document.getElementById('periodo_inicio').value,
        periodo_fim: document.getElementById('periodo_fim').value
    };

    fetch('salvar_locacao.php', {
        method:'POST',
        headers:{'Content-Type':'application/json'},
        body: JSON.stringify(dados)
    })
    .then(res => res.json())
    .then(res => {
        if(res.success){
            // Adiciona linha na tabela sem recarregar
            const novaLinha = document.createElement('tr');
            novaLinha.innerHTML = `
                <td>${res.id}</td>
                <td>${res.modelo} - ${res.placa}</td>
                <td>${res.periodo_inicio}</td>
                <td>${res.periodo_fim}</td>
                <td>
                    <a href="editar_locacao.php?id=${res.id}" title="Editar">✎</a>
                    <button class="btn btn-sm btn-danger" onclick="remover(${res.id}, this)">❌ Excluir</button>
                </td>
            `;
            tabela.prepend(novaLinha);
            formAdd.reset();
        }
    });
});

// Excluir locação
function remover(id, btn){
    if(!confirm('Deseja realmente excluir esta locação?')) return;

    fetch(`excluir_locacao.php?id=${id}`, {method:'GET'})
    .then(res => res.json())
    .then(res => {
        if(res.success){
            // Remove a linha da tabela
            btn.closest('tr').remove();
        } else {
            alert('Erro ao excluir a locação.');
        }
    });
}


</script>

</html>
