<?php
session_start();
include('db.php');

// Verifica se o usuário está logado e se o cookie de sessão é válido
if (!isset($_SESSION['loggedin']) || !$_SESSION['loggedin'] || !isset($_COOKIE['session_id']) || $_COOKIE['session_id'] !== session_id()) {
    // Redireciona para a página de login se a sessão não for válida
    header("Location: aluno_login.php");
    exit();
}

$email = $_SESSION['email'];

// Obtém o ID do aluno
$query = "SELECT id, foto, rgm FROM dados_aluno WHERE email = '$email'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $aluno = $result->fetch_assoc();
    $id = $aluno['id'];
    $rgm = $aluno['rgm'];
    $foto_atual = "foto_aluno_" . $aluno['rgm'] . ".jpg";
} else {
    echo "Aluno não encontrado.";
    exit();
}

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {
    $foto = $_FILES['foto'];
    
    // Verifica o MIME type para garantir que é uma imagem
    $mime_type = mime_content_type($foto['tmp_name']);
    $permitidos = ['image/jpeg'];

    if (in_array($mime_type, $permitidos)) {
        // Define o caminho para salvar a foto
        
        $extensao = pathinfo($foto['name'], PATHINFO_EXTENSION);
        //$extensao = ".jpg";
        $nome_foto = "foto_aluno_$rgm." . $extensao;
        $caminho_foto = "fotos/" . $nome_foto;
    
        // Move o arquivo para o diretório de fotos
        if (move_uploaded_file($foto['tmp_name'], $caminho_foto)) {
            // Atualiza o nome do arquivo da foto no banco de dados
            $update_query = "UPDATE dados_aluno SET foto = '$nome_foto' WHERE id = '$id'";
            $conn->query($update_query);

            echo "Foto enviada com sucesso.";
        } else {
            echo "Erro ao enviar a foto.";
        }
    } else {
        echo "Tipo de arquivo não permitido. Apenas JPG";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload de Foto</title>
</head>
<body>
    <h1>Upload de Foto</h1>
    
    <form method="POST" enctype="multipart/form-data">
        <label for="foto">Selecione uma foto:</label>
        <input type="file" id="foto" name="foto" accept="image/jpeg" required><br><br>
        <button type="submit">Enviar Foto</button>
    </form>

    <?php if ($foto_atual): ?>
        <h2>Foto Atual:</h2>
        <img src="fotos/<?php echo htmlspecialchars($foto_atual); ?>" alt="Foto do Aluno" style="max-width: 200px;">
        <br>
    <?php endif; ?>

    <a href=<?php echo "dashboard.php?alunoid=$id" ?>>Voltar ao Dashboard</a>
</body>
</html>
