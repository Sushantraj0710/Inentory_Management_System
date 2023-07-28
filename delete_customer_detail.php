<?php
    include 'dbconn.php';
    
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];

        $sql = "UPDATE `sale_details` SET `status` = 0 WHERE `sale_details`.`id` = $id";
        $result = mysqli_query($connection,$sql);
        if($result){
            header('location:customer_detail_display.php');
        }
        else{
            die(mysqli_error($connection));
        }
    }
?>
