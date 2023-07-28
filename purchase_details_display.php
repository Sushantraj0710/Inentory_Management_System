<?php 
include 'headder.php';
?>
        <div class="container">
            <div class="text-heading my-5">
                <h2>Purchase Detials</h2>
                <!-- <a href="./add_purchase_details.php" class="text-light"><button class="btn btn-primary my-5" >Add Purchase</button></a> -->
                <a href="./apd.php" class="text-light"><button class="btn btn-primary my-5" >Add Purchase</button></a>
            </div>
            <div class="table-content">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Item</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Price</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Purchase Invoice</th>
                        <th scope="col">Date Time</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        // $sql = "SELECT * FROM `purchase_details` WHERE `status` = 1";
                        // $sql = "SELECT purchase_details.id, item_mstr.item_name, purchase_details.quantity, purchase_details.price, purchase_details.amount, purchase_mstr.invoice_no, purchase_details.datetime, purchase_details.status FROM purchase_details
                        // INNER JOIN purchase_mstr
                        // ON purchase_details.purchase_master_id = purchase_mstr.id
                        // INNER JOIN item_mstr
                        // ON item_mstr.item_code = purchase_details.item_code
                        // WHERE purchase_details.status = 1 AND purchase_details.brand_id = item_mstr.brand_id";
                        $sql = "SELECT purchase_details.id, item_mstr.item_name, brand_mstr.brand_name,purchase_details.quantity, purchase_details.price, purchase_details.amount, purchase_mstr.invoice_no, purchase_details.datetime, purchase_details.status FROM purchase_details
                        INNER JOIN purchase_mstr
                        ON purchase_details.purchase_master_id = purchase_mstr.id
                        INNER JOIN item_mstr
                        ON item_mstr.item_code = purchase_details.item_code
                        INNER JOIN brand_mstr
                        ON item_mstr.brand_id = brand_mstr.id
                        WHERE purchase_details.status = 1 AND purchase_details.brand_id = item_mstr.brand_id";
                        $result = mysqli_query($connection,$sql);
                        if($result){
                          while($row = mysqli_fetch_assoc($result)){
                            $id = $row['id'];
                            $itemname = $row['item_name'];
                            $brandname = $row['brand_name'];
                            $quantity = $row['quantity'];
                            $price = $row['price'];
                            $amount = $row['amount'];
                            $purchaseMasterInvoice = $row['invoice_no'];
                            $datetime = $row['datetime'];
                            $status = $row['status'];
                            if($status == 1){
                              $pstatus = "active";
                            }
                            else{
                              $pstatus = "deactive";
                            }
                            echo '
                            <tr>
                              <td>'.$id.'</td>
                              <td>'.$brandname.' '.$itemname.'</td>
                              <td>'.$quantity.'</td>
                              <td>'.$price.'</td>
                              <td>'.$amount.'</td>
                              <td>'.$purchaseMasterInvoice.'</td>
                              <td>'.$datetime.'</td>
                              <td>'.$pstatus.'</td>
                              <td>
                                <a href="edit_purchase_details_display.php?edit='.$id.'" class="text-light"><button class="btn btn-primary">Edit</button></a>
                                <a href="delete_purchase_details.php?delete='.$id.'" class="text-light"><button class="btn btn-danger">Delete</button></a>
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