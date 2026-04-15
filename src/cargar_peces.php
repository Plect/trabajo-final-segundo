<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    exit(json_encode([]));
}

try {
    $pdo = new PDO("mysql:host=db;dbname=pecera_digital;charset=utf8mb4", "root", "root_password");
    // Buscamos qué peces tiene el usuario y sacamos el emoji (tipo) del catálogo
    $stmt = $pdo->prepare("
        SELECT c.tipo 
        FROM inventario i
        JOIN catalogo_peces c ON i.pez_id = c.id
        WHERE i.usuario_id = ?
    ");
    $stmt->execute([$_SESSION['usuario_id']]);
    
    $peces = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($peces); 
} catch(PDOException $e) {
    echo json_encode([]);
}
?>