<?php
session_start();
include('db.php');

// Verifica se o usuário está logado e se o cookie de sessão é válido
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || !isset($_COOKIE['session_id']) || $_COOKIE['session_id'] !== session_id()) {
    // Redireciona para a página de login se a sessão não for válida
    header("Location: aluno_login.php");
    exit();
}

//limpa variaveis;
$materia[] = "";
$bimestre[] = 0;
$nota[] = 0;
$faltas[] = 0;


// Obtém os dados do aluno logado
$email = $_SESSION['email'];
$aluno_id = $_GET["alunoid"];
$query_aluno = "SELECT rgm FROM dados_aluno WHERE id = '$aluno_id'";
$alunos = $conn->query($query_aluno);
if ($alunos->num_rows > 0) {
    $aluno = $alunos->fetch_assoc();
    $rgm = $aluno['rgm'];
    
} else {
    echo "Aluno não encontrado.<br>";
    echo '<a href="aluno_painel.php?alunoid=' . $aluno_id . '" >Voltar</a>';
    exit();
}

$query_nota = "SELECT * FROM notas_faltas WHERE aluno_id = '$rgm'";

echo '<a href="aluno_painel.php?alunoid=' . $aluno_id . '" >Voltar</a>';


$result = $conn->query($query_nota);


if ($result->num_rows > 0)
{
    echo "<!DOCTYPE html>";
    echo "<html lang='pt-br'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>Notas e Faltas</title>";
    echo "</head>";
    echo "<body>";
    echo "<h1>Bem-vindo às suas Matérias.</h1>";
    echo "<p><b>" . htmlspecialchars($_SESSION['email']) . "</b>, você poderá acompanhar suas notas e faltas pora aqui.</p>";
    echo "<h2>Seus dados são:</h2>";
    echo "<table border='1' align='left'>";
    echo "<tr>";
    echo "  <th align='center' style='color:white' bgcolor=#000000' width='150px'>MATÉRIA</th>";
    echo "  <th align='center' style='color:white' bgcolor=#000000'>BIMESTRE</th>";
    echo "  <th align='center' style='color:white' bgcolor=#000000'>NOTA</th>";
    echo "  <th align='center' style='color:white' bgcolor=#000000'>FALTA</th>";
    echo "</tr>";
    echo "<tr>";
    //$notas = $result->fetch_assoc();
    while($notas = $result->fetch_assoc()){
        $materia[] = $notas['materia'];
        $bimestre[] = $notas['bimestre'];
        $nota[] = $notas['nota'];
        $faltas[] = $notas['faltas'];
        if($notas['bimestre'] == 1){$cortabela="#4169E1";}
        if($notas['bimestre'] == 2){$cortabela="#8B4513";}
        if($notas['bimestre'] == 3){$cortabela="#4169E1";}
        if($notas['bimestre'] == 4){$cortabela="#8B4513";}
        echo "<td align='center' style='color:white' bgcolor=" . $cortabela . " width='100px'>" . htmlspecialchars($notas['materia']) . "</td>";
        echo "<td align='center' style='color:white' bgcolor=" . $cortabela . " width='100px'>" . htmlspecialchars($notas['bimestre']) . "</td>";
        echo "<td align='center' style='color:white' bgcolor=" . $cortabela . " width='100px'>" . htmlspecialchars($notas['nota']) . "</td>";
        echo "<td align='center' style='color:white' bgcolor=" . $cortabela . " width='100px'>" . htmlspecialchars($notas['faltas']) . "</td>";
        echo "</tr>";
    }

}
else
{
    echo "Aluno não encontrado.";
    echo '<a href="aluno_dashboard.php?alunoid=' . $aluno_id . '" >Voltar</a>';
    exit();
}

?>