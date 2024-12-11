<?php
session_start(); // Asegúrate de que la sesión esté iniciada

// Verificar si el usuario está logueado y es administrador
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'administrador') {
    header('Location: login.php');
    exit();
}

// Obtener el nombre del usuario desde la sesión
$user_name = $_SESSION['user_name'] ?? 'Usuario Administrador';  // Valor por defecto si no está presente

// Conexión a la base de datos y obtener las incidencias (adaptado a tu estructura)
require_once "config.php"; 

try {
    // Consulta para obtener las incidencias por estado
    $stmt = $conn->prepare("
        SELECT 
            estado, 
            COUNT(*) AS total 
        FROM incidencias 
        GROUP BY estado
    ");
    $stmt->execute();
    $incidencias = $stmt;  // Asegurarse de que sea un arreglo asociativo
} catch (PDOException $e) {
    die("Error al consultar datos: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Administrador</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Dashboard - Administrador</h1>
            <div class="user-actions">
            <span>Bienvenido, <strong><?php echo htmlspecialchars($user_name); ?></strong></span>
                <button id="logout-btn" onclick="window.location.href='logout.php'">Cerrar Sesión</button>
            </div>
        </div>
    </header>

    <div class="main-container">
        <aside>
            <nav>
                <ul>
                    <li><a href="listar_usuarios.php">Gestión de Usuarios</a></li>
                    <li><a href="listar_equipos.php">Gestión de Equipos</a></li>
                    <li><a href="incidencias.php">Gestión de Incidencias</a></li>
                    <li><a href="problemas.php">Reportes Problemas</a></li>
                    <li><a href="componentes.php">Gestión de Componentes</a></li>
                </ul>
            </nav>
        </aside>

        <main>
            <section>
                <h2>Incidencias Activas</h2>
                <?php if (!empty($incidencias)): ?>
                    <ul>
                        <?php foreach ($incidencias as $incidencia): ?>
                            <li><?= ucfirst(htmlspecialchars($incidencia['estado'])) ?>: <?= htmlspecialchars($incidencia['total']) ?></li>
                        <?php endforeach; ?>
                    </ul>
                <?php else: ?>
                    <p>No hay incidencias activas en este momento.</p>
                <?php endif; ?>
                <p><small>Última actualización: <?= date("d/m/Y H:i") ?></small></p>
            </section>
        </main>
    </div>
</body>
</html>
