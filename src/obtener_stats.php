<?php
session_start();

// Verificar si el usuario está logueado y tiene usuario_id
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

// Conectar a la base de datos
try {
    $pdo = new PDO('mysql:host=db;dbname=pecera_digital;charset=utf8mb4', 'root', 'root_password');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Error de conexión a la base de datos']);
    exit;
}

// Preparar y ejecutar la consulta
$stmt = $pdo->prepare('SELECT dinero, nivel, xp_actual, xp_max FROM usuarios WHERE id = ?');
$stmt->execute([$_SESSION['usuario_id']]);
$stats = $stmt->fetch(PDO::FETCH_ASSOC);

if ($stats) {
    echo json_encode($stats);
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Usuario no encontrado']);
}
?>