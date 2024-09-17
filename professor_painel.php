<?php
//session_start();

include('db.php');
require_once 'functions.php';

// Verifica se o usuário está logado e se o cookie de sessão é válido
//if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || !isset($_COOKIE['session_id']) || $_COOKIE['session_id'] !== session_id()) {
    // Redireciona para a página de login se a sessão não for válida
    //header("Location: professor_login.php");
    //exit();
//}
if (validarSessao("aluno"))
{
    //Redireciona para a página de login se a sessão não for válida
    header("Location: professor_login.php");
    exit();
}

// Obtém os dados do professor logado
$email = $_SESSION['email'];
$query = "SELECT * FROM dados_professor WHERE email = '$email'";

$result = $conn->query($query);

if ($result->num_rows > 0) {
    $professor = $result->fetch_assoc();

} else {
    echo "Professor não encontrado.";
    exit();
}


?>

<!-- Monta o HTML do Formulario -->
<html>
    <body>
        <h1>Painel Principal</h1><br>
        <h2><?php echo "Bem vindo(a), Prof. " . $professor['nome_completo']; ?></h2>
        <h3>Escolha uma das opções baixo:<h3>
            <a href="professor_ver_notas.php">Ver Materias (Faltas e Notas)</a>
            <br>
            <a href="professor_inserir_notas.php">Inserir Materias (Faltas e Notas)</a>
            <br>
            <a href="forum.php">Mensagens</a>
            <br>
            <a href="logout.php">Logout</a>
    </body>
</html>