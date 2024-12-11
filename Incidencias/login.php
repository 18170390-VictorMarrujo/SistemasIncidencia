<?php
session_start();
// Incluir archivo de configuración para la conexión a la base de datos
require_once('config.php');

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los datos del formulario
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Preparar consulta para verificar el usuario
    $query = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verificar si el usuario existe y la contraseña es correcta
    if ($user && $password === $user['contrasena']) { // Comparar directamente sin hash
        // Iniciar sesión
        $_SESSION['user_id'] = $user['id_usuario'];
        $_SESSION['user_email'] = $user['correo'];
        $_SESSION['user_role'] = $user['tipo_usuario'];
        $_SESSION['user_name'] = $user['nombre'];   

        // Si el usuario es un jefe de departamento, obtener el id_departamento
        if ($_SESSION['user_role'] === 'jefe_departamento') {
            $query_depto = "SELECT id_departamento FROM departamentos WHERE jefe_departamento = ?";
            $stmt_depto = $conn->prepare($query_depto);
            $stmt_depto->bind_param("i", $_SESSION['user_id']);
            $stmt_depto->execute();
            $result_depto = $stmt_depto->get_result();

            if ($row_depto = $result_depto->fetch_assoc()) {
                $_SESSION['departamento_id'] = $row_depto['id_departamento']; // Asignar el ID del departamento a la sesión
            } else {
                $_SESSION['departamento_id'] = null; // O manejar esto según sea necesario
            }

            $stmt_depto->close();
        }

        // Redireccionar al dashboard correspondiente
        switch ($_SESSION['user_role']) {
            case 'administrador':
                header('Location: admin_dashboard.php');
                break;
            case 'tecnico':
                header('Location: tecnico_dashboard.php');
                break;
            case 'jefe_departamento':
                header('Location: jefe_dashboard.php');
                break;
            default:
                header('Location: usuario_dashboard.php');
                break;
        }
        exit();
    } else {
        // Si hay error con los datos
        $error_message = "Credenciales incorrectas."; // Mensaje más general
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Incidencias</title>
    <link href="css/login.css" rel="stylesheet">
</head>
<body>

    <div class="login-container">
        <div class="login-card">
            <h2>Iniciar sesión</h2>

            <?php if (isset($error_message)): ?>
                <div class="alert alert-danger">
                    <?php echo htmlspecialchars($error_message); ?>
                </div>
            <?php endif; ?>

            <form action="login.php" method="POST">
                <div class="input-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                </div>

                <div class="input-group">
                    <label for="password">Contraseña</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <button type="submit" class="btn-submit">Acceder</button>

                <div class="footer-links">
                    <!-- Puedes agregar enlaces aquí si es necesario -->
                </div>
            </form>
        </div>
    </div>

</body>
</html>
