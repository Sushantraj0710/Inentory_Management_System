<?php 
include 'dbconn.php';


if(isset($_POST['submit'])){
    $brandname = $_POST['brandname'];
    $sql = "insert into `brand_mstr` (brand_name)
    values('$brandname')";
    $result = mysqli_query($connection, $sql);
    if($result){
        // echo "Data Inserted Successfully";
        // echo '<script>alert("Brand added successfully)</script>';
        header('location:brand_display.php');
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
    <title>Add Brand </title>
    <!-- using bootstrap css file -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"> 
</head>

<body>
    <div class="container">
        <h1 class="my-5">Add New Brand </h1>
        <form method="POST" autocomplete="off" class="was-validate" novalidate>
            <div class="form-group">
                <label for="brandnam">Brand Name</label>
                <input type="text" required class="form-control" id="brandname" aria-describedby="brandname" placeholder="Enter Brand Name" name="brandname">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Save</button>
        </form>
    </div>
</body>

</html>