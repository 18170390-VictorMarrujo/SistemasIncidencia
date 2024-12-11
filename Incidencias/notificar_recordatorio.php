<?php
include 'config.php';

// Obtener los equipos con garantía próxima a vencer o fuera de servicio
$equipos = $conn->query("SELECT e.modelo, e.estado, e.fecha_garantia, u.correo
                         FROM equipos e
                         JOIN usuarios u ON e.id_usuario_responsable = u.id_usuario
                         WHERE e.estado = 'Fuera de servicio' OR e.fecha_garantia <= CURDATE() + INTERVAL 30 DAY");

while ($equipo = $equipos->fetch_assoc()) {
    // Crear un mensaje de notificación
    if ($equipo['estado'] == 'Fuera de servicio') {
        $mensaje = "El equipo " . $equipo['modelo'] . " está fuera de servicio.";
    } else {
        $mensaje = "La garantía del equipo " . $equipo['modelo'] . " está próxima a vencer.";
    }

    // Enviar correo de recordatorio
    mail($equipo['correo'], "Recordatorio de Equipo", $mensaje);
}

echo "Notificaciones de recordatorio enviadas.";
?>
