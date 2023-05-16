<?php
session_start(); // Inicia a sessão

// Destroi a sessão
session_destroy();

// Redireciona para a página de login (ou outra página que você preferir)
header("Location: login.php");
exit();
?>