<?php
session_start();
if (!isset($_SESSION['loggedin']) || !isset($_POST['pez_id'])) {
    exit("Error");
}

try {
    $pdo = new PDO("mysql:host=db;dbname=pecera_digital;charset=utf8mb4", "root", "root_password");
    // Insertamos en TU tabla inventario
    $stmt = $pdo->prepare("INSERT INTO inventario (usuario_id, pez_id, cantidad) VALUES (?, ?, 1)");
    $stmt->execute([$_SESSION['usuario_id'], $_POST['pez_id']]); 
    echo "Guardado";
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>