<?php
// session_start(); // Asegúrate de que la sesión esté iniciada
// si inicia sesión, muestra el contenido de la navegación

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once('classes/actions.class.php');



// Debug: Verificar si la sesión tiene los valores esperados
// echo '<pre>';
// print_r($_SESSION);
// echo '</pre>'; // Descomentar para depurar
?>

<nav class="navbar navbar-expand-lg navbar-light sticky-top" id="navbar">
    <div class="container-fluid">
        <a class="navbar-brand" href="./"> PARTE LMH</a>
        <img src="./assets/img/idk.png" alt="" style="width:45px;">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?= (isset($page)) && $page == 'home' ? 'active' : '' ?>" href="./">Inicio</a>
                </li>
                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link <?= (isset($page)) && $page == 'class_list' ? 'active' : '' ?>" href="./?page=class_list">Cursos</a>
                    </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link <?= (isset($page)) && $page == 'student_list' ? 'active' : '' ?>" href="./?page=student_list">Estudiantes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (isset($page)) && $page == 'attendance' ? 'active' : '' ?>" href="./?page=attendance">Asistencia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= (isset($page)) && $page == 'attendance_report' ? 'active' : '' ?>" href="./?page=attendance_report">Reporte</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="#" id="toggle-theme">
                        <i class="fa-solid fa-adjust"></i> Cambiar Tema
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./?page=profile">
                        <?php
                        // Verificar si el avatar está presente en la sesión
                        if (isset($_SESSION['user_avatar']) && !empty($_SESSION['user_avatar'])) {
                            $avatar = $_SESSION['user_avatar'];
                        } else {
                            // Y si no hay avatar, se usa la imagen por defecto
                            $avatar = './assets/img/default_avatar.png';
                            echo '
                        <i class="fa-solid fa-user"></i>
                            ';
                        }
                        ?>

                        <img src="<?= htmlspecialchars($avatar, ENT_QUOTES, 'UTF-8') ?>" alt="Avatar" style="width: 30px; height: 30px; border-radius: 50%; margin-right: 5px;">
                        <?= htmlspecialchars($_SESSION['user_name'] ?? 'User', ENT_QUOTES, 'UTF-8') ?> - <?= htmlspecialchars($_SESSION['user_role'] ?? 'Role', ENT_QUOTES, 'UTF-8') ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./logout.php">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        Cerrar sesión
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<?php 
// Este print es para depurar datos de la sesión
/* echo '<pre>';
print_r($_SESSION);
echo '</pre>';  */
?>

<style>
    body.dark-mode {
        background-color: #121212;
        color: #ffffff;
    }

    .navbar.dark-mode {
        background-color: #1f1f1f;
    }

</style>


<?php
//     return ob_get_clean();
// }
?>
