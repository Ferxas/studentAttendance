<?php
   session_start();
   session_unset(); // delete all variables of session
   session_destroy(); // destroy session
   header("Location: login.php"); // redirect
   exit();
?>