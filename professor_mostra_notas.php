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

//limpa variaveis;
$materia[] = "";
$bimestre[] = 0;
$nota[] = 0;
$faltas[] = 0;


// Obtém os dados do aluno logado
$aluno_id = $_POST["aluno_id"];
$bimestre = $_POST["bimestre"];

//$query_aluno = "select nome_completo, rgm, email, bimestre, materia, nota, faltas from dados_aluno right join notas_faltas on dados_aluno.rgm = notas_faltas.aluno_id where dados_aluno.rgm = $aluno_id and notas_faltas.bimestre = $bimestre;";
$query_aluno = "select * from dados_aluno where rgm = $aluno_id";
$alunos = $conn->query($query_aluno);
if ($alunos->num_rows > 0) 
{
    $aluno = $alunos->fetch_assoc();
    $rgm = $aluno['rgm'];
    $email = $aluno['email'];

} else
{
    echo "Aluno não encontrado.<br>";
    echo '<a href="professor_ver_notas.php" >Voltar</a>';

    exit();
}

$query_nota = "SELECT * FROM notas_faltas WHERE aluno_id = $rgm and bimestre = $bimestre";
echo '<a href="professor_ver_notas.php" >Voltar</a>';
//var_dump($query_nota);


$result = $conn->query($query_nota);
//$notas = $result->fetch_assoc();
//echo "<BR> Numero de resultados :" . $result->num_rows;
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
    echo "<h1>Matérias do aluno " . $aluno['nome_completo']. " </h1>";
    
    echo "<table border='1' align='left'>";
    echo "<tr>";
    echo "  <th align='center' style='color:white' bgcolor=#000000' width='150px'>MATÉRIA</th>";
    echo "  <th align='center' style='color:white' bgcolor=#000000'>BIMESTRE</th>";
    echo "  <th align='center' style='color:white' bgcolor=#000000'>NOTA</th>";
    echo "  <th align='center' style='color:white' bgcolor=#000000'>FALTA</th>";
    echo "</tr>";
    echo "<tr>";
    while($notas = $result->fetch_assoc())
    {
        //print_r($notas);
       
        //$materia[] = $notas['materia'];
        //$bimestre[] = $notas['bimestre'];
        //$nota[] = $notas['nota'];
        //$faltas[] = $notas['faltas'];
        echo "<td align='center' width='100px'>" . htmlspecialchars($notas['materia']) . "</td>";
        echo "<td align='center' width='100px'>" . htmlspecialchars($notas['bimestre']) . "</td>";
        echo "<td align='center' width='100px'>" . htmlspecialchars($notas['nota']) . "</td>";
        echo "<td align='center' width='100px'>" . htmlspecialchars($notas['faltas']) . "</td>";
        echo "</tr>";
    }

}
else
{
    echo "Aluno não encontrado.";
    echo '<a href="professor_ver_notas.php" >Voltar</a>';
    exit();
}

?>