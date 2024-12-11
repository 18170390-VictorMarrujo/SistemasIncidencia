<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo']; // Obtener el título de la incidencia
    $id_equipo = $_POST['id_equipo'];
    $descripcion = $_POST['descripcion'];
    $prioridad = $_POST['prioridad'];

    // Inserción en la tabla de incidencias, incluyendo el título
    $query = "INSERT INTO incidencias (id_usuario, id_equipo, descripcion, prioridad, titulo)
              VALUES (3, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('isss', $id_equipo, $descripcion, $prioridad, $titulo); // Agregar el parámetro para el título

    if ($stmt->execute()) {
        $mensaje = "Incidencia reportada con éxito.";
    } else {
        $mensaje = "Error al reportar la incidencia.";
    }
}

$equipos = $conn->query("SELECT id_equipo, modelo FROM equipos");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportar Incidencia</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <form method="POST">
        <label>Título de la Incidencia</label>
        <input type="text" name="titulo" required> <!-- Campo para el título -->

        <label>Equipo Afectado</label>
        <select name="id_equipo" required>
            <option value="">Seleccione un equipo</option>
            <?php while ($equipo = $equipos->fetch_assoc()): ?>
                <option value="<?= $equipo['id_equipo'] ?>"><?= $equipo['modelo'] ?></option>
            <?php endwhile; ?>
        </select>

        <label>Descripción del Problema</label>
        <textarea name="descripcion" required></textarea>

        <label>Prioridad</label>
        <select name="prioridad" required>
            <option value="Baja">Baja</option>
            <option value="Media">Media</option>
            <option value="Alta">Alta</option>
        </select>

        <button type="submit">Reportar</button>
        <a href="jefe_dashboard.php" class="btn btn-secondary">Cancelar</a>
    </form>

    <?php if (isset($mensaje)): ?>
        <p><?= $mensaje ?></p>
    <?php endif; ?>
</body>
</html>
