<!DOCTYPE html>
<html lang="en">

<?php require_once('./inc/header.php') ?>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-center">
                        <h2>Registro</h2>
                    </div>
                    <div class="card-body">
                        <form action="register.php" method="POST">
                            <div class="form-group mb-3">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">Contraseña:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="name">Nombre:</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="lastname">Apellido:</label>
                                <input type="text" class="form-control" id="lastname" name="lastname" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="course">Curso:</label>
                                <select class="form-control" id="course" name="course" required>
                                    <?php
                                    require_once('db-connect.php');
                                    $courses = $conn->query("SELECT id, name FROM class_tbl");
                                    while ($course = $courses->fetch_assoc()) {
                                        echo "<option value='{$course['id']}'>{$course['name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <button type="submit" name="register" class="btn btn-primary w-100">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>


<?php
session_start();
require_once('db-connect.php');

if (isset($_POST['register'])) {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $role = 'encargado';
    $course_id = $_POST['course'];

    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo 'El correo electrónico ya está registrado';
    } else {
        $stmt = $conn->prepare("INSERT INTO users (email, password, name, lastname, role, course_id) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("sssssi", $email, $password, $name, $lastname, $role, $course_id);

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
