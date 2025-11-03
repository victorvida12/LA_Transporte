<?php
include "config.php";

// Inserir ou atualizar
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = intval($_POST['id']);
    $nome = $conn->real_escape_string($_POST['nome']);
    $telefone = $conn->real_escape_string($_POST['telefone']);
    $categoria = $conn->real_escape_string($_POST['categoria_cnh']);
    $validade = $conn->real_escape_string($_POST['validade_cnh']);

    if($id > 0){
        $sql = "UPDATE motoristas SET nome='$nome', telefone='$telefone', categoria_cnh='$categoria', validade_cnh='$validade' WHERE id=$id";
    } else {
        $sql = "INSERT INTO motoristas (nome, telefone, categoria_cnh, validade_cnh) VALUES ('$nome','$telefone','$categoria','$validade')";
    }

    $conn->query($sql);
    header("Location: func.php");
    exit;
}

// Excluir
if(isset($_GET['delete'])){
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM motoristas WHERE id=$id");
    header("Location: func.php");
    exit;
}
?>
