<?php
session_start();
if ($_SESSION['tipo_usuario'] !== 'administrador') {
    header('Location: login.php');
    exit;
}

include 'config.php';

$id = $_GET['id'];

// Comprobar relaciones
$check_query = "SELECT COUNT(*) as total FROM edificios WHERE id_departamento = ?";
$stmt = $conn->prepare($check_query);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$count = $result->fetch_assoc();

if ($count['total'] > 0) {
    echo "No se puede eliminar el departamento porque tiene registros relacionados.";
    exit;
}

$query = "DELETE FROM departamentos WHERE id_departamento = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $id);

if ($stmt->execute()) {
    header('Location: listar_departamentos.php');
    exit;
} else {
    echo "Error al eliminar el departamento.";
}
?>
