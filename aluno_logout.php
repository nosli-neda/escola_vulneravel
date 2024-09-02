<?php
session_start();
session_unset();
session_destroy();
setcookie('session_id', '', time() - 3600, "/"); // Remove o cookie da sessão

header("Location: aluno_login.php");
exit();
?>
