<?php 
include 'headder.php';
?>
        <div class="container">
            <div class="text-heading my-5">
                <h2>Supplier List</h2>
                <a href="./add_supplier.php" class="text-light"><button class="btn btn-primary my-5" >Add Supplier</button></a>
            </div>
            <div class="table-content">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Mobile</th>
                        <th scope="col">Address</th>   
                        <th scope="col">Date Time</th>                        
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $sql = "SELECT * FROM `supplier_mstr` WHERE `status` = 1";
                        $result = mysqli_query($connection,$sql);
                        if($result){
                          while($row = mysqli_fetch_assoc($result)){
                            $id = $row['id'];
                            $name = $row['supplier_name'];
                            $address = $row['address'];
                            $mobile = $row['mobile_no'];
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
                              <td>'.$name.'</td>
                              <td>'.$mobile.'</td>
                              <td>'.$address.'</td>
                              <td>'.$datetime.'</td>
                              <td>'.$pstatus.'</td>
                              <td>
                                <a href="edit_supplier.php?edit='.$id.'" class="text-light"><button class="btn btn-primary">Edit</button></a>
                                <a href="delete_supplier.php?delete='.$id.'" class="text-light"><button class="btn btn-danger">Delete</button></a>
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