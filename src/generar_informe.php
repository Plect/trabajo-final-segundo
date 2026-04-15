<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: webs/inicioSesion.php");
    exit;
}

try {
    $pdo = new PDO('mysql:host=db;dbname=pecera_digital;charset=utf8mb4', 'root', 'root_password');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}

// Obtener datos del usuario
$stmt = $pdo->prepare("SELECT username, nivel, dinero, xp_actual, xp_max FROM usuarios WHERE id = ?");
$stmt->execute([$_SESSION['usuario_id']]);
$usuario = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$usuario) {
    die("Usuario no encontrado.");
}

// Contar objetos en inventario
$totalPeces = $pdo->query("SELECT COUNT(*) FROM inventario WHERE usuario_id = {$_SESSION['usuario_id']}")->fetchColumn();
$totalDecoraciones = $pdo->query("SELECT COUNT(*) FROM inventario_decoraciones WHERE usuario_id = {$_SESSION['usuario_id']}")->fetchColumn();
$totalCorales = $pdo->query("SELECT COUNT(*) FROM inventario_corales WHERE usuario_id = {$_SESSION['usuario_id']}")->fetchColumn();

// Configurar cabeceras para descarga
header('Content-Type: text/plain; charset=utf-8');
header('Content-Disposition: attachment; filename="Informe_Pecera_' . date('Y-m-d') . '.txt"');

// Generar contenido del informe
$informe = "=== INFORME DE LA PECERA ===\n\n";
$informe .= "Fecha de generación: " . date('d/m/Y H:i:s') . "\n\n";
$informe .= "Nombre del jugador: " . $usuario['username'] . "\n\n";
$informe .= "Estadísticas:\n";
$informe .= "- Nivel: " . $usuario['nivel'] . "\n";
$informe .= "- Dinero: " . $usuario['dinero'] . " monedas\n";
$informe .= "- XP: " . $usuario['xp_actual'] . " / " . $usuario['xp_max'] . "\n\n";
$informe .= "Inventario:\n";
$informe .= "- Total de peces: " . $totalPeces . "\n";
$informe .= "- Total de decoraciones: " . $totalDecoraciones . "\n";
$informe .= "- Total de corales: " . $totalCorales . "\n";

echo $informe;
?>