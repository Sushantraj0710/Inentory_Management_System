<?php 
$connection = new mysqli('localhost','root','','new_inventory');
// check for the connections
if(!$connection){
    // echo "Database Connected";
    die(mysqli_error($connection));
}
?>