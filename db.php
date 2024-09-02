<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "escola_vulneravel";

// Criando conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Checando conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}
?>
