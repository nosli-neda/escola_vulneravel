<?php
//session_start();

include('db.php');
require_once 'functions.php';

if (validarSessao("aluno") == false)
{
    //Redireciona para a página de login se a sessão não for válida
    header("Location: aluno_login.php");
    exit();
}

// Obtém os dados do aluno logado
$email = $_SESSION['email'];
$alunoid = $_GET["alunoid"];
//$query = "SELECT * FROM dados_aluno WHERE email = '$email'";
$query = "SELECT * FROM dados_aluno WHERE id = '$alunoid'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $aluno = $result->fetch_assoc();
    //echo "Aluno identificado";
    //
    //print_r($aluno);

} else {
    echo "Aluno não encontrado.";
    exit();
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
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

    // Atualiza a sessão com os novos dados
    $result = $conn->query("SELECT * FROM dados_aluno WHERE id = '$id'");
    $aluno = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
    <h1>Bem-vindo ao Dashboard</h1>
    <p>Você está logado como <?php echo htmlspecialchars($_SESSION['email']); ?>.</p>

    <h2>Seus dados são:</h2>
    <table border="0" align="left">
        <tr>
            <td rowspan=12 width=180>
                <img src=fotos/foto_aluno_<?php echo $aluno["rgm"] . ".jpg";?> width="150px">
                <br><a href="foto_upload.php">Alerar Foto</a>
            </td>
            <th align="left" width=250>Nome Completo</th>
            <th align="left" width=250>Idade</th>
            <tr>
                <td><?php echo htmlspecialchars($aluno['nome_completo']); ?></td>
                <td><?php echo htmlspecialchars($aluno['idade']); ?></td>
            </tr>
            <tr>
                <th align="left">Nome da Mãe</th>
                <th align="left">Nome do Pai</th>            
            </tr>
            <tr>
                <td><?php echo htmlspecialchars($aluno['nome_mae']); ?></td>
                <td><?php echo htmlspecialchars($aluno['nome_pai']); ?></td>
            </tr>
            <tr>
                <th align="left">Série</th>
                <th align="left">RGM</th>
            </tr>
            <td><?php echo htmlspecialchars($aluno['serie']); ?></td>
            <td><?php echo htmlspecialchars($aluno['rgm']); ?></td>
        </tr>

        </tr>
        <tr>
            <th align="left">Rua</th>
            <th align="left">Bairro</th>
        </tr>
        <tr>
            <td><?php echo htmlspecialchars($aluno['endereco_rua']); ?></td>
            <td><?php echo htmlspecialchars($aluno['endereco_bairro']); ?></td>
        </tr>
        <tr>
            <th align="left">CEP</th>
            <th align="left">Cidade</th>
            <th align="left">Estado</th>
        </tr>
            <td><?php echo htmlspecialchars($aluno['endereco_cep']); ?></td>
            <td><?php echo htmlspecialchars($aluno['endereco_cidade']); ?></td>
            <td><?php echo htmlspecialchars($aluno['endereco_estado']); ?></td>
        <tr>
            <th align="left">Alterar os Dados?</th>
            <td><a href="aluno_alterar_dados.php?id=<?php echo htmlspecialchars($aluno['id']); ?>">Alterar</a></td>
        </tr>
        <tr><br></tr>
        <tr>
            <td><br><a href="aluno_painel.php?alunoid=<?php echo htmlspecialchars($aluno['id']); ?>">Voltar</a></td>
            <th align="left"></th>
        </tr>
    </table>
    

</body>
</html>
