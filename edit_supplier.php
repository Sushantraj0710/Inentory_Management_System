<?php 
include 'dbconn.php';
$editid = $_GET['edit'];
$sql = "select * from `supplier_mstr` where id = $editid";
$result = mysqli_query($connection,$sql);
$row = mysqli_fetch_assoc($result);
$name =$row['supplier_name'];
$mobile =$row['mobile_no'];
$address =$row['address'];

if(isset($_POST['submit'])){
    $name= $_POST['suppliername'];
    $mobile= $_POST['mobile'];
    $address= $_POST['address'];

    
    $sql = "update `supplier_mstr` set supplier_name = '$name', mobile_no = $mobile, address = '$address', datetime = CURRENT_TIMESTAMP() where id = $editid";
    $result = mysqli_query($connection, $sql);
    if($result){
        // echo "Data Inserted Successfully";
        header('location:supplier_display.php');
    }
    else{
        die(mysqli_error($connection));
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Supplier</title>
    <!-- using bootstrap css file -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"> 
</head>

<body>
    <div class="container">
        <h1 class="my-5">Edit Supplier </h1>
        <form method="POST" autocomplete="off" class="was-validate" novalidate>
            <div class="form-group">
                <label for="Name">Suppleir Name</label>
                <input type="text" required class="form-control" id="suppliername" aria-describedby="suppliername" placeholder="Supplier Name" name="suppliername" value="<?php echo $name; ?>">
            </div>
            <div class="form-group">
                <label for="Name">Mobile</label>
                <input type="text" required class="form-control" id="mobile" aria-describedby="mobile" placeholder="Mobile" name="mobile" value="<?php echo $mobile; ?>">
            </div>
            <div class="form-group">
                <label for="Name">Address</label>
                <input type="text" required class="form-control" id="address" aria-describedby="address" placeholder="Address" name="address" value="<?php echo $address; ?>">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Save</button>
        </form>
    </div>
</body>

</html>