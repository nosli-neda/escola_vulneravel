<?php
session_start();
include('db.php'); // Inclua o arquivo de configuração do banco de dados

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Concatena os dados diretamente na consulta SQL
    $query = "SELECT * FROM dados_aluno WHERE email = '$email' AND senha = '$senha'";
    $result = $conn->query($query);
    $aluno = $result->fetch_assoc();
    // Verifica se a combinação e-mail/senha foi encontrada
    if ($result->num_rows > 0) {
        // Cria uma sessão e armazena o e-mail
        $_SESSION['email'] = $email;
        $_SESSION['loggedin'] = true;
        setcookie('session_id', session_id(), time() + 3600, "/"); // Define um cookie com a sessão

        // Redireciona para a página de dashboard ou outra página protegida
        $id = $aluno["id"];
        header("Location: aluno_painel.php?alunoid=$id");
        exit();
    } else {
        $error = "E-mail ou senha incorretos.";
    }

    $result->free();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h2>Login do Aluno</h2>
    <?php if (isset($error)) { echo "<p style='color: red;'>$error</p>"; } ?>
    <form method="POST" action="">
        <label for="email" size="550">E-mail:</label>
        <input type="email" id="email" name="email" required size="60"><br><br>
        <label for="senha">Senha:</label>
        <input type="password" id="senha" name="senha" required size="60"><br><br>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>
