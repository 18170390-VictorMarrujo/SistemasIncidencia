<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_componente = $_GET['id'];

    // Eliminar el componente de la base de datos (deshabilitar)
    $stmt = $conn->prepare("UPDATE componentes SET estado = 'Deshabilitado' WHERE id_componente = ?");
    $stmt->bind_param("i", $id_componente);
    $stmt->execute();
    $stmt->close();

    echo "Componente deshabilitado con éxito.";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eliminar Componente</title>
</head>
<body>
    <h1>Eliminar Componente</h1>

    <p>¿Está seguro de que desea deshabilitar este componente?</p>
    <a href="listar_componentes.php">Volver al listado de componentes</a>
</body>
</html>
