<?php

include('db.php');
require_once 'functions.php';

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
<?php echo "<a href='index.php' >Voltar</a>";?>
<h2>Página da Secretaría - Página de Administração de Senhas</h2>

<form method="POST" action="secretaria_trocar_senha.php">
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
    <input type="password" name="senha" id="senha">

    <input type="submit" value="Trocar Senha" >
</form>

</body>
</html>

<?php
    $conn->close();
?>