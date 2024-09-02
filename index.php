<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Escola Vulnerável - Página Inicial</title>
</head>
<body>
    <h2>Bem-vindo à Escola Vulnerável</h2>
    <p>Escolha seu perfil:</p>
    
    <!-- Links vulneráveis a LFI -->
    <a href=aluno_login.php>Login Aluno</a><br>
    <a href="professor_login.php">Login Professor</a>

    <?php
    if (isset($_GET['page'])) {
        $page = $_GET['page'];

        // Vulnerabilidade LFI: inclusão de arquivos sem validação
        //include($page . "_login.php");
        include($page);
    }
    ?>
</body>
</html>
