<?php
// Incluir el archivo de conexión
include 'config.php';

// Obtener las incidencias asignadas al técnico y abiertas
$sql_incidencias = "SELECT id_incidencia, titulo FROM incidencias WHERE estado = 'en_progreso'";
$result_incidencias = $conn->query($sql_incidencias);

// Obtener las cotizaciones registradas
$sql_cotizaciones = "SELECT c.id_cotizacion, c.descripcion, c.costo, c.estado, i.titulo AS incidencia 
                     FROM cotizaciones c
                     JOIN incidencias i ON c.id_incidencia = i.id_incidencia";
$result_cotizaciones = $conn->query($sql_cotizaciones);

// Procesar el formulario de cotización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_incidencia = $_POST['id_incidencia'];
    $descripcion = $_POST['descripcion'];
    $costo = $_POST['costo'];

    // Validar entrada
    if (!empty($id_incidencia) && !empty($descripcion) && !empty($costo) && is_numeric($costo)) {
        $sql_cotizacion = "INSERT INTO cotizaciones (id_incidencia, descripcion, costo, estado) 
                           VALUES (?, ?, ?, 'pendiente')";
        $stmt = $conn->prepare($sql_cotizacion);
        $stmt->bind_param('isd', $id_incidencia, $descripcion, $costo);

        if ($stmt->execute()) {
            echo "<p style='color:green;'>Cotización registrada con éxito.</p>";
        } else {
            echo "<p style='color:red;'>Error al registrar la cotización: " . $conn->error . "</p>";
        }
    } else {
        echo "<p style='color:red;'>Por favor, complete todos los campos correctamente.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar y Ver Cotizaciones</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        form div {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        button {
            background-color: #007bff;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .cotizaciones-table {
            margin-top: 30px;
            width: 100%;
            border-collapse: collapse;
        }
        .cotizaciones-table th, .cotizaciones-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
        }
        .cotizaciones-table th {
            background-color: #f2f2f2;
        }
        .estado-aprobada {
            color: green;
        }
        .estado-rechazada {
            color: red;
        }
        .estado-pendiente {
            color: orange;
        }
    </style>
</head>
<body>
    <h1>Registrar Cotización</h1>
    <form method="POST">
        <div>
            <label for="id_incidencia">Seleccionar Incidencia</label>
            <select name="id_incidencia" id="id_incidencia" required>
                <option value="">-- Seleccione una incidencia --</option>
                <?php
                if ($result_incidencias->num_rows > 0) {
                    while ($row = $result_incidencias->fetch_assoc()) {
                        echo "<option value='" . $row['id_incidencia'] . "'>" . htmlspecialchars($row['titulo']) . "</option>";
                    }
                } else {
                    echo "<option value=''>No hay incidencias abiertas</option>";
                }
                ?>
            </select>
        </div>
        <div>
            <label for="descripcion">Descripción del Material Requerido</label>
            <textarea name="descripcion" id="descripcion" rows="4" required></textarea>
        </div>
        <div>
            <label for="costo">Costo Estimado</label>
            <input type="text" name="costo" id="costo" required>
        </div>
        <div>
            <button type="submit">Registrar Cotización</button>
            <a href="tecnico_dashboard.php">Regresar</a>
        </div>
    </form>

    <!-- Mostrar las cotizaciones registradas -->
    <h2>Cotizaciones Registradas</h2>
    <table class="cotizaciones-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Incidencia</th>
                <th>Descripción</th>
                <th>Costo Estimado</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result_cotizaciones->num_rows > 0) {
                while ($row = $result_cotizaciones->fetch_assoc()) {
                    // Establecer la clase del estado según el valor en la base de datos
                    $estado_class = 'estado-pendiente';
                    if ($row['estado'] == 'aprobada') {
                        $estado_class = 'estado-aprobada';
                    } elseif ($row['estado'] == 'rechazada') {
                        $estado_class = 'estado-rechazada';
                    }
                    echo "<tr>";
                    echo "<td>" . $row['id_cotizacion'] . "</td>";
                    echo "<td>" . htmlspecialchars($row['incidencia']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['descripcion']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['costo']) . "</td>";
                    echo "<td class='" . $estado_class . "'>" . ucfirst($row['estado']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='text-center'>No hay cotizaciones registradas.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
