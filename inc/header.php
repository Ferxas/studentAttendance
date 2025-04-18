<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? '' ?> | Parte del cuerpo de alumnos</title>
    <!-- FAVICON -->
    <link rel="shortcut icon" href="../assets/img/favicon.png" type="image/x-icon">
    <!-- Fontawesome CSS CDN -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Bootstrap CSS CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/theme.css">

    <!-- Fontawesome CSS CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/js/all.min.js" integrity="sha512-uKQ39gEGiyUJl4AI6L+ekBdGKpGw4xJ55+xyJG7YFlJokPNYegn9KwQ3P8A7aFQAUtUsAQHep+d/lrGqrbPIDQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <!-- jQuery CSS CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS CDN -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- TAILWIND CSS -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->


</head>
<script>
    document.addEventListener('DOMContentLoaded', function() {
    const toggleThemeButton = document.getElementById('toggle-theme');
    const html = document.documentElement;
    const navbar = document.getElementById('navbar');

    function setTheme(isDark) {
        if (isDark) {
            html.setAttribute('data-bs-theme', 'dark');
            navbar.classList.remove('navbar-light');
            navbar.classList.add('navbar-dark');
        } else {
            html.setAttribute('data-bs-theme', 'light');
            navbar.classList.remove('navbar-dark');
            navbar.classList.add('navbar-light');
        }
        localStorage.setItem('theme', isDark ? 'dark' : 'light');
    }

    // Manejar el clic en el botón de tema
    toggleThemeButton.addEventListener('click', function() {
        const isDark = html.getAttribute('data-bs-theme') !== 'dark';
        setTheme(isDark);
    });

    // Cargar tema guardado
    const savedTheme = localStorage.getItem('theme') === 'dark';
    setTheme(savedTheme);
});
</script>
