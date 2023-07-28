<?php 
include 'dbconn.php';

if(isset($_POST['submit'])){
    $unit= $_POST['unittype'];

    
    $sql = "insert into `unit_mstr` (unit_type)
    values('$unit')";
    $result = mysqli_query($connection, $sql);
    if($result){
        // echo "Data Inserted Successfully";
        header('location:unit_display.php');
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
    <title>Add Unit</title>
    <!-- using bootstrap css file -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"> 
</head>

<body>
    <div class="container">
        <h1 class="my-5">Add New Unit </h1>
        <form method="POST" autocomplete="off" class="was-validate" novalidate>
            <div class="form-group my-5">
                <label for="Name">Unit Type</label>
                <input type="text" required class="form-control" id="unittype" aria-describedby="unittype" placeholder="Unit Type" name="unittype">
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Save</button>
        </form>
    </div>
</body>

</html>