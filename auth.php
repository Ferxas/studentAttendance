<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

function checkUserRole($requiredRole) {
    if ($_SESSION['user_role'] !== $requiredRole) { // Asegúrate de que 'user_role' es la clave correcta
        header('Location: index.php');
        exit();
    }
}

?>
