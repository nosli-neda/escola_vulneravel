<?php
session_start();
include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // SQL Injection vulnerability
    $query = "SELECT * FROM dados_aluno WHERE email='$email' AND senha='$senha'";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['aluno_id'] = $row['aluno_id'];

        // Criação de cookie vulnerável
        setcookie("user", $email, time() + (86400 * 30), "/");

        header("Location: dashboard.php");
    } else {
        echo "Email ou senha incorretos!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - Escola Vulnerável</title>
</head>
<body>
    <h2>Login do Aluno</h2>
    <form method="post" action="">
        <label for="email">Email:</label><br>
        <input type="text" id="email" name="email" size="50"><br>
        <label for="senha">Senha:</label><br>
        <input type="password" id="senha" name="senha"size="50"><br><br>
        <input type="submit" value="Login">
    </form>
</body>
</html>
