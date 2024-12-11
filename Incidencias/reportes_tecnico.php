<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_tecnico = $_POST['id_tecnico'];

    // Incidencias asignadas al técnico seleccionado
    $incidencias_tecnico = $conn->query("SELECT incidencias.descripcion, incidencias.estado
                                       FROM incidencias
                                       WHERE incidencias.id_tecnico = ?", array($id_tecnico));
}

$tecnicos = $conn->query("SELECT id_usuario, nombre FROM usuarios WHERE rol = 'Técnico'");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes por Técnico</title>
</head>
<body>
    <h1>Reportes por Técnico</h1>

    <form method="POST">
        <label>Seleccione Técnico</label>
        <select name="id_tecnico" required>
            <option value="">Seleccione un técnico</option>
            <?php while ($row = $tecnicos->fetch_assoc()): ?>
                <option value="<?= $row['id_usuario'] ?>"><?= $row['nombre'] ?></option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Generar Reporte</button>
    </form>

    <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
        <h2>Incidencias Asignadas</h2>
        <table>
            <tr>
                <th>Descripción</th>
                <th>Estado</th>
            </tr>
            <?php while ($row = $incidencias_tecnico->fetch_assoc()): ?>
                <tr>
                    <td><?= $row['descripcion'] ?></td>
                    <td><?= $row['estado'] ?></td>
                </tr>
            <?php endwhile; ?>
        </table>
    <?php endif; ?>
</body>
</html>
