<?php 
include 'headder.php';
?>
        <div class="container">
            <div class="text-heading my-4">
                <h2>Stock List</h2>
                <a href="./add_unit.php" class="text-light"><button class="btn btn-primary my-2" >Add Stocks</button></a>
            </div>
            <div class="table-content">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Item</th>
                        <th scope="col">Brand</th>
                        <th scope="col">Stock Value</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $sql = "SELECT DISTINCT sm.id, im.item_name, bm.brand_name, sm.stock_val, sm.status FROM stock_mstr sm, item_mstr im, brand_mstr bm 
                        WHERE sm.status = 1 AND sm.Item_code = im.item_code AND sm.brand_id = bm.id ORDER BY im.item_name ASC";
                        $result = mysqli_query($connection,$sql);
                        if($result){
                          while($row = mysqli_fetch_assoc($result)){
                            $id = $row['id'];
                            $itemname= $row['item_name'];
                            $brandname = $row['brand_name'];
                            $stockval = $row['stock_val'];
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
                              <td>'.$brandname.'</td>
                              <td>'.$stockval.'</td>
                              <td>'.$pstatus.'</td>
                              <td>
                                <a href="edit_stock_display.php?edit='.$id.'" class="text-light"><button class="btn btn-primary">Edit</button></a>
                                <a href="delete_stock_details.php?delete='.$id.'" class="text-light"><button class="btn btn-danger">Delete</button></a>
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