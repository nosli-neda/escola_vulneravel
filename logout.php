<?php
session_start();
session_unset();
session_destroy();

// Remove o cookie ADMIN
setcookie('auth', '', time() - 3600, "/"); // Expira o cookie

header("Location: index.php");
exit();
?>
