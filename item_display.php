<?php 
include 'headder.php';
?>
        <div class="container">
            <div class="text-heading my-5">
                <h2>Item List</h2>
                <a href="./add_item.php" class="text-light"><button class="btn btn-primary my-5" >Add Items</button></a>
            </div>
            <div class="table-content">
                <table class="table" >
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Item Name</th>
                        <th scope="col">Item Code</th>
                        <th scope="col">Price</th>
                        <th scope="col">Unit Id</th>
                        <th scope="col">Brand Id</th>                        
                        <th scope="col">Date Time</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <td id="table-data">

                    </td>
                    <tbody>
                      <?php
                        // $sql = "SELECT * FROM `item_mstr` WHERE `status` = 1";
                        $sql = "SELECT item.id, item.item_name, item.item_code, item.price, unit.unit_type, brand.brand_name, item.datetime, item.status 
                                from item_mstr item, brand_mstr brand, unit_mstr unit 
                                WHERE item.unit_id = unit.id AND item.brand_id = brand.id AND item.status = 1 ORDER BY item.item_name ASC";
                        $result = mysqli_query($connection,$sql);
                        if($result){
                          while($row = mysqli_fetch_assoc($result)){
                            // $id = $row['id'];
                            // $itemname = $row['item_name'];
                            // $itemcode = $row['item_code'];
                            // $price = $row['price'];
                            // $unitid = $row['unit_id'];
                            // $brandid = $row['brand_id'];
                            // $status = $row['status'];
                            // $datetime = $row['datetime'];
                            $id = $row['id'];
                            $itemname = $row['item_name'];
                            $itemcode = $row['item_code'];
                            $price = $row['price'];
                            $unittype = $row['unit_type'];
                            $brandname = $row['brand_name'];
                            $datetime = $row['datetime'];
                            $status = $row['status'];
                            if($status == 1){
                                $pstatus  = "active";
                            }
                            else{
                              $pstatus = "deactive";
                            }
                            echo '
                            <tr>
                              <td>'.$id.'</td>
                              <td>'.$itemname.'</td>
                              <td>'.$itemcode.'</td>
                              <td>'.$price.'</td>
                              <td>'.$unittype.'</td>
                              <td>'.$brandname.'</td>
                              <td>'.$datetime.'</td>
                              <td>'.$pstatus.'</td>
                              <td>
                                <a href="edit_item.php?edit='.$id.'" class="text-light"><button class="btn btn-primary">Edit</button></a>
                                <a href="delete_item.php?delete='.$id.'" class="text-light"><button class="btn btn-danger">Delete</button></a>
                              </td>
                            </tr>';
                          }
                        }
                      ?>
                    </tbody>
                  </table>
            </div>
        </div>
    </div>  
</body>
</html>