<?php
require "config.php";

if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $sql = "DELETE FROM maquinario WHERE id=$id";
    if($conn->query($sql)){
        echo json_encode(['success'=>true]);
    } else {
        echo json_encode(['success'=>false]);
    }
} else {
    echo json_encode(['success'=>false]);
}
?>
