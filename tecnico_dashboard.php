<?php
session_start();

// Verificar si el usuario está logueado y es técnico
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'tecnico') {
    header('Location: login.php');
    exit();
}

// Obtener el nombre del usuario desde la sesión
$user_name = $_SESSION['user_name'] ?? 'Técnico';

require_once "config.php"; // Conexión a la base de datos
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Técnico</title>
    <link rel="stylesheet" href="css/dashboard.css">
</head>
<body>
    <header>
        <div class="header-content">
            <h1>Dashboard - Técnico</h1>
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
                    <li><a href="tecnico_incidencia.php">Incidencias Asignadas</a></li>
                    <li><a href="cotizar.php">Cotizaciones</a></li>
                    <li><a href="lista_problemas.php">Equipos Problemas</a></li>
                </ul>
            </nav>
        </aside>

        <main>
        </main>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
