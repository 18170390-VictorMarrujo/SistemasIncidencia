<?php
include 'config.php';

// Consultas para los reportes generales
$incidencias_estado = $conn->query("SELECT estado, COUNT(*) AS total FROM incidencias GROUP BY estado");
$incidencias_tecnico = $conn->query("SELECT id_tecnico, COUNT(*) AS total FROM incidencias GROUP BY id_tecnico");
$evaluaciones_promedio = $conn->query("SELECT id_tecnico, AVG(calificacion) AS promedio FROM incidencias WHERE calificacion IS NOT NULL GROUP BY id_tecnico");

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes Generales</title>
</head>
<body>
    <h1>Reportes Generales</h1>

    <h2>Incidencias por Estado</h2>
    <table>
        <tr>
            <th>Estado</th>
            <th>Total</th>
        </tr>
        <?php while ($row = $incidencias_estado->fetch_assoc()): ?>
            <tr>
                <td><?= $row['estado'] ?></td>
                <td><?= $row['total'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Incidencias por Técnico</h2>
    <table>
        <tr>
            <th>Técnico</th>
            <th>Total Incidencias</th>
        </tr>
        <?php while ($row = $incidencias_tecnico->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id_tecnico'] ?></td>
                <td><?= $row['total'] ?></td>
            </tr>
        <?php endwhile; ?>
    </table>

    <h2>Evaluaciones Promedio por Técnico</h2>
    <table>
        <tr>
            <th>Técnico</th>
            <th>Promedio Calificación</th>
        </tr>
        <?php while ($row = $evaluaciones_promedio->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id_tecnico'] ?></td>
                <td><?= number_format($row['promedio'], 2) ?></td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
