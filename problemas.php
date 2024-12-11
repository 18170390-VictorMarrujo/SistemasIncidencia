<?php
// Incluir el archivo de conexión
include 'config.php';

// Obtener las incidencias resueltas con la calificación de evaluación
$sql = "SELECT 
            i.titulo AS titulo_incidencia,
            i.descripcion AS descripcion_resolucion,
            u.nombre AS tecnico_resolvio,
            e.calificacion AS calificacion_evaluacion
        FROM 
            incidencias i
        LEFT JOIN 
            usuarios u ON i.id_tecnico = u.id_usuario
        LEFT JOIN 
            evaluaciones e ON i.id_incidencia = e.id_incidencia
        WHERE 
            i.estado = 'cerrada'";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Incidencias Resueltas</title>
    <a href="equipos_mas_incidencias.php">Ver Equipos con Más Incidencias</a>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f4f4f4;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Incidencias Resueltas</h1>
    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Resolución</th>
                <th>Resuelto por</th>
                <th>Calificación</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['titulo_incidencia']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['descripcion_resolucion']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tecnico_resolvio'] ?? 'No asignado') . "</td>";
                    echo "<td>" . htmlspecialchars($row['calificacion_evaluacion'] ?? 'Sin evaluar') . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No hay incidencias resueltas.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="admin_dashboard.php">Regresar</a>
</body>
</html>
