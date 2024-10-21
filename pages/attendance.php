<div class="page-title mb-3 text-dark">Registro de Asistencia</div>
<div style="width:3%;">
  <a class="nav-link <?= (isset($page)) && $page == 'home' ? 'active' : '' ?>" href="./">
    <i class="fa-solid fa-house"></i>
  </a>
</div>
<hr>
<?php 
$classList = $actionClass->list_class();
$user_role = $_SESSION['user_role'];
$user_course_id = $_SESSION['user_course_id'] ?? null;

$class_id = $_GET['class_id'] ?? "";
$class_date = $_GET['class_date'] ?? "";
$studentList = $actionClass->attendanceStudents($class_id, $class_date);

// Filtrar la lista de clases para que los encargados solo vean su curso
if ($user_role === 'encargado' && $user_course_id) {
    $classList = array_filter($classList, function($class) use ($user_course_id) {
        return $class['id'] == $user_course_id;
    });
}
?>
<!-- <pre>
    <?php print_r($studentList) ?>
</pre> -->
<form action="" id="manage-attendance">
    <div class="row justify-content-center">
        <div class="col-lg-12 col-md-12 col-sm-12 col-12">
            <div id="msg"></div>
            <div class="card shadow mb-3">
                <div class="card-body rounded-0">
                    <div class="container-fluid">
                        <div class="row align-items-end">
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <label for="class_id" class="form-label">Curso</label>
                                <select name="class_id" id="class_id" class="form-select" required="required">
                                    <option value="" disabled <?= empty($class_id) ? "selected" : "" ?>> -- Seleccionar Curso -- </option>
                                    <?php if(!empty($classList) && is_array($classList)): ?>
                                    <?php foreach($classList as $row): ?>
                                        <option value="<?= $row['id'] ?>" <?= (isset($class_id) && $class_id == $row['id']) ? "selected" : "" ?>><?= $row['name'] ?></option>
                                    <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12 col-12">
                                <label for="class_date" class="form-label">Fecha</label>
                                <input type="date" name="class_date" id="class_date" class="form-control" value="<?= $class_date ?? '' ?>" required="required">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php if(!empty($class_id) && !empty($class_date)): ?>
            <div class="card shadow mb-3">
                <div class="card-header rounded-0">
                    <div class="card-title">Hoja de Asistencia</div>
                </div>
                <div class="card-body">
                    <div class="container-fluid">
                        <div class="table-responsive">
                            <table id="attendance-tbl" class="table table-bordered">
                                <colgroup>
                                    <col width="40%">
                                    <col width="15%">
                                    <col width="15%">
                                    <col width="15%">
                                    <col width="15%">
                                </colgroup>
                                <thead class="bg-primary">
                                    <tr>
                                        <th class="text-center bg-transparent text-light">Estudiantes</th>
                                        <th class="text-center bg-transparent text-light">Disponible</th>
                                        <th class="text-center bg-transparent text-light">Tarde</th>
                                        <th class="text-center bg-transparent text-light">Faltista</th>
                                        <th class="text-center bg-transparent text-light">Permiso</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th class="text-center px-2 py-1 text-dark-emphasis">Marcar/Desmarcar todo</th>
                                        <th class="text-center px-2 py-1 text-dark-emphasis">
                                            <div class="form-check d-flex w-100 justify-content-center">
                                                <input class="form-check-input checkAll" type="checkbox" id="PcheckAll">
                                                <label class="form-check-label" for="PcheckAll">
                                                </label>
                                            </div>
                                        </th>
                                        <th class="text-center px-2 py-1 text-dark-emphasis">
                                            <div class="form-check d-flex w-100 justify-content-center">
                                                <input class="form-check-input checkAll" type="checkbox" id="LCheckAll">
                                                <label class="form-check-label" for="LCheckAll">
                                                </label>
                                            </div>
                                        </th>
                                        <th class="text-center px-2 py-1 text-dark-emphasis">
                                            <div class="form-check d-flex w-100 justify-content-center">
                                                <input class="form-check-input checkAll" type="checkbox" id="ACheckAll">
                                                <label class="form-check-label" for="ACheckAll">
                                                </label>
                                            </div>
                                        </th>
                                        <th class="text-center px-2 py-1 text-dark-emphasis">
                                            <div class="form-check d-flex w-100 justify-content-center">
                                                <input class="form-check-input checkAll" type="checkbox" id="HCheckAll">
                                                <label class="form-check-label" for="HCheckAll">
                                                </label>
                                            </div>
                                        </th>
                                    </tr>
                                    <?php if(!empty($studentList) && is_array($studentList)): ?>
                                    <?php foreach($studentList as $row): ?>
                                        <tr class="student-row">
                                            <td class="px-2 py-1 text-dark-emphasis fw-bold">
                                                <input type="hidden" name="student_id[]" value="<?= $row['id'] ?>">
                                                <?= $row['name'] ?>
                                            </td>
                                            <td class="text-center px-2 py-1 text-dark-emphasis">
                                                <div class="form-check d-flex w-100 justify-content-center">
                                                    <input class="form-check-input status_check" data-id="<?= $row['id'] ?>" type="checkbox" name="status[]" value="1" id="status_p_<?= $row['id'] ?>" <?= (isset($row['status']) && $row['status'] == 1) ? "checked" : "" ?>>
                                                    <label class="form-check-label" for="status_p_<?= $row['id'] ?>">
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center px-2 py-1 text-dark-emphasis">
                                                <div class="form-check d-flex w-100 justify-content-center">
                                                    <input class="form-check-input status_check" data-id="<?= $row['id'] ?>" type="checkbox" name="status[]" value="2" id="status_l_<?= $row['id'] ?>" <?= (isset($row['status']) && $row['status'] == 2) ? "checked" : "" ?>>
                                                    <label class="form-check-label" for="status_l_<?= $row['id'] ?>">
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center px-2 py-1 text-dark-emphasis">
                                                <div class="form-check d-flex w-100 justify-content-center">
                                                    <input class="form-check-input status_check" data-id="<?= $row['id'] ?>" type="checkbox" name="status[]" value="3" id="status_a_<?= $row['id'] ?>" <?= (isset($row['status']) && $row['status'] == 3) ? "checked" : "" ?>>
                                                    <label class="form-check-label" for="status_a_<?= $row['id'] ?>">
                                                    </label>
                                                </div>
                                            </td>
                                            <td class="text-center px-2 py-1 text-dark-emphasis">
                                                <div class="form-check d-flex w-100 justify-content-center">
                                                    <input class="form-check-input status_check" data-id="<?= $row['id'] ?>" type="checkbox" name="status[]" value="4" id="status_h_<?= $row['id'] ?>" <?= (isset($row['status']) && $row['status'] == 4) ? "checked" : "" ?>>
                                                    <label class="form-check-label" for="status_h_<?= $row['id'] ?>">
                                                    </label>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="px-2 py-1 text-center">No se registro ningun estudiante</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex w-100 justify-content-center align-items-center">
                <div class="col-lg-4 col-md-6 col-sm-12 col-12">
                    <button class="btn btn-primary rounded-pill w-100" type="submit">Guardar Asistencia</button>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</form>
