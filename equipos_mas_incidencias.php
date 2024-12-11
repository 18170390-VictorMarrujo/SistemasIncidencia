<?php
// Incluir el archivo de conexión
include 'config.php';

// Obtener los equipos con todas las incidencias (sin filtrar por 'cerrada')
$sql = "SELECT 
            e.id_equipo, 
            e.tipo, 
            e.descripcion, 
            e.modelo, 
            COUNT(i.id_incidencia) AS num_incidencias
        FROM 
            equipos e
        LEFT JOIN 
            incidencias i ON e.id_equipo = i.id_equipo
        GROUP BY 
            e.id_equipo
        ORDER BY 
            num_incidencias DESC";

$result = $conn->query($sql);

// Si se realiza una asignación de técnico
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['asignar_tecnico'])) {
    $id_equipo = $_POST['id_equipo'];
    $id_tecnico = $_POST['id_tecnico'];

    // Verificar si el equipo ya tiene un técnico asignado
    $checkSQL = "SELECT id_tecnico FROM equipos_muchas_incidencias WHERE id_equipo = $id_equipo";
    $checkResult = $conn->query($checkSQL);
    
    if ($checkResult->num_rows == 0) {
        // Asignar el técnico a la tabla equipos_muchas_incidencias
        $assignSQL = "INSERT INTO equipos_muchas_incidencias (id_equipo, num_incidencias, id_tecnico) 
                    VALUES ($id_equipo, 
                            (SELECT COUNT(id_incidencia) FROM incidencias WHERE id_equipo = $id_equipo),
                            $id_tecnico)";
        if ($conn->query($assignSQL)) {
            $message = "Técnico asignado correctamente.";
            $alertClass = "alert-success";
        } else {
            $message = "Error al asignar el técnico.";
            $alertClass = "alert-danger";
        }
    } else {
        $message = "Este equipo ya tiene un técnico asignado.";
        $alertClass = "alert-danger";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipos con Más Incidencias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        .container {
            max-width: 900px;
            margin-top: 20px;
        }

        .table th, .table td {
            text-align: center;
        }

        .table td {
            vertical-align: middle;
        }

        .btn-disabled {
            cursor: not-allowed;
            opacity: 0.6;
        }

        .alert {
            font-size: 16px;
            font-weight: bold;
        }

        .alert-success {
            background-color: #28a745;
            color: white;
        }

        .alert-danger {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Equipos con Más Incidencias</h1>

        <!-- Mostrar mensaje de éxito o error -->
        <?php if (isset($message)): ?>
            <div class="alert <?php echo $alertClass; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="table-container">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tipo</th>
                        <th>Descripción</th>
                        <th>Modelo</th>
                        <th>Número de Incidencias</th>
                        <th>Asignar Técnico</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            // Verificar si el equipo ya tiene un técnico asignado
                            $id_equipo = $row['id_equipo'];
                            $checkSQL = "SELECT id_tecnico FROM equipos_muchas_incidencias WHERE id_equipo = $id_equipo";
                            $checkResult = $conn->query($checkSQL);
                            $hasTechnician = $checkResult->num_rows > 0;
                    ?>
                            <tr>
                                <td><?php echo $row['id_equipo']; ?></td>
                                <td><?php echo $row['tipo']; ?></td>
                                <td><?php echo $row['descripcion']; ?></td>
                                <td><?php echo $row['modelo']; ?></td>
                                <td><?php echo $row['num_incidencias']; ?></td>
                                <td>
                                    <?php if ($hasTechnician): ?>
                                        <button class="btn btn-secondary btn-disabled" disabled>Ya Asignado</button>
                                    <?php else: ?>
                                        <form method="POST" action="">
                                            <input type="hidden" name="id_equipo" value="<?php echo $row['id_equipo']; ?>">
                                            <select name="id_tecnico" class="form-select" required>
                                                <option value="">Seleccionar Técnico</option>
                                                <?php
                                                // Obtener la lista de técnicos disponibles
                                                $tecnicosSQL = "SELECT id_usuario, nombre FROM usuarios WHERE tipo_usuario = 'tecnico'";
                                                $tecnicosResult = $conn->query($tecnicosSQL);
                                                while ($tecnico = $tecnicosResult->fetch_assoc()) {
                                                    echo "<option value='" . $tecnico['id_usuario'] . "'>" . $tecnico['nombre'] . "</option>";
                                                }
                                                ?>
                                            </select>
                                            <button type="submit" name="asignar_tecnico" class="btn btn-primary mt-2">Asignar Técnico</button>
                                        </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No hay equipos con incidencias.</td></tr>";
                    }
                    ?>
                    <a href="problemas.php">Regresar</a>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
