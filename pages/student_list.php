<?php
require_once(__DIR__ . '/../auth.php'); // Asegúrate de que la ruta es correcta

// Obtener el rol y el curso del usuario
$user_role = $_SESSION['user_role'];
$user_course_id = $_SESSION['user_course_id'] ?? null;

$studentList = [];
if ($user_role === 'admin') {
    $studentList = $actionClass->list_student();
} elseif ($user_role === 'encargado' && $user_course_id) {
    $studentList = $actionClass->list_student_by_course($user_course_id);
}

include_once("modals/delete.php");
?>

<div class="page-title mb-3 text-dark">Lista de Estudiantes</div>
<div style="width:3%;">
    <a class="nav-link <?= (isset($page)) && $page == 'home' ? 'active' : '' ?>" href="./">
        <i class="fa-solid fa-house"></i>
    </a>
</div>
<hr>
<div class="row justify-content-center">
    <div class="col-lg-10 col-md-12 col-sm-12 col-12">
        <div class="card shadow">
            <div class="card-header rounded-0">
                <div class="d-flex w-100 justify-content-end align-items-center">
                    <input class="form-control" type="text" id="search_input" placeholder="Buscar estudiantes..." style="width:50%;margin-right:50%;">
                    <button class="btn btn-md rounded-1 btn-primary" type="button" id="add_student"><i class="fa-solid fa-plus"></i></button>
                </div>
            </div>
            <div class="card-body rounded-0">
                <div class="container-fluid">
                    <div class="table-responsive">
                        <table class="table table-hover table-hovered table-stripped">
                            <colgroup>
                                <col width="10%">
                                <col width="30%">
                                <col width="40%">
                                <col width="20%">
                            </colgroup>
                            <thead>
                                <tr class="bg-transparent">
                                    <th class="bg-transparent text-center">ID</th>
                                    <th class="bg-transparent text-center">Curso</th>
                                    <th class="bg-transparent text-center">Estudiante</th>
                                    <th class="bg-transparent text-center">Accion</th>
                                </tr>
                            </thead>
                            <tbody id="table_body">
                                <?php $i=1 ?>
                                <?php if(!empty($studentList) && is_array($studentList)): ?>
                                <?php foreach($studentList as $row): ?>
                                    <tr>
                                        <td class="text-center px-2 py-1"><?php echo $i++;?></td>
                                        <td class="px-2 py-1"><?= $row['class'] ?></td>
                                        <td class="px-2 py-1"><?= $row['name'] ?></td>
                                        <td class="text-center px-2 py-1">
                                            <div class="input-group input-group-sm justify-content-center">
                                                <button class="btn btn-sm btn-warning rounded-1 edit_student" type="button" data-id="<?= $row['id'] ?>" title="Edit"><i class="fas fa-edit"></i></button>
                                                &nbsp;&nbsp;
                                                <button class="btn btn-sm btn-danger rounded-1 delete_student" type="button" data-id="<?= $row['id'] ?>" title="Delete"><i class="fa-solid fa-trash-can"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <th class="text-center px-2 py-1" colspan="4">Registros no Encontrados.</th>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#add_student').click(function(e){
            e.preventDefault()
            open_modal('student_form.php', `<?= isset($id) ? "Add New Student" : "Registrar Estudiante" ?>`)
        })
        $('.edit_student').click(function(e){
            e.preventDefault()
            var id = $(this)[0].dataset?.id || ''
            open_modal('student_form.php', `<?= isset($id) ? "Create New Student" : "Editar Estudiante" ?>`, {id: id})
        })
       
        $('.delete_student').click(function(e){
            e.preventDefault();
            let id = $(this).data('id') || '';
            $('#confirmDeleteModal').modal('show');
            $('#confirmDeleteModal').find('.confirm-delete').click(function(){
                start_loader();
                $.ajax({
                    url: "./ajax-api.php?action=delete_student",
                    method: "POST",
                    data:{id: id},
                    dataType: 'JSON',
                    error: function(error) {
                        console.error(error);
                        alert('Ocurrio un error.');
                    },
                    success: function(resp){
                        if(resp?.status !== ''){
                            location.reload();
                        }else{
                            end_loader();
                        }
                    }
                });
            });
        });
    })

    document.addEventListener("DOMContentLoaded", function() {
        var searchInput = document.getElementById('search_input');
        var studentList = document.getElementById('table_body').getElementsByTagName('tr');

        searchInput.addEventListener('input', function() {
            var searchTerm = this.value.trim().toLowerCase();
            for (var i = 0; i < studentList.length; i++) {
                var studentName = studentList[i].getElementsByTagName('td')[2].textContent.trim().toLowerCase();
                if (studentName.includes(searchTerm)) {
                    studentList[i].style.display = 'table-row';
                } else {
                    studentList[i].style.display = 'none';
                }
            }
        });
    });
</script>
