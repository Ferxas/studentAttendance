<?php
require_once(__DIR__ . '/../auth.php');

// Obtener los datos del usuario
$user_id = $_SESSION['user_id']; 
$user_data = $actionClass->get_user_data($user_id);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Manejar la subida de la imagen
    if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
        $fileTmpPath = $_FILES['avatar']['tmp_name'];
        $fileName = $_FILES['avatar']['name'];
        $fileNameCmps = explode(".", $fileName);
        $fileExtension = strtolower(end($fileNameCmps));

        $allowedfileExtensions = array('jpg', 'gif', 'png', 'jpeg');
        if (in_array($fileExtension, $allowedfileExtensions)) {
            $newFileName = 'avatar_' . $user_id . '_' . time() . '.' . $fileExtension;
            $uploadFileDir = './uploads/';
            $dest_path = $uploadFileDir . $newFileName;

            if (!is_dir($uploadFileDir)) {
                mkdir($uploadFileDir, 0755, true);
            }

            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                $actionClass->update_user_avatar($user_id, $dest_path);
                $_SESSION['user_avatar'] = $dest_path;
                $message = "Avatar subido con éxito. Actualiza la página o cambia de página.";
            } else {
                $message = "Hubo un error al subir el archivo.";
            }
        } else {
            $message = "Tipo de archivo no permitido.";
        }
    }
}
?>

    <div class="page-title mb-3 text-dark">Perfil de Usuario</div>
    <div class="container">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="username" class="form-label">Nombre de Usuario</label>
                <input type="text" class="form-control" id="username" value="<?= htmlspecialchars($user_data['name'] ?? 'No disponible') ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="role" class="form-label">Rol</label>
                <input type="text" class="form-control" id="role" value="<?= htmlspecialchars($user_data['role'] ?? 'No disponible') ?>" readonly>
            </div>
            <div class="mb-3">
                <label for="avatar" class="form-label">Subir Avatar</label>
                <input type="file" class="form-control" id="avatar" name="avatar" accept="image/*">
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
        <?php if (isset($message)): ?>
            <div class="alert alert-info mt-3"><?= $message ?></div>
        <?php endif; ?>
    </div>
</html>