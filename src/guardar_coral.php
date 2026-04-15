<?php
session_start();
if (!isset($_SESSION['loggedin']) || !isset($_POST['coral_id'])) {
    exit("Error");
}

try {
    $pdo = new PDO("mysql:host=db;dbname=pecera_digital;charset=utf8mb4", "root", "root_password");
    $stmt = $pdo->prepare("INSERT INTO inventario_corales (usuario_id, coral_id, cantidad) VALUES (?, ?, 1) ON DUPLICATE KEY UPDATE cantidad = cantidad + 1");
    $stmt->execute([$_SESSION['usuario_id'], $_POST['coral_id']]); 
    echo "Guardado";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>