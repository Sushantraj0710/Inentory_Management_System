<?php
    include 'dbconn.php';
    // $itemcode = $_POST['itemCode'];
    //if(isset($_POST['itemcode'])){
        //$itemCode =  $_POST['itemcode'];
        // $slq = "SELECT item.item_name,item.price, item.brand_id, brand.brand_name FROM item_mstr item
        // INNER JOIN brand_mstr brand
        // ON item.brand_id = brand.id
        // WHERE item.item_code =".$itemCode."AND brand.status = 1";
        //$sql = SELECT brand_mstr.id, brand_mstr.brand_name FROM brand_mstr, item_mstr WHERE  item_mstr.item_code = 4008 AND item_mstr.brand_id = brand_mstr.id AND brand_mstr.status = 1;
        //$sql = "SELECT brand.brand_name,brand.id, item.price FROM brand_mstr brand, item_mstr item
      //  WHERE item.item_code =".$itemCode." AND item.brand_id = brand.id AND brand.status = 1" ;
        // $result = $db->querry($slq);
      //  $result = mysqli_query($connection,$sql);
        // $row= mysqli_fetch_assoc($result);
       // while(true){
           //$row = mysqli_fetch_array($result,MYSQLI_ASSOC);
           // $brandid = $row['id'];
          //  $brandname = $row['brand_name'];
           // echo "<option value='".$brandid."'>".$brandname."</option>";

       // }
        //generating html of brand state option list
   //}
    // else{
    //     // echo '<option value="">Brand not available</option>';
    //     echo "Not selection";

    // }
    // else if(!empty($_POST["brandid"])){
    //     $slq = "SELECT item.item_name, item.price, brand.brand_name, brand.id FROM item_mstr item, brand_mstr brand
    //     WHERE item.item_code =".$_POST['item_code']." AND brand.id = item.brand_id";
    //     $result = mysqli_query($connection,$sql);
    //     $row = mysqli_fetch_assoc($result);
    //     if($result-> num_row>0){
    //         echo 'value ="'.$row['price'].'"';
    //     }
    // }




?>