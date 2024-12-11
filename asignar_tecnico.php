<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_equipo = $_POST['id_equipo'];
    $id_tecnico = $_POST['id_tecnico'];

    // Actualizar la incidencia y asignar el técnico
    $sql = "UPDATE incidencias 
            SET id_tecnico = ? 
            WHERE id_equipo = ? AND estado != 'cerrada'";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $id_tecnico, $id_equipo);

    if ($stmt->execute()) {
        echo "Técnico asignado correctamente.";
    } else {
        echo "Error al asignar el técnico.";
    }

    // Redirigir de vuelta
    header("Location: equipos_mas_incidencias.php");
    exit();
}
?>
