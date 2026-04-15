<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    exit(json_encode([]));
}

try {
    $pdo = new PDO("mysql:host=db;dbname=pecera_digital;charset=utf8mb4", "root", "root_password");
    // Buscamos qué decoraciones tiene el usuario y sacamos el emoji (tipo) del catálogo
    $stmt = $pdo->prepare("
        SELECT c.tipo 
        FROM inventario_decoraciones i
        JOIN catalogo_decoraciones c ON i.decoracion_id = c.id
        WHERE i.usuario_id = ?
    ");
    $stmt->execute([$_SESSION['usuario_id']]);
    
    $decoraciones = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($decoraciones); 
} catch(PDOException $e) {
    echo json_encode([]);
}
?>