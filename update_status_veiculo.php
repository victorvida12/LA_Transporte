<?php
require "config.php";

if (!empty($_POST['status'])) {

    foreach ($_POST['status'] as $id => $status) {

        $stmt = $conn->prepare("UPDATE veiculos SET status=? WHERE id=?");
        $stmt->bind_param("si", $status, $id);
        $stmt->execute();
    }
}

header("Location: veiculos.php");
exit;
?>
