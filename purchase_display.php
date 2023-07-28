<?php 
include 'headder.php';
?>
        <div class="container">
            <div class="text-heading my-5">
                <h2>Purchase List</h2>
                <a href="./add_purchase.php" class="text-light"><button class="btn btn-primary my-5" >Add Purchase</button></a>
            </div>
            <div class="table-content">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Invoice No</th>
                        <th scope="col">Invoice Date</th>
                        <th scope="col">Supplier</th>
                        <th scope="col">Total Amount</th>
                        <th scope="col">Date Time</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $sql ="SELECT purchase_mstr.id, purchase_mstr.invoice_no, purchase_mstr.invoice_date, purchase_mstr.total_amount,purchase_mstr.datetime,purchase_mstr.status, supplier_mstr.supplier_name FROM purchase_mstr
                        INNER JOIN supplier_mstr
                        ON purchase_mstr.supplier_id = supplier_mstr.id
                        WHERE purchase_mstr.status = 1";
                        $result = mysqli_query($connection,$sql);
                        if($result){
                          while($row = mysqli_fetch_assoc($result)){
                            $id = $row['id'];
                            $invoiceno = $row['invoice_no'];
                            $invoicedate = $row['invoice_date'];
                            $suppliername = $row['supplier_name'];
                            $totalamount = $row['total_amount'];
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
                              <td>'.$invoiceno.'</td>
                              <td>'.$invoicedate.'</td>
                              <td>'.$suppliername.'</td>
                              <td>'.$totalamount.'</td>
                              <td>'.$datetime.'</td>
                              <td>'.$pstatus.'</td>
                              <td>
                                <a href="edit_purchase.php?edit='.$id.'" class="text-light"><button class="btn btn-primary">Edit</button></a>
                                <a href="delete_purchase.php?delete='.$id.'" class="text-light"><button class="btn btn-danger">Delete</button></a>
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