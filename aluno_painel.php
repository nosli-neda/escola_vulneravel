<?php
session_start();
include('db.php');

// Verifica se o usuário está logado e se o cookie de sessão é válido
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || !isset($_COOKIE['session_id']) || $_COOKIE['session_id'] !== session_id()) {
    // Redireciona para a página de login se a sessão não for válida
    header("Location: aluno_login.php");
    exit();
}

// Obtém os dados do aluno logado
$email = $_SESSION['email'];
//$alunoid = $_GET["alunoid"];
$query = "SELECT * FROM dados_aluno WHERE email = '$email'";
//$query = "SELECT * FROM dados_aluno WHERE id = '$alunoid'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $aluno = $result->fetch_assoc();

} else {
    echo "Aluno não encontrado.";
    exit();
}

?>

<html>
    <body>
        <h1>Bem vindo ao Painel Principal</h1>
        <h3>Escolha uma das opções baixo:<h3>
            <a href="aluno_ver_materias.php?alunoid=<?php echo $aluno['id']; ?>">Ver Materias (Faltas e Notas)</a>
            <br>
            <a href="aluno_dashboard.php?alunoid=<?php echo $aluno['id']; ?>"">Ver Perfil</a>
    </body>
</html>