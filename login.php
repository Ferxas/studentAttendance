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
    <section class="vh-100">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <div class="px-5 ms-xl-4 d-flex justify-content-between align-items-center">
                        <div>
                            <img src="./assets/img/Tiger_Final.svg" width="50px" height="100px" alt="">
                            <span class="h1 fw-bold mb-0">Institución LMH</span>
                        </div>
                        <button id="darkModeToggle" class="btn btn-outline-secondary mt-4">
                            <i class="fas fa-moon"></i> Modo Oscuro
                        </button>
                    </div>
                    <div class="d-flex align-items-center h-custom-2 px-5 ms-xl-4 mt-5 pt-5 pt-xl-0 mt-xl-n5">
                        <form action="login.php" method="POST" style="width: 23rem;">
                            <h3 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Iniciar Sesión</h3>
                            <?php if (isset($error)): ?>
                                <div class="alert alert-danger"><?= $error ?></div>
                            <?php endif; ?>
                            <div class="form-outline mb-4">
                                <input type="email" id="email" name="email" class="form-control form-control-lg" required />
                                <label class="form-label" for="email">Correo Electrónico</label>
                            </div>
                            <div class="form-outline mb-4">
                                <input type="password" id="password" name="password" class="form-control form-control-lg" required />
                                <label class="form-label" for="password">Contraseña</label>
                            </div>
                            <div class="pt-1 mb-4">
                                <button class="btn btn-info btn-lg btn-block" type="submit" name="login">Iniciar Sesión</button>
                            </div>
                            <p class="small mb-5 pb-lg-2"><a class="text-muted" href="#!">¿Olvidaste tu contraseña?</a></p>
                            <p>¿No tienes una cuenta? <a href="#!" class="link-info">Regístrate aquí</a></p>
                        </form>
                    </div>
                </div>
                <div class="col-sm-6 px-0 d-none d-sm-block">
                    <img src="./assets/img/login_pic.jpg"
                        alt="Login image" class="w-100 vh-100" style="object-fit: cover; object-position: left;">
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const darkModeToggle = document.getElementById('darkModeToggle');
            const body = document.body;

            function toggleDarkMode() {
                body.classList.toggle('dark-mode');
                updateDarkModeButton();
                saveDarkModePreference();
            }

            function updateDarkModeButton() {
                if (body.classList.contains('dark-mode')) {
                    darkModeToggle.innerHTML = '<i class="fas fa-sun"></i> Modo Claro';
                } else {
                    darkModeToggle.innerHTML = '<i class="fas fa-moon"></i> Modo Oscuro';
                }
            }

            function saveDarkModePreference() {
                localStorage.setItem('darkMode', body.classList.contains('dark-mode'));
            }

            function loadDarkModePreference() {
                const isDarkMode = localStorage.getItem('darkMode') === 'true';
                if (isDarkMode) {
                    body.classList.add('dark-mode');
                }
                updateDarkModeButton();
            }

            darkModeToggle.addEventListener('click', toggleDarkMode);
            loadDarkModePreference();
        });
    </script>
    <style>
        body {
            transition: background-color 0.3s, color 0.3s;
        }

        body.dark-mode {
            background-color: #1a1a1a;
            color: #f0f0f0;
        }

        .dark-mode .col-sm-6:first-child {
            background-color: #2a2a2a;
        }

        .dark-mode .form-control {
            background-color: #333;
            color: #f0f0f0;
            border-color: #444;
        }

        .dark-mode .form-label {
            color: #f0f0f0;
        }

        .dark-mode .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .dark-mode .text-muted {
            color: #bbb !important;
        }

        .dark-mode .link-info {
            color: #5bc0de;
        }

        .dark-mode #darkModeToggle {
            background-color: #f0f0f0;
            color: #1a1a1a;
        }

        .dark-mode .alert-danger {
            background-color: #4a1c1c;
            color: #f0f0f0;
            border-color: #5e2828;
        }
    </style>
</body>
</html>