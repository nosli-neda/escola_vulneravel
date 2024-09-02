<?php
session_start();
include('db.php');

// Verifica se o usuário está logado e se o cookie de sessão é válido
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || !isset($_COOKIE['session_id']) || $_COOKIE['session_id'] !== session_id()) {
    // Redireciona para a página de login se a sessão não for válida
    header("Location: login.php");
    exit();
}

// Verifica se o ID do aluno foi passado
if (!isset($_GET['id'])) {
    echo "ID do aluno não fornecido.";
    exit();
}

$id = $_GET['id'];

// Obtém os dados do aluno para o formulário
$query = "SELECT * FROM dados_aluno WHERE id = '$id'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $aluno = $result->fetch_assoc();
} else {
    echo "Aluno não encontrado.";
    exit();
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome_completo = $_POST['nome_completo'];
    $serie = $_POST['serie'];
    $idade = $_POST['idade'];
    $endereco_rua = $_POST['endereco_rua'];
    $endereco_cep = $_POST['endereco_cep'];
    $endereco_bairro = $_POST['endereco_bairro'];
    $endereco_cidade = $_POST['endereco_cidade'];
    $endereco_estado = $_POST['endereco_estado'];
    $nome_pai = $_POST['nome_pai'];
    $nome_mae = $_POST['nome_mae'];

    // Atualiza os dados do aluno
    $update_query = "UPDATE dados_aluno SET
        nome_completo = '$nome_completo',
        serie = '$serie',
        idade = '$idade',
        endereco_rua = '$endereco_rua',
        endereco_cep = '$endereco_cep',
        endereco_bairro = '$endereco_bairro',
        endereco_cidade = '$endereco_cidade',
        endereco_estado = '$endereco_estado',
        nome_pai = '$nome_pai',
        nome_mae = '$nome_mae'
        WHERE id = '$id'";
    $conn->query($update_query);

    // Redireciona de volta para o dashboard
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Dados</title>
</head>
<body>
    <h1>Alterar Dados do Aluno</h1>
    <form method="POST" action="">
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($aluno['id']); ?>">
        <label for="nome_completo">Nome Completo:</label>
        <input type="text" id="nome_completo" name="nome_completo" value="<?php echo htmlspecialchars($aluno['nome_completo']); ?>" required><br><br>
        <label for="serie">Série:</label>
        <input type="text" id="serie" name="serie" value="<?php echo htmlspecialchars($aluno['serie']); ?>" required><br><br>
        <label for="idade">Idade:</label>
        <input type="number" id="idade" name="idade" value="<?php echo htmlspecialchars($aluno['idade']); ?>" required><br><br>
        <label for="endereco_rua">Rua:</label>
        <input type="text" id="endereco_rua" name="endereco_rua" value="<?php echo htmlspecialchars($aluno['endereco_rua']); ?>" required><br><br>
        <label for="endereco_cep">CEP:</label>
        <input type="text" id="endereco_cep" name="endereco_cep" value="<?php echo htmlspecialchars($aluno['endereco_cep']); ?>" required><br><br>
        <label for="endereco_bairro">Bairro:</label>
        <input type="text" id="endereco_bairro" name="endereco_bairro" value="<?php echo htmlspecialchars($aluno['endereco_bairro']); ?>" required><br><br>
        <label for="endereco_cidade">Cidade:</label>
        <input type="text" id="endereco_cidade" name="endereco_cidade" value
