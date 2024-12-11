<?php
// Incluir el archivo de conexión
include 'config.php';

// Obtener las incidencias asignadas al técnico y abiertas
$sql_incidencias = "SELECT id_incidencia, titulo FROM incidencias WHERE estado = 'en_progreso'";
$result_incidencias = $conn->query($sql_incidencias);

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
    <title>Registrar Cotización</title>
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
</body>
</html>
