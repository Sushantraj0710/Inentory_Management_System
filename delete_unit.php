<?php
    include 'dbconn.php';
    
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];

        $sql = "UPDATE `unit_mstr` SET `status` = 0 WHERE `unit_mstr`.`id` = $id";
        $result = mysqli_query($connection,$sql);
        if($result){
            header('location:unit_display.php');
        }
        else{
            die(mysqli_error($connection));
        }
    }
?>
