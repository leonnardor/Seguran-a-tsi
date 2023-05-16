<?php

session_start(); 

if (isset($_POST["username"]) && isset($_POST["password"])) {

    require_once "db_connection.php";

    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = mysqli_real_escape_string($conn, $_POST["password"]);

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION["user_id"] = $user["id"];

        header("Location: index.php");
        exit();
    } else {
        $error_message = "Usuário ou senha inválidos.";
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Login - Todo List</title>
</head>
<body>
    <h1>Login</h1>

    <?php if (isset($error_message)) { ?>
        <p><?php echo $error_message; ?></p>
    <?php } ?>

    <form method="post">
        <div>
            <label for="username">Usuário:</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div>
            <label for="password">Senha:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Entrar</button>
    </form>
</body>
</html>
