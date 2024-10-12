<?php
class Actions{
    private $conn;
    function __construct(){
        require_once(realpath(__DIR__.'/../db-connect.php'));
        $this->conn = $conn;
    }
    /**
     * Class Actions
     */
    public function save_class(){
        foreach($_POST as $k => $v){
            if(!is_array($_POST[$k]) && !is_numeric($_POST[$k]) && !empty($_POST[$k])){
                $_POST[$k] = addslashes(htmlspecialchars($v));
            }
        }
        extract($_POST);

        if(!empty($id)){
            $check = $this->conn->query("SELECT id FROM `class_tbl` where `name` = '{$name}' and `id` != '{$id}' ");
            $sql = "UPDATE `class_tbl` set `name` = '{$name}' where `id` = '{$id}'";
        }else{
            
            $check = $this->conn->query("SELECT id FROM `class_tbl` where `name` = '{$name}' ");
            $sql = "INSERT `class_tbl` set `name` = '{$name}'";
        }
        if($check->num_rows > 0){
            return ['status' => 'error', 'msg' => 'Class Name Already Exists!'];
        }else{
            $qry = $this->conn->query($sql);
            if($qry){
                if(empty($id)){
                    $_SESSION['flashdata'] = [ 'type' => 'success', 'msg' => "El curso se ha agregado con éxito!" ];
                }else{
                    $_SESSION['flashdata'] = [ 'type' => 'success', 'msg' => "El curso se ha actualziado con éxito!" ];
                }
                return [ 'status' => 'success'];
            }else{
                if(empty($id)){
                    return ['status' => 'error', 'msg' => 'Se produjo un error al guardar el nuevo curso!'];
                }else{
                    return ['status' => 'error', 'msg' => 'Se produjo un error al actualizar el curso!'];
                }
            }
        }
        
    }
    public function delete_class(){
        extract($_POST);
        $delete = $this->conn->query("DELETE FROM `class_tbl` where `id` = '{$id}'");
        if($delete){
            $_SESSION['flashdata'] = [ 'type' => 'success', 'msg' => "El curso ha sido eliminado exitosamente.!" ];
            return [ "status" => "success" ];
        }else{
            $_SESSION['flashdata'] = [ 'type' => 'danger', 'msg' => "El curso no se pudo eliminar debido a un motivo desconocido!" ];
            return [ "status" => "error", "El curso no se ha podido eliminar!" ];
        }
    }
    public function list_class(){
        $sql = "SELECT * FROM `class_tbl` order by `name` ASC";
        $qry = $this->conn->query($sql);
        return $qry->fetch_all(MYSQLI_ASSOC);
    }
    public function get_class($id=""){
        $sql = "SELECT * FROM `class_tbl` where `id` = '{$id}'";
        $qry = $this->conn->query($sql);
        $result = $qry->fetch_assoc();
        return $result;
    }
    /**
     * Student Actions
     */
    
