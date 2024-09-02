<?php
// Conteúdo da página de login do professor
echo "<h2>Login do Professor</h2>";
echo "<form method='post' action='professor_login_process.php'>
        <label for='email'>Email:</label><br>
        <input type='text' id='email' name='email'><br>
        <label for='senha'>Senha:</label><br>
        <input type='password' id='senha' name='senha'><br><br>
        <input type='submit' value='Login'>
      </form>";
?>
