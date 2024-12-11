<?php
// Incluir el archivo de conexión
include 'config.php';

// Establecer el ID del técnico
$id_tecnico = 2; // El ID del técnico es 2

// Obtener los equipos asignados al técnico
$sql = "SELECT 
            em.id_equipo, 
            e.tipo, 
            e.descripcion, 
            e.modelo, 
            em.num_incidencias, 
            em.comentario
        FROM 
            equipos_muchas_incidencias em
        JOIN 
            equipos e ON em.id_equipo = e.id_equipo
        WHERE 
            em.id_tecnico = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_tecnico);  // Asegúrate de que el id_tecnico es un valor entero
$stmt->execute();

$result = $stmt->get_result();

// Si se envió el formulario de comentario
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comentario'])) {
    $id_equipo = $_POST['id_equipo'];
    $comentario = $_POST['comentario'];

    // Actualizar el comentario en la base de datos
    $updateSQL = "UPDATE equipos_muchas_incidencias SET comentario = ? WHERE id_equipo = ? AND id_tecnico = ?";
    $updateStmt = $conn->prepare($updateSQL);
    $updateStmt->bind_param("sii", $comentario, $id_equipo, $id_tecnico);

    if ($updateStmt->execute()) {
        $message = "Comentario actualizado correctamente.";
        $alertClass = "alert-success";
    } else {
        $message = "Error al actualizar el comentario.";
        $alertClass = "alert-danger";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Equipos Asignados</title>
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
        <h1>Equipos Asignados al Técnico</h1>
        <a href="tecnico_dashboard.php">Regresar</a>

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
                        <th>Comentario</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                    ?>
                            <tr>
                                <td><?php echo $row['id_equipo']; ?></td>
                                <td><?php echo $row['tipo']; ?></td>
                                <td><?php echo $row['descripcion']; ?></td>
                                <td><?php echo $row['modelo']; ?></td>
                                <td><?php echo $row['num_incidencias']; ?></td>
                                <td>
                                    <form method="POST" action="">
                                        <input type="hidden" name="id_equipo" value="<?php echo $row['id_equipo']; ?>">
                                        <textarea name="comentario" class="form-control" rows="3" placeholder="Deje un comentario sobre el equipo..."><?php echo htmlspecialchars($row['comentario']); ?></textarea>
                                        <button type="submit" class="btn btn-primary mt-2">Actualizar Comentario</button>
                                    </form>
                                </td>
                            </tr>
                    <?php
                        }
                    } else {
                        echo "<tr><td colspan='6' class='text-center'>No hay equipos asignados.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
