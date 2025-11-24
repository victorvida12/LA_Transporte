<?php
require "config.php";

$id = $_GET['id'];

$q = $conn->prepare("SELECT * FROM veiculos WHERE id = ?");
$q->bind_param("i", $id);
$q->execute();
$dados = $q->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Veículo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="p-4">

<h3>Editar Veículo</h3>
<form action="update_veiculo.php" method="POST">
    <input type="hidden" name="id" value="<?= $dados['id'] ?>">

    <label>Modelo:</label>
    <input class="form-control" type="text" name="modelo" value="<?= $dados['modelo'] ?>" required>

    <label>Placa:</label>
    <input class="form-control" type="text" name="placa" value="<?= $dados['placa'] ?>" required>

    <label>Ano:</label>
    <input class="form-control" type="number" name="ano" value="<?= $dados['ano'] ?>">

    <label>Tipo:</label>
    <input class="form-control" type="text" name="tipo" value="<?= $dados['tipo'] ?>">

    <label>Status:</label>
    <input class="form-control" type="text" name="status" value="<?= $dados['status'] ?>">

    <button class="btn btn-primary mt-3">Salvar</button>
</form>

</body>
</html>
