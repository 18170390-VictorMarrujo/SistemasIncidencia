<?php
include 'config.php';

// ID del técnico fijo
$id_tecnico = 2;

// Mostrar las incidencias asignadas al técnico
$incidencias = $conn->query("SELECT * FROM incidencias WHERE id_tecnico = $id_tecnico AND estado != 'cerrada'");

// Obtener los servicios disponibles
$servicios = $conn->query("SELECT * FROM servicios");

// Actualizar el estado y avances de la incidencia
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capturar los datos enviados
    $id_incidencia = $_POST['id_incidencia'];
    $estado = $_POST['estado'];
    $avance = $_POST['avance'];

    // Verificar si los valores están presentes
    if (empty($estado) || empty($avance)) {
        $mensaje = "Por favor, complete el estado y los avances.";
    } else {
        // Actualizar el estado y los avances en la base de datos
        $query = "UPDATE incidencias SET estado = ?, descripcion = CONCAT(descripcion, '\n\nAvance: ', ?) WHERE id_incidencia = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ssi', $estado, $avance, $id_incidencia);

        if ($stmt->execute()) {
            $mensaje = "Estado de la incidencia actualizado correctamente.";
        } else {
            $mensaje = "Error al actualizar la incidencia: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar Incidencias</title>
    <link rel="stylesheet" href="css/estilo.css">
    <script>
        function mostrarServicios() {
            var modal = document.getElementById('modalServicios');
            modal.style.display = 'block';
        }

        function cerrarModal() {
            var modal = document.getElementById('modalServicios');
            modal.style.display = 'none';
        }
    </script>
</head>
<body>
    <h2>Incidencias Asignadas</h2>
    <a href="tecnico_dashboard.php">Regresar</a>

    <?php if ($incidencias->num_rows > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descripción</th>
                    <th>Prioridad</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($incidencia = $incidencias->fetch_assoc()): ?>
                    <tr>
                        <td><?= $incidencia['titulo'] ?></td>
                        <td><?= nl2br($incidencia['descripcion']) ?></td>
                        <td><?= $incidencia['prioridad'] ?></td>
                        <td><?= $incidencia['estado'] ?></td>
                        <td>
                            <!-- Formulario para actualizar estado y avances -->
                            <form method="POST">
                                <input type="hidden" name="id_incidencia" value="<?= $incidencia['id_incidencia'] ?>">

                                <label for="estado">Estado:</label>
                                <select name="estado" required>
                                    <option value="abierta" <?= $incidencia['estado'] == 'abierta' ? 'selected' : '' ?>>Abierta</option>
                                    <option value="en_progreso" <?= $incidencia['estado'] == 'en_progreso' ? 'selected' : '' ?>>En Progreso</option>
                                    <option value="en_taller" <?= $incidencia['estado'] == 'en_taller' ? 'selected' : '' ?>>En Taller</option>
                                    <option value="cerrada" <?= $incidencia['estado'] == 'cerrada' ? 'selected' : '' ?>>Cerrada</option>
                                </select><br>

                                <label for="avance">Avance:</label><br>
                                <textarea name="avance" rows="3" placeholder="Describa el avance de la incidencia."></textarea><br>

                                <button type="submit">Actualizar</button>
                            </form>
                            <button onclick="mostrarServicios()">Ver Servicios</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No tienes incidencias asignadas.</p>
    <?php endif; ?>

    <?php if (isset($mensaje)): ?>
        <p><?= $mensaje ?></p>
    <?php endif; ?>

    <!-- Modal para mostrar los servicios -->
    <div id="modalServicios" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background-color: rgba(0, 0, 0, 0.5);">
        <div style="background-color:white; margin: 50px auto; padding: 20px; width: 80%; max-width: 600px;">
            <h3>Servicios Disponibles</h3>
            <button onclick="cerrarModal()">Cerrar</button>
            <ul>
                <?php if ($servicios->num_rows > 0): ?>
                    <?php while ($servicio = $servicios->fetch_assoc()): ?>
                        <li>
                            <strong><?= $servicio['nombre_servicio'] ?></strong><br>
                            <?= $servicio['descripcion'] ?><br>
                            Tipo: <?= $servicio['tipo_equipo'] ?><br>
                            Complejidad: <?= $servicio['complejidad'] ?><br>
                            Tiempo Estimado: <?= $servicio['tiempo_estimado'] ?> minutos<br>
                            Costo Estimado: $<?= $servicio['costo_estimado'] ?><br>
                        </li>
                        <hr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <p>No hay servicios disponibles.</p>
                <?php endif; ?>
            </ul>
        </div>
    </div>

</body>
</html>
