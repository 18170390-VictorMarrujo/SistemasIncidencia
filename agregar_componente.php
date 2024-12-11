<?php
include 'config.php';

// Obtener los equipos disponibles
$equipos = $conn->query("SELECT id_equipo, modelo FROM equipos");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $tipo = $_POST['tipo'];
    $estado = $_POST['estado'];
    $id_equipo = $_POST['id_equipo'];

    // Insertar el nuevo componente en la base de datos
    $stmt = $conn->prepare("INSERT INTO componentes (nombre, tipo, estado, id_equipo) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("sssi", $nombre, $tipo, $estado, $id_equipo);
    $stmt->execute();
    $stmt->close();

    echo "Componente agregado con éxito.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Componente</title>
</head>
<body>
    <h1>Agregar Componente</h1>

    <form method="POST">
        <label>Nombre del Componente:</label>
        <input type="text" name="nombre" required><br><br>

        <label>Tipo de Componente:</label>
        <input type="text" name="tipo" required><br><br>

        <label>Estado:</label>
        <select name="estado" required>
            <option value="Nuevo">Nuevo</option>
            <option value="Usado">Usado</option>
            <option value="En Reparación">En Reparación</option>
        </select><br><br>

        <label>Seleccionar Equipo:</label>
        <select name="id_equipo" required>
            <option value="">Seleccione un equipo</option>
            <?php while ($row = $equipos->fetch_assoc()): ?>
                <option value="<?= $row['id_equipo'] ?>"><?= $row['modelo'] ?></option>
            <?php endwhile; ?>
        </select><br><br>

        <button type="submit">Agregar Componente</button>
    </form>
</body>
</html>
