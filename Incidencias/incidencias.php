<?php
// Incluir archivo de configuración
include 'config.php';

// Obtener incidencias desde la base de datos
$sql = "
    SELECT 
        i.id_incidencia, 
        i.titulo, 
        i.descripcion, 
        i.prioridad, 
        i.estado, 
        i.fecha_creacion,
        u.nombre AS reportado_por,
        e.descripcion AS equipo,
        t.nombre AS tecnico_asignado
    FROM incidencias i
    INNER JOIN usuarios u ON i.id_usuario = u.id_usuario
    INNER JOIN equipos e ON i.id_equipo = e.id_equipo
    LEFT JOIN usuarios t ON i.id_tecnico = t.id_usuario
    ORDER BY i.fecha_creacion DESC
";

$result = $conn->query($sql);
$incidencias = $result->num_rows > 0 ? $result->fetch_all(MYSQLI_ASSOC) : [];

// Obtener técnicos para asignar
$sql_tecnicos = "SELECT id_usuario, nombre FROM usuarios WHERE tipo_usuario = 'tecnico'";
$result_tecnicos = $conn->query($sql_tecnicos);
$tecnicos = $result_tecnicos->num_rows > 0 ? $result_tecnicos->fetch_all(MYSQLI_ASSOC) : [];

// Asignar incidencia a un técnico
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id_incidencia']) && isset($_POST['id_tecnico'])) {
    $id_incidencia = intval($_POST['id_incidencia']);
    $id_tecnico = intval($_POST['id_tecnico']);

    $sql_asignar = "UPDATE incidencias SET id_tecnico = $id_tecnico, estado = 'en_progreso' WHERE id_incidencia = $id_incidencia";
    if ($conn->query($sql_asignar)) {
        $message = "Incidencia asignada correctamente.";
    } else {
        $message = "Error al asignar incidencia: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Incidencias</title>
    <link rel="stylesheet" href="css/fondo.css">
</head>
<body>
<div class="container mt-4">
    <h1 class="text-center">Gestión de Incidencias</h1>
    <a href="admin_dashboard.php" class="btn btn-secondary mb-3">Regresar al Dashboard</a>

    <?php if (!empty($message)): ?>
        <div class="alert alert-info"><?= $message ?></div>
    <?php endif; ?>

    <table class="table table-striped mt-4">
        <thead>
            <tr>
                <th>#</th>
                <th>Título</th>
                <th>Descripción</th>
                <th>Prioridad</th>
                <th>Estado</th>
                <th>Reportado por</th>
                <th>Equipo</th>
                <th>Técnico Asignado</th>
                <th>Asignar Técnico</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($incidencias as $incidencia): ?>
                <tr>
                    <td><?= $incidencia['id_incidencia'] ?></td>
                    <td><?= htmlspecialchars($incidencia['titulo']) ?></td>
                    <td><?= htmlspecialchars($incidencia['descripcion']) ?></td>
                    <td><?= ucfirst($incidencia['prioridad']) ?></td>
                    <td><?= ucfirst($incidencia['estado']) ?></td>
                    <td><?= htmlspecialchars($incidencia['reportado_por']) ?></td>
                    <td><?= htmlspecialchars($incidencia['equipo']) ?></td>
                    <td>
                        <?= $incidencia['tecnico_asignado'] ? htmlspecialchars($incidencia['tecnico_asignado']) : '<em>No asignado</em>' ?>
                    </td>
                    <td>
                        <?php if (!$incidencia['tecnico_asignado']): ?>
                            <form method="POST" class="d-flex">
                                <input type="hidden" name="id_incidencia" value="<?= $incidencia['id_incidencia'] ?>">
                                <select name="id_tecnico" class="form-select me-2" required>
                                    <option value="" disabled selected>Seleccionar Técnico</option>
                                    <?php foreach ($tecnicos as $tecnico): ?>
                                        <option value="<?= $tecnico['id_usuario'] ?>"><?= htmlspecialchars($tecnico['nombre']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="submit" class="btn btn-primary">Asignar</button>
                            </form>
                        <?php else: ?>
                            <span class="text-muted">Asignado</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
