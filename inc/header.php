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
        const body = document.body;
        const navbar = document.getElementById('navbar');

        toggleThemeButton.addEventListener('click', function() {
            // Alternar clases de Bootstrap
            body.classList.toggle('bg-dark'); // Cambia el fondo a oscuro
            body.classList.toggle('text-dark'); // Cambia el texto a blanco
            navbar.classList.toggle('navbar-dark'); // Cambia la barra de navegación a oscuro
            navbar.classList.toggle('navbar-light'); // Cambia la barra de navegación a claro

            // Guardar la preferencia del tema
            const isDarkMode = body.classList.contains('bg-dark');
            localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
        });

        // Cargar el tema guardado al cargar la página
        const theme = localStorage.getItem('theme');
        if (theme === 'dark') {
            body.classList.add('bg-dark', 'text-dark');
            navbar.classList.add('navbar-dark');
            navbar.classList.remove('navbar-light');
        }
    });
</script>
