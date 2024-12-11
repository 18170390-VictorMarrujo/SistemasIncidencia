<?php
include 'config.php';

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
$stmt->execute([$id]);

header("Location: listar_usuarios.php");
?>
