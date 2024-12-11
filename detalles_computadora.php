<?php
session_start();
if ($_SESSION['tipo_usuario'] !== 'administrador') {
    header('Location: login.php');
    exit;
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_equipo = $_POST['id_equipo'];
    $procesador = $_POST['procesador'];
    $ram = $_POST['ram'];
    $almacenamiento = $_POST['almacenamiento'];
    $tarjeta_grafica = $_POST['tarjeta_grafica'];
    $sistema_operativo = $_POST['sistema_operativo'];

    $query = "INSERT INTO detalles_computadora (id_equipo, procesador, ram, almacenamiento, tarjeta_grafica, sistema_operativo)
              VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('isssss', $id_equipo, $procesador, $ram, $almacenamiento, $tarjeta_grafica, $sistema_operativo);

    if ($stmt->execute()) {
        header('Location: listar_equipos.php');
        exit;
    } else {
        $error = "Error al registrar los detalles de la computadora.";
    }
}

$equipos_query = "SELECT id_equipo, modelo FROM equipos WHERE tipo = 'Computadora'";
$equipos_result = $conn->query($equipos_query);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Computadora</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3>Registrar Detalles de Computadora</h3>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="mb-3">
            <label for="id_equipo" class="form-label">Equipo</label>
            <select name="id_equipo" id="id_equipo" class="form-select" required>
                <option value="">Seleccione un equipo</option>
                <?php while ($equipo = $equipos_result->fetch_assoc()): ?>
                    <option value="<?php echo $equipo['id_equipo']; ?>">
                        <?php echo $equipo['modelo']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="procesador" class="form-label">Procesador</label>
            <input type="text" name="procesador" id="procesador" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="ram" class="form-label">RAM (GB)</label>
            <input type="number" name="ram" id="ram" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="almacenamiento" class="form-label">Almacenamiento (GB)</label>
            <input type="number" name="almacenamiento" id="almacenamiento" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="tarjeta_grafica" class="form-label">Tarjeta Gráfica</label>
            <input type="text" name="tarjeta_grafica" id="tarjeta_grafica" class="form-control">
        </div>
        <div class="mb-3">
            <label for="sistema_operativo" class="form-label">Sistema Operativo</label>
            <input type="text" name="sistema_operativo" id="sistema_operativo" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <a href="listar_equipos.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</body>
</html>
