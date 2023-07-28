<?php
    include 'dbconn.php';
    
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];

        $sql = "UPDATE `brand_mstr` SET `status` = 0 WHERE `brand_mstr`.`id` = $id";
        $result = mysqli_query($connection,$sql);
        if($result){
            header('location:brand_display.php');
        }
        else{
            die(mysqli_error($connection));
        }
    }
?>
