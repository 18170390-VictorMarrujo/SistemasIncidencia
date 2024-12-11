<?php
session_start();
require 'conexion.php';

// Verificar si el usuario está autenticado y es jefe de departamento
if (!isset($_SESSION['id_usuario']) || $_SESSION['tipo_usuario'] !== 'jefe_departamento') {
    header("Location: login.php");
    exit;
}

$id_usuario = $_SESSION['id_usuario']; // ID del jefe de departamento
$id_equipo = $_POST['id_equipo'];
$titulo = $_POST['titulo'];
$descripcion = $_POST['descripcion'];
$prioridad = $_POST['prioridad'];

// Insertar la incidencia en la base de datos
$sql = "INSERT INTO incidencias (id_usuario, id_equipo, titulo, descripcion, prioridad) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param('iisss', $id_usuario, $id_equipo, $titulo, $descripcion, $prioridad);

if ($stmt->execute()) {
    echo "Incidencia reportada exitosamente.";
    header("Location: reporte_incidencia.php?success=1");
} else {
    echo "Error al reportar la incidencia: " . $conn->error;
}
?>
