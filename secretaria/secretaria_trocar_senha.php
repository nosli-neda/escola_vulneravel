<?php

include '../db.php';
require_once '../functions.php';


// Se o formulário for enviado, insira ou atualize a nota
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aluno_id = $_POST['aluno_id'];
    $senha = $_POST['senha'];

    // troca senha do aluno

    $sql_update = "UPDATE dados_aluno SET senha = '$senha' WHERE rgm = '$aluno_id'";
    if ($conn->query($sql_update) === TRUE)
    {
        echo "Senha Atualizada com Sucesso!";
        echo "<br><a href='secretaria.php' >Voltar</a>";
    }
    else
    {
        echo "Erro ao atualizar a senha: " . $conn->error;
        echo "<br><a href='secretaria.php' >Voltar</a>";
    }
}

$conn->close();
?>
