<?php
include 'config.php';

// Suponiendo que la incidencia ha sido cerrada y está lista para evaluación
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id_incidencia'], $_GET['id_jefe'])) {
    $id_incidencia = $_GET['id_incidencia'];
    $id_jefe = $_GET['id_jefe'];

    // Obtener los detalles de la incidencia y del jefe de departamento
    $incidencia = $conn->query("SELECT descripcion FROM incidencias WHERE id_incidencia = $id_incidencia")->fetch_assoc();
    $jefe = $conn->query("SELECT nombre, correo FROM usuarios WHERE id_usuario = $id_jefe")->fetch_assoc();

    if ($incidencia && $jefe) {
        // Crear un mensaje de notificación
        $mensaje = "La incidencia está lista para evaluación: " . $incidencia['descripcion'];

        // Enviar correo de notificación al jefe de departamento
        mail($jefe['correo'], "Incidencia Lista para Evaluación", $mensaje);

        echo "Notificación enviada al jefe de departamento.";
    } else {
        echo "Incidencia o jefe de departamento no encontrado.";
    }
}
?>
