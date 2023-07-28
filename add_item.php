<?php
include 'dbconn.php';

$sqlunit = "SELECT * FROM `unit_mstr` WHERE `status` = 1";
$sqlbrand = "SELECT * FROM `brand_mstr` WHERE `status` = 1";
$allunit = mysqli_query($connection, $sqlunit);
$sqlitem = "SELECT DISTINCT item_name, item_code FROM `item_mstr` WHERE `status` = 1";
$allbrand = mysqli_query($connection, $sqlbrand);
$allitem = mysqli_query($connection,$sqlitem);



if (isset($_POST['submit'])) {
    $itemname = $_POST['itemname'];
    $itemcode = $_POST['itemcode'];
    $price = $_POST['itemprice'];
    $unitid = $_POST['unitid'];
    $brandid = $_POST['brandid'];

    //for form validation v
    if(empty($itemname) && empty($itemcode) && empty($price) && empty($unitid) && empty($brandid)){
        echo '<script>alert("Please Enter All The Detials")</script>';
    }
    else if(empty($itemname)){
        echo '<script>alert("Please enter Item Name")</script>';
    }
    else if(empty($itemcode)){
        echo '<script>alert("Please enter Item code")</script>';
    }
    else if(empty($price)){
        echo '<script>alert("Please enter Price")</script>';
    }
    else if(empty($unitid)){
        echo '<script>alert("Please enter Unit")</script>';
    }
    else if(empty($brandid)){
        echo '<script>alert("Please enter Brnad")</script>';
    }
    else{
        $sql = "insert into `item_mstr` (item_name,item_code,price,unit_id,brand_id)
        values('$itemname',$itemcode,$price,$unitid,$brandid)";
        $result = mysqli_query($connection, $sql);
        $sql2 = "INSERT INTO `stock_mstr` (stock_val,item_code,brand_id) values (0,$itemcode,$brandid)";
        $result2 = mysqli_query($connection, $sql2);
        if ($result && $result2) {
            // echo "Data Inserted Successfully";
            header('location:item_display.php');
        }
        else {
            die(mysqli_error($connection));
        }
    }



    // $sql = "insert into `item_mstr` (item_name,item_code,price,unit_id,brand_id)
    // values('$itemname',$itemcode,$price,$unitid,$brandid)";
    // $result = mysqli_query($connection, $sql);
    // if ($result) {
    //     // echo "Data Inserted Successfully";
    //     header('location:item_display.php');
    // } else {
    //     die(mysqli_error($connection));
    // }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Item</title>
    <!-- using bootstrap css file -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="my-5">Add New Item </h1>
        <form method="POST" autocomplete="off" novalidate>
            <div class="form-group">
                <label for="Name" class="font-weight-bold">Item Name</label>
                <input type="text" list="datalistitemname" class="form-control" id="itemname" aria-describedby="itemname" placeholder="Item Name" name="itemname" required>
                <datalist id="datalistitemname"> 
                <option value="">Select Item...</option>
                    <?php
                    while ($items = mysqli_fetch_array($allitem, MYSQLI_ASSOC)) :;
                    ?>
                        <option value="<?php echo $items['item_name']; ?>">
                            <?php echo $items['item_code']; ?>
                        </option>
                    <?php endwhile; ?>
                </datalist>
            </div>
            <div class="form-group">
                <label for="Mobile" class="font-weight-bold">Item Code</label>
                <input type="text"  class="form-control" id="itemcode" placeholder="Item Code" name="itemcode" required>
            </div>
            <div class="form-group">
                <label for="Balance" class="font-weight-bold">Price</label>
                <input type="text" class="form-control" id="itemprice" placeholder="Item Price" name="itemprice" required>
            </div>
            <div class="form-group">
                <label for="Balance" class="font-weight-bold">Unit </label>
                <select name="unitid" id="unitid" class="form-control" required>
                    <option value="">Select Unit...</option>
                    <?php
                    while ($unit = mysqli_fetch_array($allunit, MYSQLI_ASSOC)) :;
                    ?>
                        <option value="<?php echo $unit['id']; ?>">
                            <?php echo $unit['unit_type']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="Balance" class="font-weight-bold">Brand </label>
                <select name="brandid" id="brandid" class="form-control" required>
                    <option value="">Select Brand...</option>
                    <?php
                    while ($brand = mysqli_fetch_array($allbrand, MYSQLI_ASSOC)) :;
                    ?>
                        <option value="<?php echo $brand['id']; ?>">
                            <?php echo $brand['brand_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>

            </div>
            <button type="submit" class="btn btn-primary" name="submit">Add</button>
        </form>
    </div>
</body>

</html>