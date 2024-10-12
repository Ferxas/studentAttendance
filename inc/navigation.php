<nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color: #1f503f;color:white" data-bs-theme="black">
    <!-- <nav class="navbar navbar-expand-lg navbar-light bg-dark subtle sticky-top" data-bs-theme="dark"> -->
    <div class="container-fluid">
        <a class="navbar-brand text-white" href="./"> PARTE LMH</a>
        <img src="./assets/img/idk.png" alt="" style="width:45px;">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-white <?= (isset($page)) && $page == 'home' ? 'active' : '' ?>" href="./">Inicio</a>
                </li>
                <?php if ($_SESSION['user_role'] === 'admin'): ?>
                <li class="nav-item">
                    <a class="nav-link text-white <?= (isset($page)) && $page == 'class_list' ? 'active' : '' ?>" href="./?page=class_list">Cursos</a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link text-white <?= (isset($page)) && $page == 'student_list' ? 'active' : '' ?>" href="./?page=student_list">Estudiantes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?= (isset($page)) && $page == 'attendance' ? 'active' : '' ?>" href="./?page=attendance">Asistencia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white <?= (isset($page)) && $page == 'attendance_report' ? 'active' : '' ?>" href="./?page=attendance_report">Reporte</a>
                </li>
            </ul>
            <!-- Move Logout to the right end -->
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link text-white" href="#">
                        <i class="fa-solid fa-user"></i>
                        <?= $_SESSION['user_name'] ?? 'User' ?> - <?= $_SESSION['user_role'] ?? 'Role' ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="./logout.php">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        Logout
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