<script>
    $(document).ready(function(){
        checkAll_count()

        $('#class_id, #class_date').change(function(e){
            var class_id = $('#class_id').val()
            var class_date = $('#class_date').val()
            location.replace(`./?page=attendance&class_id=${class_id}&class_date=${class_date}`)
        })
        $('.status_check').change(function(){
            var student_id = $(this)[0].dataset?.id
            var isChecked = $(this).is(":checked")
            if(isChecked === true){
                $(`.status_check[data-id='${student_id}']`).prop("checked", false)
                $(this).prop("checked", true)
            }
            checkAll_count()
        })
        $('.checkAll').change(function(){
            var _this = $(this)
            var isChecked = $(this).is(":checked")
            var id = $(this).attr('id')
            if(isChecked === true){
                $('.checkAll').each(function(){
                    if($(this).attr('id') != id&& $(this).is(":checked") == true){
                        $(this).prop("checked", false)
                    }
                })
                $('.status_check').prop('checked', false)
                if(id == 'PcheckAll'){
                    $('.status_check[value="1"]').prop('checked', true) 
                }else if(id == 'LCheckAll'){
                    $('.status_check[value="2"]').prop('checked', true) 
                }else if(id == 'ACheckAll'){
                    $('.status_check[value="3"]').prop('checked', true) 
                }else if(id == 'HCheckAll'){
                    $('.status_check[value="4"]').prop('checked', true) 
                }
            }else{
                if(id == 'PcheckAll'){
                    $('.status_check[value="1"]').prop('checked', false) 
                }else if(id == 'LCheckAll'){
                    $('.status_check[value="2"]').prop('checked', false) 
                }else if(id == 'ACheckAll'){
                    $('.status_check[value="3"]').prop('checked', false) 
                }else if(id == 'HCheckAll'){
                    $('.status_check[value="4"]').prop('checked', false) 
                }
            }
        })
        $('#manage-attendance').submit(function(e){
            e.preventDefault()
            start_loader()
            var _this = $(this)
            $('#attendance-tbl .student-row').each(function(){
                var has_checks = $(this).find('.status_check:checked').length
                if(has_checks < 1){
                    var name = $(this).find('td').first().text() || "";
                        name = String(name).trim();
                    console.log(name)
                    alert(`${name}'s attendance is not yet marked!`);
                    end_loader()
                    return false;
                }
            })
            $.ajax({
                url:'./ajax-api.php?action=save_attendance',
                method: 'POST',
                data: $(this).serialize(),
                dataType: 'JSON',
                error: (err) => {
                    console.error(err)
                    alert("An error occurred while saving the data. kindly reload this page.")
                    end_loader();
                },
                success: function(resp){
                    if(resp?.status == "success"){
                        location.reload()
                    }else if(resp?.status == "error" && resp?.msg != ""){
                        var fd = $(flashdataHTML).clone()
                       fd.addClass('flashdata-danger')
                       fd.find('.flashdata-msg').html(resp.msg)
                        $('#msg').html(fd)
                        $('html, body').scrollTop(0)
                    }else{
                        alert("An error occurred while saving the data. kindly reload this page.")
                    }
                    end_loader();
                }
            })
        })
    })

    function checkAll_count(){
        var statuses = {'PcheckAll': 1, 'LCheckAll': 2, 'ACheckAll': 3, 'HCheckAll':4}
        $('.checkAll').each(function(){
            var id = $(this).attr('id')
            var checkedCount = $(`.status_check[value="${statuses[id]}"]:checked`).length
            var totalCount = $(`.status_check[value="${statuses[id]}"]`).length
            if(totalCount != checkedCount){
                $(this).prop('checked', false)
            }else{
                $(`#${id}`).prop('checked', true)
            }
        })
    }
</script>