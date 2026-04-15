<?php
session_start();

// Comprobar que el usuario está autenticado
if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['error' => 'Usuario no autenticado']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

try {
    // Conexión a la base de datos
    $dsn = 'mysql:host=db;dbname=pecera_digital;charset=utf8mb4';
    $pdo = new PDO($dsn, 'root', 'root_password');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ejecutar las 3 consultas DELETE preparadas
    $stmt1 = $pdo->prepare('DELETE FROM inventario WHERE usuario_id = ?');
    $stmt1->execute([$usuario_id]);

    $stmt2 = $pdo->prepare('DELETE FROM inventario_decoraciones WHERE usuario_id = ?');
    $stmt2->execute([$usuario_id]);

    $stmt3 = $pdo->prepare('DELETE FROM inventario_corales WHERE usuario_id = ?');
    $stmt3->execute([$usuario_id]);

    // Devolver éxito
    echo 'Exito';

} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
    exit;
} catch (Exception $e) {
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
    exit;
}
?>
