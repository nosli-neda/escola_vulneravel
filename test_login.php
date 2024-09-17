<?php
session_start();

// Credenciais fictícias de admin
$admin_username = 'admin';
$admin_password = 'password';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // Verifica se as credenciais são corretas
    if ($username === $admin_username && $password === $admin_password) {
        // Inicia a sessão de admin
        $_SESSION['admin'] = true;
        $_SESSION['username'] = $username;

        // Cria o cookie com a flag de admin
        setcookie('ADMIN', 'TRUE', time() + (86400 * 30), "/"); // 30 dias de duração
        
        // Redireciona para a página de administração
        header("Location: test_dashboard_admin.php");
        exit();
    } else {
        echo "Credenciais inválidas!";
    }
}

echo "<hr>";
echo $_SESSION['admin'];
echo "<hr>";

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
</head>
<body>
    <h2>Página de Login do Admin</h2>
    <form method="POST" action="">
        <label for="username">Usuário:</label>
        <input type="text" name="username" id="username" required>
        <br>
        <label for="password">Senha:</label>
        <input type="password" name="password" id="password" required>
        <br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
