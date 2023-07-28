<?php

use LDAP\Result;

    include 'dbconn.php';
    if(!empty($_POST["ic"])){  
        $ic = $_POST['ic'];
        $sql = "SELECT item_mstr.item_name, item_mstr.item_code,item_mstr.brand_id, brand_mstr.brand_name, item_mstr.price FROM item_mstr, brand_mstr WHERE item_mstr.item_code = $ic AND item_mstr.brand_id = brand_mstr.id ORDER BY brand_mstr.brand_name ASC" ;
        $result = mysqli_query($connection,$sql);
        if($result->num_rows>0){
            echo '<option value "">Select Brand...</option>';
            while ($row = mysqli_fetch_assoc($result)){
                echo '<option value = "'.$row['brand_id'].'">'.$row['brand_name'].'</option>';

            }
        }
        else{
            echo '<option>No Brand Found</option>';
        }
    }
    if(!empty($_POST["brandid"]) && !empty($_POST["itemcode"])){  
        $bi = $_POST['brandid'];
        $ic = $_POST['itemcode'];
        // $sql2 = "SELECT * FROM item_mstr WHERE item_code = $ic AND brand_id = $bi AND status = 1" ;
        $sql2 = "SELECT price FROM `item_mstr` WHERE  item_code = $ic AND brand_id = $bi" ;
        $result2 = mysqli_query($connection,$sql2);
        $res=mysqli_fetch_array($result2);
        // $res=mysqli_fetch_row($result2);
        $price = $res['price'];
        echo $price;
        // echo json_encode($res);

    }
    if(!empty($_POST['qty']) && !empty($_POST['brand']) && !empty($_POST['item'])){
        $qty = $_POST['qty'];
        $brand = $_POST['brand'];
        $item = $_POST['item'];
        $sql3 = "SELECT stock_val from stock_mstr WHERE Item_code = $item AND brand_id = $brand AND status = 1";
        $result3 = mysqli_query($connection,$sql3);
        $res3 = mysqli_fetch_array($result3); 
        $stval = $res3['stock_val'];
        // echo json_encode($res3);
        echo $stval;
        

    }
?>