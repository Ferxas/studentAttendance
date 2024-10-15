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
                    <a class="nav-link" href="#">
                        <i class="fa-solid fa-user"></i>
                        <?= $_SESSION['user_name'] ?? 'User' ?> - <?= $_SESSION['user_role'] ?? 'Role' ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./logout.php">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    body.dark-mode {
        background-color: #121212;
        color: #ffffff;
    }
    .navbar.dark-mode {
        background-color: #1f1f1f;
    }
    /* Agrega más estilos para otros elementos en modo oscuro */
</style>
