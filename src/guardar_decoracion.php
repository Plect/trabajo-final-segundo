<?php
session_start();
if (!isset($_SESSION['loggedin']) || !isset($_POST['decoracion_id'])) {
    exit("Error");
}

try {
    $pdo = new PDO("mysql:host=db;dbname=pecera_digital;charset=utf8mb4", "root", "root_password");
    // Insertamos en TU tabla inventario_decoraciones
    // CAMBIA ESTA LÍNEA:
    $stmt = $pdo->prepare("INSERT INTO inventario_decoraciones (usuario_id, decoracion_id, cantidad) VALUES (?, ?, 1)");
    $stmt->execute([$_SESSION['usuario_id'], $_POST['decoracion_id']]); 
    echo "Guardado";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>