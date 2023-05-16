<?php
// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Verifica se os campos foram preenchidos corretamente
    if (isset($_POST["username"]) && isset($_POST["password"])) {
        
        // Conecta ao banco de dados
        require_once "db_connection.php";
        
        // Escapa os dados do usuário para evitar injeção de SQL
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $password = mysqli_real_escape_string($conn, $_POST["password"]);
        
        // Executa uma consulta SQL para inserir os dados do usuário na tabela "users"
        $query = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        $result = mysqli_query($conn, $query);
        
        // Verifica se a consulta foi executada com sucesso
        if ($result) {
            $message = "Usuário cadastrado com sucesso!";
        } else {
            $message = "Falha ao cadastrar o usuário: " . mysqli_error($conn);
        }
        
        // Fecha a conexão com o banco de dados
        mysqli_close($conn);
    } else {
        $message = "Por favor, preencha todos os campos do formulário.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Usuário</title>
</head>
<body>
    <h1>Cadastro de Usuário</h1>
    
    <?php if (isset($message)): ?>
        <p><?php echo $message; ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <label>Username:</label>
        <input type="text" name="username" required>
        
        <label>Password:</label>
        <input type="password" name="password" required>
        
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
