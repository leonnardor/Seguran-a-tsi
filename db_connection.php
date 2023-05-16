<?php

// Define as credenciais de conexão com o banco de dados
$host = "localhost";
$user = "root";
$pass = "";
$db_name = "todo_list";

// Cria a conexão com o banco de dados
$conn = mysqli_connect($host, $user, $pass, $db_name);

// Verifica se ocorreu algum erro na conexão
if (!$conn) {
    die("Falha ao conectar com o banco de dados: " . mysqli_connect_error());
}
?>

