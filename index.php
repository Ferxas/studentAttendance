<?php
require_once('auth.php');
require_once('classes/actions.class.php');
// para desarrollo, usar estas 2 funciones en caso de que el header falle o no se muestre

// session_unset(); // delete all variables of session 
// session_destroy();


$actionClass = new Actions();
$page = $_GET['page'] ?? "home";
$page_title = ucwords(str_replace("_", " ", $page));
?>
<!DOCTYPE html>
<html lang="es">
<?php include_once('inc/header.php'); ?>

<body>
    <?php include_once('inc/navigation.php'); ?>
    <div class="container-md py-3">
        <?php if (isset($_SESSION['flashdata']) && !empty($_SESSION['flashdata'])): ?>
            <div class="flashdata flashdata-<?= $_SESSION['flashdata']['type'] ?? 'default' ?> mb-3">
                <div class="d-flex w-100 align-items-center flex-wrap">
                    <div class="col-11"><?= $_SESSION['flashdata']['msg'] ?? '' ?></div>
                    <div class="col-1 text-center">
                        <a href="javascript:void(0)" onclick="this.closest('.flashdata').remove()" class="flashdata-close">
                            <i class="far fa-times-circle"></i>
                        </a>

                    </div>
                </div>
            </div>
            <?php unset($_SESSION['flashdata']); ?>
        <?php endif; ?>
        <div class="main-wrapper">
            <?php include_once("pages/{$page}.php"); ?>
        </div>
    </div>


    <?php include_once('inc/footer.php'); ?>

</body>

</html>