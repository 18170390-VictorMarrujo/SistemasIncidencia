<?php
include 'config.php';

// Suponiendo que la asignación de la incidencia ya se ha realizado
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_incidencia'], $_GET['id_tecnico'])) {
    $id_incidencia = $_GET['id_incidencia'];
    $id_tecnico = $_GET['id_tecnico'];

    // Obtener los detalles de la incidencia y del técnico
    $incidencia = $conn->query("SELECT descripcion FROM incidencias WHERE id_incidencia = $id_incidencia")->fetch_assoc();
    $tecnico = $conn->query("SELECT nombre, correo FROM usuarios WHERE id_usuario = $id_tecnico")->fetch_assoc();

    if ($incidencia && $tecnico) {
        // Crear un mensaje de notificación
        $mensaje = "Se le ha asignado una nueva incidencia: " . $incidencia['descripcion'];

        // Enviar correo de notificación al técnico
        mail($tecnico['correo'], "Nueva Incidencia Asignada", $mensaje);

        echo "Notificación enviada al técnico.";
    } else {
        echo "Incidencia o técnico no encontrado.";
    }
}
?>
