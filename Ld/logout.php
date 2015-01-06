<?php 
    require_once("../Node/system.class.php");
    $system->logout();
    header("Location:../index.php");
?>