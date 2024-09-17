<?php
session_start();

// Verifica se o admin está logado
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    echo "Acesso negado. Você não está autenticado como admin.";
    exit();
}

// Verifica se o cookie ADMIN está presente
if (!isset($_COOKIE['ADMIN']) || $_COOKIE['ADMIN'] !== 'TRUE') {
    echo "Acesso negado. Flag de admin ausente.";
    exit();
}
echo "<hr>";
echo $_SESSION['admin'];
echo "<hr>";
echo $_SESSION['username'];
echo "<hr>";
echo $_COOKIE['ADMIN'];
echo "<hr>";

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h1>Bem-vindo ao Painel Admin</h1>
    <p>Você está autenticado como administrador.</p>
    
    <a href="logout.php">Logout</a>
</body>
</html>
