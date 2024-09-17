<?php
//session_start();
include('db.php'); // Inclua o arquivo de configuração do banco de dados

require_once 'functions.php'; // inclusão do arquivo de funções.

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Captura os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Concatena os dados diretamente na consulta SQL
    $query = "SELECT * FROM dados_professor WHERE email = '$email' AND senha = '$senha'";
    print_r($query);
    $result = $conn->query($query);
    $professor = $result->fetch_assoc();
    // Verifica se a combinação e-mail/senha foi encontrada
    
    if ($result->num_rows > 0) {
        
        // Cria uma sessão e armazena o e-mail
        //$_SESSION['email'] = $email;
        //$_SESSION['loggedin'] = true;
        
        // Cria um array com os dados de autenticação
        //$auth_data = array(
        //    'PHPSESSID' => $session_id,
        //   'PROFESSOR' => $professor_status
        //);
        //setcookie('session_id', session_id(), time() + 3600, "/"); // Define um cookie com a sessão
        //setcookie(name: 'professor', value: true );

        // Redireciona para a página de dashboard ou outra página protegida

        criarSessao($email, true);

        header("Location: professor_painel.php");
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
    <h2>Login do Professor</h2>
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
