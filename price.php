<?php
    include 'dbconn.php';

    if(isset($_POST["ic"]) && isset($_POST["bi"])){ 
        $ic = $_POST['ic'];
        $bi = $_POST['bi'];
        $sql2 = "SELECT price FROM `item_mstr` WHERE  item_code = $ic AND brand_id = $bi" ;
        $result2 = mysqli_query($connection,$sql2);
        $res=mysqli_fetch_row($result2);
        // print_r($res);
        // print_r($ic);
        // print_r($bi);
        echo json_encode($res);
    }
?>
