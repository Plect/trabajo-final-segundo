<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['loggedin'])) {
    echo json_encode([]);
    exit;
}

try {
    $pdo = new PDO("mysql:host=db;dbname=pecera_digital;charset=utf8mb4", "root", "root_password");
    $stmt = $pdo->prepare("SELECT c.tipo, i.cantidad FROM inventario_corales i JOIN catalogo_corales c ON i.coral_id = c.id WHERE i.usuario_id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    
    $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $corales = [];
    
    // Leemos la cantidad para que se dibujen tantos como hayas comprado
    foreach ($resultados as $fila) {
        for ($i = 0; $i < $fila['cantidad']; $i++) {
            $corales[] = ['tipo' => $fila['tipo']];
        }
    }
    
    echo json_encode($corales);
} catch(PDOException $e) {
    echo json_encode([]);
}
?>