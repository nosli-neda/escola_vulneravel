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

// Se o formulário for enviado, insira ou atualize a nota
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aluno_id = $_POST['aluno_id'];
    $bimestre = $_POST['bimestre'];
    $materia = $_POST['materia'];
    $nota = $_POST['nota'];
    $faltas = $_POST['faltas'];

    // Verificar se já existe uma nota para o aluno, matéria e bimestre selecionados
    $sql_check = "SELECT * FROM notas_faltas WHERE aluno_id = $aluno_id AND bimestre = $bimestre AND materia = '$materia'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows > 0) {
        // Se existir, atualize a nota
        $sql_update = "UPDATE notas_faltas SET nota = $nota, faltas = $faltas WHERE aluno_id = $aluno_id AND bimestre = $bimestre AND materia = '$materia'";
        if ($conn->query($sql_update) === TRUE) {
            echo "Nota atualizada com sucesso!";
        } else {
            echo "Erro ao atualizar a nota: " . $conn->error;
        }
    } else {
        // Se não existir, insira uma nova nota
        $sql_insert = "INSERT INTO notas_faltas (aluno_id, bimestre, materia, nota, faltas) VALUES ($aluno_id, $bimestre, '$materia', $nota, $faltas)";
        if ($conn->query($sql_insert) === TRUE) {
            echo "Nota inserida com sucesso!";
        } else {
            echo "Erro ao inserir a nota: " . $conn->error;
        }
    }
}

// Pega os dados dos alunos para exibir no formulário
$sql_alunos = "SELECT id, nome_completo, rgm, serie FROM dados_aluno";
$result_alunos = $conn->query($sql_alunos);

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inserir Nota</title>
</head>
<body>

<h2>Inserir Nota do Aluno</h2>

<form method="POST" action="">
    <label for="aluno_id">Escolha o Aluno:</label>
    <select name="aluno_id" id="aluno_id" required>
        <option value="">Selecione um aluno</option>
        <?php
        // Preencher a lista de alunos
        if ($result_alunos->num_rows > 0) {
            while($row = $result_alunos->fetch_assoc()) {
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

    <label for="materia">Matéria:</label>
    <select name="materia" id="materia" required>
        <option value="Portugues">Portugues</option>
        <option value="Ingles">Ingles</option>
        <option value="Matematica">Matematica</option>
        <option value="Historia">Historia</option>
        <option value="Ciencias">Ciencias</option>
        <option value="Educacao Fisica">Educacao Fisica</option>
        <option value="Artes">Artes</option>
        <option value="Geografia">Geografia</option>
        <option value="Musica">Musica</option>
    </select>
    <br><br>

    <label for="nota">Nota:</label>
    <input type="number" step="0.01" name="nota" id="nota" required>
    <br><br>

    <label for="faltas">Faltas:</label>
    <input type="number" name="faltas" id="faltas" required>
    <br><br>

    <input type="submit" value="Salvar Nota">
</form>

</body>
</html>

<?php
$conn->close();
?>
