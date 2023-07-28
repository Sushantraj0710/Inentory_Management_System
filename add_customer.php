<?php 
include 'dbconn.php';

if(isset($_POST['submit'])){
    $name = $_POST['name'];
    $mobile = $_POST['mobile'];
    $balance = $_POST['balance'];
    $saleinvoice = $_POST['saleinvoiceno'];
    
    $sql = "insert into `sale_mstr` (customer_name,number,invoice_no,totalamount)
    values('$name',$mobile,$saleinvoice,$balance)";
    $result = mysqli_query($connection, $sql);
    if($result){
        // echo "Data Inserted Successfully";
        header('location:customer_display.php');
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
    <title>Add Sales</title>
    <!-- using bootstrap css file -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css"> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <h1 class="my-5">Add New Sales </h1>
        <form method="POST" autocomplete="off" class="was-validate" novalidate>
            <div class="form-group my-5">
                <label for="Name">Name</label>
                <input type="text" required class="form-control" id="name" aria-describedby="name" placeholder="Name" name="name">

                <div class="form-group my-3">
                    <label for="Mobile">Mobile</label>
                    <input type="text" class="form-control" id="mobile" placeholder="Mobile" name="mobile">
                </div>
                <div class="form-group">
                    <label for="Balance">Total Amount</label>
                    <input type="text" class="form-control" id="balance" placeholder="Total Amount" name="balance">
                </div>
                <div class="form-group">
                    <label for="invoice">Invoice</label>
                    <input type="text" class="form-control" id="saleinvoiceno" placeholder="Invoice Number" name="saleinvoiceno">
                </div>
                <button type="submit" class="btn btn-primary" name="submit">Add</button>
        </form>
    </div>
</body>

</html>