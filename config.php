<?php
// Configuração do banco de dados
$servername = "localhost";
$username = "root";
$password = ""; // se você definiu senha no MySQL, coloque aqui
$dbname = "la_transportes";

// Cria a conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
