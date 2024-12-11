<?php
// Incluir el archivo de conexión
include 'config.php';

// Obtener todas las cotizaciones
$sql = "SELECT 
            c.id_cotizacion,
            c.descripcion,
            c.costo,
            c.estado,
            i.titulo AS titulo_incidencia,
            u.nombre AS tecnico_responsable
        FROM 
            cotizaciones c
        LEFT JOIN 
            incidencias i ON c.id_incidencia = i.id_incidencia
        LEFT JOIN 
            usuarios u ON i.id_tecnico = u.id_usuario";

$result = $conn->query($sql);

// Procesar la aprobación o rechazo
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_cotizacion = $_POST['id_cotizacion'];
    $accion = $_POST['accion'];

    if ($accion === 'aprobar') {
        $nuevo_estado = 'aprobada';
    } elseif ($accion === 'rechazar') {
        $nuevo_estado = 'rechazada';
    }

    // Actualizar el estado de la cotización
    $update_sql = "UPDATE cotizaciones SET estado = ? WHERE id_cotizacion = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param('si', $nuevo_estado, $id_cotizacion);

    if ($stmt->execute()) {
        echo "<p>Cotización actualizada correctamente.</p>";
    } else {
        echo "<p>Error al actualizar la cotización: " . $conn->error . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aprobar Pedidos de Material</title>
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
        .actions {
            display: flex;
            gap: 10px;
        }
        .actions button {
            padding: 5px 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .actions .approve {
            background-color: #28a745;
            color: white;
        }
        .actions .reject {
            background-color: #dc3545;
            color: white;
        }
        .estado {
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .estado.aprobada {
            background-color: #d4edda;
            color: #155724;
        }
        .estado.rechazada {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <h1>Aprobar Pedidos de Material</h1>
    <table>
        <thead>
            <tr>
                <th>Título de la Incidencia</th>
                <th>Descripción del Pedido</th>
                <th>Costo</th>
                <th>Técnico Responsable</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['titulo_incidencia']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['descripcion']) . "</td>";
                    echo "<td>$" . htmlspecialchars($row['costo']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tecnico_responsable'] ?? 'No asignado') . "</td>";

                    // Mostrar estado con color
                    $estado = htmlspecialchars($row['estado']);
                    $estado_clase = $estado === 'aprobada' ? 'aprobada' : ($estado === 'rechazada' ? 'rechazada' : '');
                    echo "<td class='estado $estado_clase'>" . ucfirst($estado) . "</td>";

                    // Mostrar botones solo si está pendiente
                    if ($estado === 'pendiente') {
                        echo "<td>
                                <form method='POST' style='display:inline;'>
                                    <input type='hidden' name='id_cotizacion' value='" . $row['id_cotizacion'] . "'>
                                    <div class='actions'>
                                        <button type='submit' name='accion' value='aprobar' class='approve'>Aprobar</button>
                                        <button type='submit' name='accion' value='rechazar' class='reject'>Rechazar</button>
                                    </div>
                                </form>
                              </td>";
                    } else {
                        echo "<td>No disponible</td>";
                    }

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>No hay pedidos disponibles.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <a href="jefe_dashboard.php">Regresar</a>
</body>
</html>
