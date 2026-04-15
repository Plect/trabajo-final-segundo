<?php
session_start();

// Verificar si el usuario está logueado y tiene usuario_id
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || !isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'No autorizado']);
    exit;
}

// Verificar que se recibieron los datos por POST
if (!isset($_POST['dinero']) || !isset($_POST['nivel']) || !isset($_POST['xp_actual']) || !isset($_POST['xp_max'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos incompletos']);
    exit;
}

// Validar tipos de datos (opcional, pero recomendado)
$dinero = filter_var($_POST['dinero'], FILTER_VALIDATE_INT);
$nivel = filter_var($_POST['nivel'], FILTER_VALIDATE_INT);
$xp_actual = filter_var($_POST['xp_actual'], FILTER_VALIDATE_INT);
$xp_max = filter_var($_POST['xp_max'], FILTER_VALIDATE_INT);

if ($dinero === false || $nivel === false || $xp_actual === false || $xp_max === false) {
    http_response_code(400);
    echo json_encode(['error' => 'Datos inválidos']);
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

// Preparar y ejecutar la actualización
$stmt = $pdo->prepare('UPDATE usuarios SET dinero = ?, nivel = ?, xp_actual = ?, xp_max = ? WHERE id = ?');
$result = $stmt->execute([$dinero, $nivel, $xp_actual, $xp_max, $_SESSION['usuario_id']]);

if ($result) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['error' => 'Error al guardar los datos']);
}
?>