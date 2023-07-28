<?php
    include 'dbconn.php';
    if(!empty($_POST["bi"])){  
        $bi = $_POST['bi'];
        $sql = "SELECT item_name, item_code, price FROM `item_mstr` WHERE brand_id = $bi AND status = 1" ;
        $result = mysqli_query($connection,$sql);
        if($result->num_rows>0){
            echo '<option value "">Select Item</option>';
            while ($row = mysqli_fetch_assoc($result)){
                echo '<option value = "'.$row['item_code'].'">'.$row['item_name'].'</option>';
            }            
        }
        else{
            echo '<option>No Brand Found</option>';
        }
    }   

?>