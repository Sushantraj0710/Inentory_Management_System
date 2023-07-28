<?php
    include 'dbconn.php';
    
    if(isset($_GET['delete'])){
        $id = $_GET['delete'];

        $sql = "UPDATE `purchase_details` SET `status` = 0 WHERE `purchase_details`.`id` = $id";
        $result = mysqli_query($connection,$sql);
        if($result){
            header('location:purchase_details_display.php');
        }
        else{
            die(mysqli_error($connection));
        }
    }
?>
