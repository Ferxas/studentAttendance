<?php
require_once(__DIR__ . '/../auth.php'); 
checkUserRole('admin'); 
?>


<div class="page-title mb-3 text-dark">Lista de Cursos</div>
<div style="width:3%;">
  <a class="nav-link <?= (isset($page)) && $page == 'home' ? 'active' : '' ?>" href="./">
    <i class="fa-solid fa-house"></i>
  </a>
</div>
<hr>
<?php 
$classList = $actionClass->list_class();
include_once("modals/delete.php");
?>
<div class="row justify-content-center">
    <div class="col-lg-8 col-md-10 col-sm-12 col-12">
        <div class="card shadow">
            <div class="card-header rounded-1 ">
                <div class="d-flex w-100 justify-content-end align-items-center">
                    <button class="btn btn-md rounded-1 btn-primary" type="button" id="add_class"><i class="fa-solid fa-plus"></i></button> 
                </div>
            </div>  
            <div class="card-body rounded-1">
                <div class="container-fluid">
                    <div class="table-responsive">
                        <table class="table table-hover table-hovered table-stripped">
                            <colgroup>
                                <col width="10%">
                                <col width="70%">
                                <col width="20%">
                            </colgroup>
                            <thead>
                            <!-- <thead class="bg-dark-subtle"> -->
                                <tr class="bg-transparent">
                                    <th class="bg-transparent text-center ">ID</th>
                                    <th class="bg-transparent text-center">Curso</th>
                                    <th class="bg-transparent text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $i=1?>
                                <?php if(!empty($classList) && is_array($classList)): ?>
                                <?php foreach($classList as $row): ?>
                                    <tr>
                                        <td class="text-center px-2 py-1"><?php echo $i++?></td>
                                        <td class="px-2 py-1"><?= $row['name'] ?></td>
                                        <td class="text-center px-2 py-1">
                                            <div class="input-group input-group-sm justify-content-center">
                                                <button class="btn btn-sm btn-warning rounded-1 edit_class" type="button" data-id="<?= $row['id'] ?>" title="Edit"><i class="fa-solid fa-pen-to-square"></i></button>
                                                &nbsp;&nbsp;
                                                <button class="btn btn-sm btn-danger rounded-1 delete_class" type="button" data-id="<?= $row['id'] ?>" title="Delete"><i class="fa-solid fa-trash-can"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <th class="text-center px-2 py-1" colspan="3">Registros no Encontrados.</th>
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
        $('#add_class').click(function(e){
            e.preventDefault()
            open_modal('class_form.php', `<?= isset($id) ? "Create New Class" : "Agregar Curso" ?>`)
        })
        $('.edit_class').click(function(e){
            e.preventDefault()
            var id = $(this)[0].dataset?.id || ''
            open_modal('class_form.php', `<?= isset($id) ? "Create New Class" : "Editar Curso" ?>`, {id: id})
        })
        // $('.delete_class').click(function(e){
        //     e.preventDefault()
        //     var id = $(this)[0].dataset?.id || ''
        //     start_loader()
        //     if(confirm(`Are you sure to delete the selected class? This action cannot be undone.`) == true){
        //         $.ajax({
        //             url: "./ajax-api.php?action=delete_class",
        //             method: "POST",
        //             data: { id : id},
        //             dataType: 'JSON',
        //             error: (error) => {
        //                 console.error(error)
        //                 alert('An error occurred.')
        //             },
        //             success:function(resp){
        //                 if(resp?.status != '')
        //                     location.reload();
        //                 else
        //                     end_loader();
        //             }
        //         })
        //     }else{
        //         end_loader();
        //     }
        // })
        $('.delete_class').click(function(e){
            e.preventDefault();
            let id = $(this).data('id') || '';
            $('#confirmDeleteModalClass').modal('show');
            $('#confirmDeleteModalClass').find('.confirm-deleteClass').click(function(){
                start_loader();
                $.ajax({
                    url: './ajax-api.php?action=delete_class',
                    method: 'POST',
                    data: {id : id},
                    dataType: 'JSON',
                    error: (error) =>{
                        console.error(error)
                        alert('Ocurrio un error.');
                    },
                    success: function(resp){
                        if(resp.status !== ''){
                            location.reload();
                        }else{
                            end_loader();
                        }
                    }
                });
            });
        });
    })
</script>