<?php
session_start();
include "config.php";

if(isset($_POST['status'])){
    foreach($_POST['status'] as $id => $status){
        $id = intval($id);
        $status = $conn->real_escape_string($status); // evita SQL injection
        $conn->query("UPDATE motoristas SET status='$status' WHERE id=$id");
    }
}

header("Location: func.php");
exit;
