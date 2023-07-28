<?php 
include 'headder.php';
?>
        <div class="container">
            <div class="text-heading my-5">
                <h2>Sales Details List</h2>
                <!-- <a href="./add_customer_detail.php" class="text-light"><button class="btn btn-primary my-5" >Add Sales Details</button></a> -->
            </div>
            <div class="table-content">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Item</th> <!--item name should be display -->
                        <!-- <th scope="col">Brand</th> -->
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Sale Id</th> <!--sale invoice no should be display -->
                        <th scope="col">Date Time</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        // $sql = "SELECT sale_details.id, sale_details.brand_id,brand_mstr.brand_name,item_mstr.item_name, sale_details.qty, sale_details.price, sale_details.amount, sale_mstr.customer_name, sale_details.datetime, sale_details.status FROM sale_details 
                        // INNER JOIN sale_mstr
                        // on sale_details.sale_mstr_id = sale_mstr.id
                        // INNER JOIN item_mstr
                        // ON  sale_details.item_code = item_mstr.item_code 
                        // INNER JOIN brand_mstr
                        // ON  sale_details.brand_id = brand_mstr.id 
                        // WHERE sale_details.status = 1 AND sale_details.item_code = item_mstr.item_code AND sale_details.brand_id = item_mstr.brand_id ORDER BY datetime DESC";
                        $sql = "SELECT DISTINCT sale_details.id, sale_details.id, sale_details.brand_id,brand_mstr.brand_name,item_mstr.item_name, sale_details.qty, sale_details.price, sale_details.amount, sale_mstr.customer_name, sale_details.datetime, sale_details.status FROM sale_details 
                        INNER JOIN sale_mstr
                        on sale_details.sale_mstr_id = sale_mstr.id
                        INNER JOIN item_mstr
                        ON  sale_details.item_code = item_mstr.item_code 
                        INNER JOIN brand_mstr
                        ON  sale_details.brand_id = brand_mstr.id 
                        WHERE sale_details.status = 1 AND sale_details.item_code = item_mstr.item_code AND sale_details.brand_id = item_mstr.brand_id ORDER BY datetime DESC";
                        // -- WHERE sale_details.status = 1 AND sale_details.brand_id = item_mstr.brand_id";
                        // -- // $sql = "SELECT * FROM `sale_details` WHERE status = 1";
                        $result = mysqli_query($connection,$sql);
                        if($result){
                          while($row = mysqli_fetch_assoc($result)){
                            $id = $row['id'];
                            $itemname = $row['item_name'];
                            // $itemcode = $row['item_code'];
                            $brandid = $row['brand_id'];
                            $brandname = $row['brand_name'];
                            $quantity = $row['qty'];
                            $price = $row['price']; 
                            $amount = $row['amount'];
                            $customername = $row['customer_name'];
                            $datetime = $row['datetime'];
                            $status = $row['status'];
                            if($status == 1){
                              $pstatus = "active";
                            }
                            else{
                              $pstatus ="deactive";
                            }
                            echo '
                            <tr>
                              <td>'.$id.'</td>
                              <td>'.$brandname.' '.$itemname.'</td>
                              <td>'.$quantity.'</td>
                              <td>'.$price.'</td>
                              <td>'.$amount.'</td>
                              <td>'.$customername.'</td>
                              <td>'.$datetime.'</td>
                              <td>'.$pstatus.'</td>
                              <td>
                                <a href="edit_customer_detail.php?edit='.$id.'" class="text-light"><button class="btn btn-primary">Edit</button></a>
                                <a href="delete_customer_detail.php?delete='.$id.'" class="text-light"><button class="btn btn-danger">Delete</button></a>
                                
                              </td>
                            </tr>';
                          }
                        }
                      ?>
                    </tbody>
                  </table>
                  <!-- <?php //echo mysqli_num_rows($result); ?> -->
            </div>
        </div>
    </div>    
</body>
</html>