<?php 
include 'headder.php';
?>
        <div class="container">
            <div class="text-heading my-5">
                <h2>Sales List</h2>
                 <!-- <a href="./add_customer.php" class="text-light"><button class="btn btn-primary my-5" >Add Sales</button></a> -->
                <a href="./invoice.php" class="text-light"><button class="btn btn-primary my-5" >Add Sales</button></a>
            </div>
            <div class="table-content">
                <table class="table">
                    <thead>
                      <tr>
                        <!-- <th scope="col">Sl No</th> -->
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Invoice No</th>
                        <th scope="col">Invoice Date</th>
                        <th scope="col">Total Amount</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $sql = "SELECT * FROM `sale_mstr` WHERE `status` = 1";
                        // $sql = "SELECT * FROM `sale_mstr` WHERE `status` = 0";
                        $result = mysqli_query($connection,$sql);
                        $slno =1; // to display the serial number wise
                        if($result){
                          while($row = mysqli_fetch_assoc($result)){
                            $id = $row['id'];
                            $name = $row['customer_name'];
                            $mobile = $row['number'];
                            $balance = $row['totalamount'];
                            $status = $row['status'];
                            $invoiceno = $row['invoice_no'];
                            $invoicedate = $row['invoice_date'];
                            $datetime = $row['datetime'];
                            if($status == 1){
                              $pstatus  = "active";
                            }
                            else{
                              $pstatus = "deactive";
                            }
                            echo '
                            <tr>
                              <td>'.$id.'</td>
                              <td>'.$name.'</td>
                              <td>'.$mobile.'</td>
                              <td>'.$invoiceno.'</td>
                              <td>'.$invoicedate.'</td>
                              <td>'.$balance.'</td>
                              <td>'.$datetime.'</td>
                              <td>'.$pstatus.'</td>
                              <td>
                                <a href="./edit_customer222_details.php?edit='.$id.'" class="text-light"><button class="btn btn-primary">Edit</button></a>
                                <a href="./delete_customer.php?delete='.$id.'" class="text-light"><button class="btn btn-danger">Delete</button></a>
                                <a href="print.php?print='.$id.'" class="text-light"><button class="btn btn-success">Print</button></a>
                              </td>
                            </tr>';
                            $slno++;
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