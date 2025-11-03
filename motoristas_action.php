<?php
session_start();
include "config.php";

$id = $_POST['id'] ?? 0;
$nome = $_POST['nome'] ?? '';
$telefone = $_POST['telefone'] ?? '';
$categoria = $_POST['categoria_cnh'] ?? '';
$validade = $_POST['validade_cnh'] ?? '';
$status = $_POST['status'] ?? 'Disponível';

// Excluir
if(isset($_GET['delete'])){
    $delete_id = intval($_GET['delete']);
    $conn->query("DELETE FROM motoristas WHERE id=$delete_id");
    header("Location: func.php");
    exit;
}

// Inserir ou atualizar
if($id){
    $sql = "UPDATE motoristas SET 
            nome='$nome',
            telefone='$telefone',
            categoria_cnh='$categoria',
            validade_cnh='$validade',
            status='$status'
            WHERE id=$id";
}else{
    $sql = "INSERT INTO motoristas (nome, telefone, categoria_cnh, validade_cnh, status) 
            VALUES ('$nome', '$telefone', '$categoria', '$validade', '$status')";
}

if($conn->query($sql)){
    header("Location: func.php");
    exit;
}else{
    echo "Erro: ".$conn->error;
}
