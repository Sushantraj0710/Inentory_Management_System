<?php
  include 'headder.php';
?>
        <div class="container">
            <div class="text-heading my-4">
                <h2>Brand List</h2>
                <a href="./add_brand.php" class="text-light"><button class="btn btn-primary my-5" >Add Brand</button></a>
            </div>
            <div class="table-content">
                <table class="table">
                    <thead>
                      <tr>

                        <th scope="col">ID</th> 
                        <th scope="col">Brand Name</th>                        
                        <th scope="col">Date Time</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      // used inner join on table brand_list and category_list
                        $sql = "SELECT * FROM `brand_mstr` WHERE `status` = 1";
                        $result = mysqli_query($connection,$sql);
                        if($result){
                          while($row = mysqli_fetch_assoc($result)){
                            $id = $row['id'];
                            $brandname = $row['brand_name'];
                            $status = $row['status'];
                            $datetime = $row['datetime'];
                            if($status == 1){
                              $pstatus = "active";
                            }
                            else{
                              $pstatus = "deactive";
                            }
                            echo '
                            <tr>
                              <td>'.$id.'</td>
                              <td>'.$brandname.'</td>
                              <td>'.$datetime.'</td>
                              <td>'.$pstatus.'</td>
                              <td>
                                <a href="edit_brand.php?edit='.$id.'" class="text-light"><button class="btn btn-primary">Edit</button></a>
                                <a href="delete_brand.php?delete='.$id.'" class="text-light"><button class="btn btn-danger">Delete</button></a>
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