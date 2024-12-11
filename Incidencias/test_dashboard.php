<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['role'])) {
    echo "La sesión no está configurada.";
} else {
    echo "Rol actual: " . $_SESSION['role'];
}
?>