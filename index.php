<?php

session_start(); // Inicia a sessão

// Verifica se o usuário está autenticado
if (!isset($_SESSION["user_id"])) {
    // Se o usuário não estiver autenticado, redireciona para a página de login
    header("Location: login.php");
    exit();
}

// Conecta ao banco de dados
require_once "db_connection.php";

// Obtém a lista de tarefas do usuário atual
$user_id = $_SESSION["user_id"];
$query = "SELECT * FROM tasks WHERE user_id=$user_id";
$result = mysqli_query($conn, $query);

$tasks = array();
while ($row = mysqli_fetch_assoc($result)) {
    $tasks[] = $row;
}

// Adiciona uma nova tarefa junto com o status, se for o caso
if (isset($_POST["new_task"]) && !empty(trim($_POST["new_task"]))) {
    
    // Escapa os dados recebidos
    $new_task = mysqli_real_escape_string($conn, $_POST["new_task"]);
    $new_status = mysqli_real_escape_string($conn, $_POST["new_status"]);

    // Insere a nova tarefa no banco de dados
    $query = "INSERT INTO tasks (description, status, user_id) VALUES ('$new_task', '$new_status', $user_id)";
    mysqli_query($conn, $query);

    // Atualiza a lista de tarefas
    $query = "SELECT * FROM tasks WHERE user_id=$user_id";
    $result = mysqli_query($conn, $query);


    $tasks = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $tasks[] = $row;
    }
}

// Remove uma tarefa, se for o caso
if (isset($_POST["delete_task_id"])) {
    // Escapa o ID da tarefa para evitar ataques de SQL Injection
    $delete_task_id = mysqli_real_escape_string($conn, $_POST["delete_task_id"]);

    // Remove a tarefa do banco de dados
    $query = "DELETE FROM tasks WHERE id=$delete_task_id AND user_id=$user_id";
    mysqli_query($conn, $query);

    // Atualiza a lista de tarefas
    $query = "SELECT * FROM tasks WHERE user_id=$user_id";
    $result = mysqli_query($conn, $query);

    $tasks = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $tasks[] = $row;
    }
}


?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Todo List</title>
    <link rel="stylesheet" href="index.css">

</head>
<body>
    <h1>Minhas Tarefas</h1>

    <form method="post">
    <div>
        <label for="new_task">Nova Tarefa:</label>
        <input type="text" id="new_task" name="new_task">
        <select name="new_status">
            <option value="pendente">Pendente</option>
            <option value="concluida">Concluída</option>
        </select>
        <button type="submit">Adicionar</button>
    </div>
</form>


    <!-- Lista de tarefas -->
    <ul>
        <?php foreach ($tasks as $task): ?>
            <li>
                <form method="post">
                    <input type="hidden" name="delete_task_id" value="<?php echo $task["id"]; ?>">
                    <button type="submit">X</button>
                </form>
                <?php echo $task["description"]; ?>
                <span>(<?php echo $task["status"]; ?>)</span>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="logout.php">Sair</a>
</body>
</html>