     public function save_student(){
        foreach($_POST as $k => $v){
            if(!is_array($_POST[$k]) && !is_numeric($_POST[$k]) && !empty($_POST[$k])){
                $_POST[$k] = addslashes(htmlspecialchars($v));
            }
        }
        extract($_POST);

        if(!empty($id)){
            $check = $this->conn->query("SELECT id FROM `students_tbl` where `name` = '{$name}' and `class_id` = '{$class_id}' and `id` != '{$id}' ");
            $sql = "UPDATE `students_tbl` set `name` = '{$name}', `class_id` = '{$class_id}' where `id` = '{$id}'";
        }else{
            
            $check = $this->conn->query("SELECT id FROM `students_tbl` where `name` = '{$name}' and `class_id` = '{$class_id}' ");
            $sql = "INSERT `students_tbl` set `name` = '{$name}', `class_id` = '{$class_id}'";
        }
        if($check->num_rows > 0){
            return ['status' => 'error', 'msg' => 'El nombre del estudiante ya existe!'];
        }else{
            $qry = $this->conn->query($sql);
            if($qry){
                if(empty($id)){
                    $_SESSION['flashdata'] = [ 'type' => 'success', 'msg' => "Nuevo estudiante ha sido agregado exitosamente!" ];
                }else{
                    $_SESSION['flashdata'] = [ 'type' => 'success', 'msg' => "¡Los datos del estudiante se han actualizado correctamente!" ];
                }
                return [ 'status' => 'success'];
            }else{
                if(empty($id)){
                    return ['status' => 'error', 'msg' => 'Se produjo un error al guardar al nuevo estudiante.!'];
                }else{
                    return ['status' => 'error', 'msg' => 'Se produjo un error al actualizar los datos del estudiante.!'];
                }
            }
        }
        
    }
    public function delete_student(){
        extract($_POST);
        $delete = $this->conn->query("DELETE FROM `students_tbl` where `id` = '{$id}'");
        if($delete){
            $_SESSION['flashdata'] = [ 'type' => 'success', 'msg' => "El estudiante ha sido eliminado exitosamente!" ];
            return [ "status" => "success" ];
        }else{
            $_SESSION['flashdata'] = [ 'type' => 'danger', 'msg' => "El estudiante no pudo eliminar debido a una razón desconocida!" ];
            return [ "status" => "error", "El estudiante no se ha podido eliminar!" ];
        }
    }
    public function list_student(){
        $sql = "SELECT `students_tbl`.*, `class_tbl`.`name` as `class` FROM `students_tbl` inner join `class_tbl` on `students_tbl`.`class_id` = `class_tbl`.`id` order by `students_tbl`.`name` ASC";
        $qry = $this->conn->query($sql);
        return $qry->fetch_all(MYSQLI_ASSOC);
    }
    public function get_student($id=""){
        $sql = "SELECT `students_tbl`.*, `class_tbl`.`name` as `class` FROM `students_tbl` inner join `class_tbl` on `students_tbl`.`class_id` = `class_tbl`.`id` where `students_tbl`.`id` = '{$id}'";
        $qry = $this->conn->query($sql);
        $result = $qry->fetch_assoc();
        return $result;
    }
    public function attendanceStudents($class_id = "", $class_date = ""){
        if(empty($class_id) || empty($class_date))
            return [];
        $sql = "SELECT `students_tbl`.*, COALESCE((SELECT `status` FROM `attendance_tbl` where `student_id` = `students_tbl`.id and `class_date` = '{$class_date}' ), 0) as `status` FROM `students_tbl` where `class_id` = '{$class_id}' order by `name` ASC";
        $qry = $this->conn->query($sql);
        $result = $qry->fetch_all(MYSQLI_ASSOC);
        return $result;
    }
    
    public function attendanceStudentsMonthly($class_id = "", $class_month = ""){
        if(empty($class_id) || empty($class_month))
            return [];
        $sql = "SELECT `students_tbl`.* FROM `students_tbl` where `class_id` = '{$class_id}' order by `name` ASC";
        $qry = $this->conn->query($sql);
        $result = $qry->fetch_all(MYSQLI_ASSOC);
        foreach($result as $k => $row){
            $att_sql = "SELECT `status`, `class_date` FROM `attendance_tbl` where `student_id` = '{$row['id']}' ";
            $att_qry = $this->conn->query($att_sql);
            foreach($att_qry as $att_row){
                $result[$k]['attendance'][$att_row['class_date']] = $att_row['status'];
            }
        }
        return $result;
    }
    public function save_attendance(){
        extract($_POST);

        $sql_values = "";
        $errors = "";
        foreach($student_id as $k => $sid){
            $stat = $status[$k] ?? 3;

            $check = $this->conn->query("SELECT id FROM `attendance_tbl` where `student_id` = '{$sid}' and `class_date` = '{$class_date}'");
            if($check->num_rows > 0){
                
                $result = $check->fetch_assoc();
                $att_id = $result['id'];

                try{
                    $update = $this->conn->query("UPDATE `attendance_tbl` set `status` = '{$stat}' where `id` = '{$att_id}'");

                }catch(Exception $e){
                    if(!empty($errors)) $errors .= "<br>";
                    $errors .= $e->getMessage();
                }
               
            }else{
                if(!empty($sql_values)) $sql_values .= ", ";
                $sql_values .= "( '{$sid}', '{$class_date}', '{$stat}' )";
            }
        }
        if(!empty($sql_values))
        {
            try{
                $sql =  $this->conn->query("INSERT INTO `attendance_tbl` ( `student_id`, `class_date`, `status` ) VALUES {$sql_values}");
            }catch(Exception $e){
                if(!empty($errors)) $errors .= "<br>";
                $errors .= $e->getMessage();
            }
        }
        if(empty($errors)){
            $resp['status'] = "success";
            $_SESSION['flashdata'] = [ "type" => "success", "msg" => "Los datos de asistencia al curso se han guardado correctamente." ];
        }else{
            $resp['status'] = "error";
            $resp['msg'] = $errors;
        }

        return $resp;
    }
    
    function __destruct()
    {
        if($this->conn)
        $this->conn->close(); 
    }
    public function list_student_by_course($course_id) {
        $stmt = $this->conn->prepare("SELECT s.id, s.name, c.name as class 
           FROM students_tbl s
           JOIN class_tbl c ON s.class_id = c.id
           WHERE s.class_id = ?");
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    public function list_class_by_id($course_id) {
        $stmt = $this->conn->prepare("SELECT id, name FROM class_tbl WHERE id = ?");
        $stmt->bind_param("i", $course_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
