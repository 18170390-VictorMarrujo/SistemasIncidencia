    <?php
    session_start();

    // Verificar si el usuario está logueado y es jefe de departamento
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'jefe_departamento') {
        header('Location: login.php');
        exit();
    }

    $user_name = $_SESSION['user_name'] ?? 'Jefe Departamento';  // Valor por defecto si no está presente

    // Obtener el ID del departamento desde la sesión
    $departamento_id = $_SESSION['departamento_id'] ?? null;

    if (!$departamento_id) {
        die("No se ha asignado un departamento para este usuario.");
    }

    require_once "config.php"; // Conexión a la base de datos

    try {
        // Consulta para obtener las incidencias agrupadas por estado
        $query = "
        SELECT i.estado, COUNT(*) AS total
        FROM incidencias i
        JOIN equipos e ON i.id_equipo = e.id_equipo
        JOIN aulas a ON e.id_aula = a.id_aula
        JOIN edificios ed ON a.id_edificio = ed.id_edificio
        WHERE ed.id_departamento = ?
        GROUP BY i.estado;

        ";

        // Preparar y ejecutar la consulta
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $departamento_id); // Sustituye el marcador con el valor
        $stmt->execute();
        $result = $stmt->get_result();

        // Obtener los datos en un arreglo asociativo
        $incidencias = [];
        while ($row = $result->fetch_assoc()) {
            $incidencias[] = $row;
        }

        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        die("Error al consultar datos: " . $e->getMessage());
    }
    ?>  

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard - Jefe de Departamento</title>
        <link rel="stylesheet" href="css/dashboard.css">
    </head>
    <body>
        <header>
            <div class="header-content">
                <h1>Dashboard - Jefe de Departamento</h1>
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
                        <li><a href="reportar_incidencia.php">Incidencias</a></li>
                        <li><a href="aprovacion.php">Aprobaciones</a></li>
                        <li><a href="evaluar_incidencia.php">Evaluaciones</a></li>
                        <li><a href="#">Gestión de Recursos</a></li>
                    </ul>
                </nav>
            </aside>

            <main>
                <section>
                    <h2>Incidencias Asignadas</h2>
                    <?php if (!empty($incidencias)): ?>
                        <ul>
                            <?php foreach ($incidencias as $incidencia): ?>
                                <li><?= ucfirst(htmlspecialchars($incidencia['estado'])) ?>: <?= htmlspecialchars($incidencia['total']) ?></li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else: ?>
                        <p>No hay incidencias asignadas en este momento.</p>
                    <?php endif; ?>
                    <p><small>Última actualización: <?= date("d/m/Y H:i") ?></small></p>
                </section>
            </main>
        </div>
    </body>
    </html>
