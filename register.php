<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/login_register_style.css">
    <title>Register</title>
</head>

<body>
    <div class="register-container">
        <form action="register.php" method="POST">
            <h2>Registro</h2>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Contraseña:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div>
                <label for="name">Nombre:</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="lastname">Apellido:</label>
                <input type="text" id="lastname" name="lastname" required>
            </div>
            <button type="submit" name="register">Registrar</button>
        </form>
    </div>
</body>
</html>


<?php
session_start();
require_once('db-connect.php');

if (isset($_POST['register'])) {
    # code...
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $role = 'encargado';


    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo 'El correo electrónico ya está registrado';
    } else {
        $stmt = $conn->prepare("INSERT INTO users (email, password, name, lastname, role) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $email, $password, $name, $lastname, $role);

        if ($stmt->execute()) {
            echo 'Registro exitoso. Ahora puedes <a href="login.php">iniciar sesión</a>';
        } else {
            echo 'Error al registrar. Intente nuevamente';
        }
    }


    $stmt->close();
    $conn->close();
}



?>