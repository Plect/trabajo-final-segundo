<?php
session_start();
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $repeat_password = $_POST['repeat_password'];

    if (empty($username) || empty($password) || empty($repeat_password)) {
        $error = "Todos los campos son obligatorios.";
    } elseif ($password !== $repeat_password) {
        $error = "Las contraseñas no coinciden.";
    } else {
        try {
            $pdo = new PDO("mysql:host=db;dbname=pecera_digital;charset=utf8mb4", "root", "root_password");
            
            $stmt = $pdo->prepare("SELECT COUNT(*) FROM usuarios WHERE username = ?");
            $stmt->execute([$username]);
            if ($stmt->fetchColumn() > 0) {
                $error = "El usuario ya existe.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                $stmt = $pdo->prepare("INSERT INTO usuarios (username, password, dinero, nivel, xp_actual, xp_max) VALUES (?, ?, 90, 1, 0, 100)");
                $stmt->execute([$username, $hashed_password]);
                header("Location: inicioSesion.php?registrado=1");
                exit;
            }
        } catch(PDOException $e) {
            $error = "Error de base de datos: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Registro</h2>
        <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
        <form action="" method="post">
            <label for="username">Nombre de usuario:</label>
            <input type="text" id="username" name="username" required>
            
            <label for="password">Contraseña:</label>
            <input type="password" id="password" name="password" required>
            
            <label for="repeat_password">Repetir Contraseña:</label>
            <input type="password" id="repeat_password" name="repeat_password" required>
            
            <button type="submit">Crear cuenta</button>
        </form>
        <p>¿Ya tienes cuenta? <a href="inicioSesion.php">Inicia Sesión</a></p>
    </div>
</body>
</html>