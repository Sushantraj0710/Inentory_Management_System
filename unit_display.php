<?php 
include 'headder.php';
?>
        <div class="container">
            <div class="text-heading my-4">
                <h2>Unit List</h2>
                <a href="./add_unit.php" class="text-light"><button class="btn btn-primary my-5" >Add Unit</button></a>
            </div>
            <div class="table-content">
                <table class="table">
                    <thead>
                      <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Unit Type</th>
                        <th scope="col">Date Time</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $sql = "SELECT * FROM `unit_mstr` WHERE `status` = 1";
                        $result = mysqli_query($connection,$sql);
                        if($result){
                          while($row = mysqli_fetch_assoc($result)){
                            $id = $row['id'];
                            $unittype= $row['unit_type'];
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
                              <td>'.$unittype.'</td>
                              <td>'.$datetime.'</td>
                              <td>'.$pstatus.'</td>
                              <td>
                                <a href="edit_unit.php?edit='.$id.'" class="text-light"><button class="btn btn-primary">Edit</button></a>
                                <a href="delete_unit.php?delete='.$id.'" class="text-light"><button class="btn btn-danger">Delete</button></a>
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