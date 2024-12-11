<?php
include 'config.php'; // Incluir archivo de configuración para la conexión a la base de datos

// Verificar si se pasó el ID del equipo a eliminar
if (!isset($_GET['id'])) {
    die('ID de equipo no especificado');
}

$id_equipo = $_GET['id'];

// Eliminar el equipo
$sql = "DELETE FROM equipos WHERE id_equipo = $id_equipo";

if ($conn->query($sql) === TRUE) {
    echo "Equipo eliminado correctamente";
} else {
    echo "Error: " . $conn->error;
}
?>
