<?php
require "../config.php";

$id = $_GET["id"];

$stmt = $conn->prepare("SELECT * FROM financeiro WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
$registro = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Editar Lançamento</title>
</head>
<body>

<h2>Editar Lançamento</h2>

<form method="POST" action="update.php">
    <input type="hidden" name="id" value="<?= $registro['id'] ?>">

    <input type="text" name="tipo" value="<?= $registro['tipo'] ?>" required>
    <input type="text" name="descricao" value="<?= $registro['descricao'] ?>" required>
    <input type="number" step="0.01" name="valor" value="<?= $registro['valor'] ?>" required>
    <input type="date" name="data_lancamento" value="<?= $registro['data_lancamento'] ?>" required>

    <button type="submit">Salvar</button>
</form>

</body>
</html>
