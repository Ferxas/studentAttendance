<?php
session_start();
require_once('db-connect.php');

// Redirige a la página principal si el usuario ya está autenticado
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Consulta para obtener todos los campos necesarios, incluido el avatar
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verificar la contraseña
        if (password_verify($password, $user['password'])) {
            // Almacenar los datos del usuario en la sesión
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_course_id'] = $user['course_id']; 

            // Comprobar si el usuario tiene un avatar personalizado, si no, asignar uno por defecto
            $_SESSION['user_avatar'] = !empty($user['avatar']) ? $user['avatar'] : './assets/img/default_avatar.png';

            // Redirigir a la página principal
            header("Location: index.php");
            exit;
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "No se encontró el usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<?php require_once('inc/header.php') ?>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h2>Iniciar Sesión</h2>
                    </div>
                    <div class="card-body">
                        <form action="login.php" method="POST">
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger"><?= $error ?></div>
                            <?php endif; ?>
                            <div class="form-group mb-3">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" class="form-control" name="email" id="email" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Contraseña</label>
                                <input type="password" class="form-control" name="password" id="password" required>
                            </div>
                            <button type="submit" name="login" class="btn btn-primary w-100">Iniciar Sesión</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
