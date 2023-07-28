<?php
include 'dbconn.php';

$sqlitem = "SELECT DISTINCT item_name, item_code FROM `item_mstr` WHERE `status` = 1";
$allitem = mysqli_query($connection,$sqlitem);
$items = mysqli_fetch_array($allitem, MYSQLI_ASSOC);
$sqlbrand = "SELECT id,brand_name FROM `brand_mstr` WHERE `status` = 1";
$allbrand = mysqli_query($connection,$sqlbrand);
$sqlsale = "SELECT * FROM `sale_mstr` WHERE `status` = 1";
$allsaleid = mysqli_query($connection,$sqlsale);

if (isset($_POST['submit'])) {
    $quantity = $_POST['quantity'];
    $itemcode = $_POST['itemcode'];
    $brandid = $_POST['brandid'];
    $price = $_POST['price'];
    $amount = ($price*$quantity);
    $saleid = $_POST['saleid'];


    // if(empty($name) && empty($mobile) && empty($balance) && empty($saleinvoice)){
    //     echo '<script>alert("Please Enter All The Detials")</script>';
    // }
    // else if(empty($name)){
    //     echo '<script>alert("Please Enter The Name")</script>';
    // }
    // else if(empty($mobile)){
    //     echo '<script>alert("Please Enter The Name")</script>';
    // }
    // else if(empty($saleinvoice)){
    //     echo '<script>alert("Please Enter The Name")</script>';
    // }
    // else{
    //     $sql = "insert into `sale_mstr` (customer_name,number,invoice_no,totalamount)
    //             values('$name',$mobile,$saleinvoice,$balance)";
    //     $result = mysqli_query($connection, $sql);
    //     if($result){
    //         // echo "Data Inserted Successfully";
    //         header('location:customer_display.php');
    //     }
    //     else{
    //         die(mysqli_error($connection));
    //     }
    // }

    $sql = "INSERT INTO `sale_details` (item_code,qty,price,amount,sale_mstr_id)
    values($itemcode,$quantity,$price,$amount,$saleid)";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        // echo "Data Inserted Successfully";
        header('location:customer_detail_display.php');
    } else {
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
        <h1 class="my-5">Add New Sales Detials </h1>
        <form method="POST" autocomplete="off" class="was-validate" novalidate>
            <div class="form-group">
                <label for="Balance" class="font-weight-bold">Item</label>
                <select name="itemcode" id="itemcode" class="form-control" required>
                    <option value="">Select Item...</option>
                    <?php
                    while ($items = mysqli_fetch_array($allitem, MYSQLI_ASSOC)) :;
                    ?>
                        <option value="<?php echo $items['item_code']; ?>">
                            <?php echo $items['item_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div> 
            <div class="form-group">
                <label for="Balance" class="font-weight-bold">Brand</label>
                <select name="brandid" id="brandid" class="form-control" required>
                    <option value="">Select Brand...</option>
                    <?php
                    while ($brands = mysqli_fetch_array($allbrand, MYSQLI_ASSOC)) :;
                    ?>
                        <option value="<?php echo $brands['id']; ?>">
                            <?php echo $brands['brand_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div> 
            <div class="form-group">
                <label for="Balance" class="font-weight-bold">Quantity</label>
                <input type="text" class="form-control" id="quantity" placeholder="Quantity in Number" name="quantity">
            </div>           
            <div class="form-group">
                <label for="Balance" class="font-weight-bold">Price</label>
                <input type="text" class="form-control" id="price" placeholder="Price of the Item" name="price">
            </div>
            <div class="form-group">
                <label for="Balance" class="font-weight-bold">Sale Id</label>
                <select name="saleid" id="saleid" class="form-control" required>
                    <option value="">Select Sale ID</option>
                    <?php
                    while ($sales = mysqli_fetch_array($allsaleid, MYSQLI_ASSOC)) :;
                    ?>
                        <option value="<?php echo $sales['id']; ?>">
                            <?php echo $sales['customer_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div> 
            <button type="submit" class="btn btn-primary" name="submit">Add</button>
        </form>
    </div>
</body>

</html>