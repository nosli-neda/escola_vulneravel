<?php
//session_start();

include('db.php');
require_once 'functions.php';


if (validarSessao("aluno"))
{
    //Redireciona para a página de login se a sessão não for válida
    header("Location: professor_login.php");
    exit();
}

// Pega os dados dos alunos para exibir no formulário
$sql_alunos = "SELECT id, nome_completo, rgm, serie FROM dados_aluno";
$result_alunos = $conn->query($sql_alunos);


?>
<!-- Inicia o Formulario de Escolha de Aluno -->
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultar Nota</title>
</head>
<body>
<?php echo "<a href='professor_painel.php' >Voltar</a>";?>
<h2>Consultar Notas e Faltas do Aluno</h2>

<form method="POST" action="professor_mostra_notas.php">
    <label for="aluno_id">Escolha o Aluno:</label>
    <select name="aluno_id" id="aluno_id" required>
        <option value="">Selecione um aluno</option>
        
        <?php
        // Preencher a lista de alunos
        if ($result_alunos->num_rows > 0) 
        {
            while($row = $result_alunos->fetch_assoc())
            {
                echo "<option value='" . $row['rgm'] . "'>" . $row['rgm'] . " - " . $row['nome_completo'] . " - " . $row['serie'] . "</option>";
            }
        }
        ?>
    </select>
    <br><br>

    <label for="bimestre">Bimestre:</label>
    <select name="bimestre" id="bimestre" required>
        <option value="1">1º Bimestre</option>
        <option value="2">2º Bimestre</option>
        <option value="3">3º Bimestre</option>
        <option value="4">4º Bimestre</option>
    </select>
    <br><br>

    <br><br>

    <input type="submit" value="Buscar">
</form>

</body>
</html>

<?php
    $conn->close();
?>