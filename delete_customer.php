<?php
    include 'dbconn.php';
    
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];

        $sql = "UPDATE `sale_mstr` SET `status` = 0 WHERE `sale_mstr`.`id` = $id";
        $result = mysqli_query($connection,$sql);
        if($result){
            header('location:customer_display.php');
        }
        else{
            die(mysqli_error($connection));
        }
    }
?>
