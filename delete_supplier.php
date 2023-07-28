<?php
    include 'dbconn.php';
    
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];

        $sql = "UPDATE `supplier_mstr` SET `status` = 0 WHERE `supplier_mstr`.`id` = $id";
        $result = mysqli_query($connection,$sql);
        if($result){
            header('location:supplier_display.php');
        }
        else{
            die(mysqli_error($connection));
        }
    }
?>
