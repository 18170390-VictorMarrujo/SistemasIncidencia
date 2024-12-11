<?php
include 'config.php'; // Incluir archivo de configuración para la conexión a la base de datos

// Verificar si se pasó el ID del equipo a editar
if (!isset($_GET['id'])) {
    die('ID de equipo no especificado');
}

$id_equipo = $_GET['id'];

// Obtener los datos del equipo para mostrar en el formulario
$sql = "SELECT * FROM equipos WHERE id_equipo = $id_equipo";
$result = $conn->query($sql);
$equipo = $result->fetch_assoc();

if (!$equipo) {
    die('Equipo no encontrado');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener datos del formulario
    $tipo = $_POST['tipo'];
    $descripcion = $_POST['descripcion'];
    $modelo = $_POST['modelo'];
    $numero_serie = $_POST['numero_serie'];
    $fecha_adquisicion = $_POST['fecha_adquisicion'];
    $garantia = $_POST['garantia'];
    $estado = $_POST['estado'];
    $id_aula = $_POST['id_aula'];

    // Actualizar el equipo
    $sql = "UPDATE equipos SET 
            tipo = '$tipo',
            descripcion = '$descripcion',
            modelo = '$modelo',
            numero_serie = '$numero_serie',
            fecha_adquisicion = '$fecha_adquisicion',
            garantia = '$garantia',
            estado = '$estado',
            id_aula = '$id_aula'
            WHERE id_equipo = $id_equipo";

    if ($conn->query($sql) === TRUE) {
        echo "Equipo actualizado correctamente";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Equipo</title>
    <link rel="stylesheet" href="css/fondo.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Editar Equipo</h1>
        <form action="editar_equipo.php?id=<?= $equipo['id_equipo'] ?>" method="POST">
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <select id="tipo" name="tipo" class="form-control" required>
                    <option value="computadora" <?= $equipo['tipo'] == 'computadora' ? 'selected' : '' ?>>Computadora</option>
                    <option value="proyector" <?= $equipo['tipo'] == 'proyector' ? 'selected' : '' ?>>Proyector</option>
                    <option value="monitor" <?= $equipo['tipo'] == 'monitor' ? 'selected' : '' ?>>Monitor</option>
                    <option value="periférico" <?= $equipo['tipo'] == 'periférico' ? 'selected' : '' ?>>Periférico</option>
                    <option value="red" <?= $equipo['tipo'] == 'red' ? 'selected' : '' ?>>Red</option>
                    <option value="otro" <?= $equipo['tipo'] == 'otro' ? 'selected' : '' ?>>Otro</option>
                </select>
            </div>
            <!-- Agregar campos similares para los demás atributos -->
            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Actualizar Equipo</button>
            </div>
        </form>
    </div>
</body>
</html>
