<?php
    include 'dbconn.php';

    if(isset($_GET['delete'])){
        $id = $_GET['delete'];
        $sql = "UPDATE `item_mstr` SET `status` = 0 WHERE `item_mstr`.`id` = $id";
        $result = mysqli_query($connection,$sql);
        if($result){
            header('location:item_display.php');
        }
        else{
            die(mysqli_error($connection));
        }
    }
?>