<?php
include 'dbconn.php';
$editid  =$_GET['edit'];
$sql = "SELECT * FROM `item_mstr` WHERE id = $editid";
$result = mysqli_query($connection,$sql);
$row = mysqli_fetch_assoc($result);
$itemname = $row['item_name'];
$itemcode = $row['item_code'];
$price = $row['price'];
$unitid = $row['unit_id'];
$brandid = $row['brand_id'];


//for select option brom another table 
$sqlunit = "SELECT * FROM `unit_mstr` WHERE `status` = 1";
$sqlbrand = "SELECT * FROM `brand_mstr` WHERE `status` = 1";
// $brandunitsql = "SELECT unit.unit_type, brand.brand_name from item_mstr item, brand_mstr brand, unit_mstr unit WHERE item.unit_id = unit.id AND item.brand_id = brand.id AND item.status = 1 AND item.id = $editid";
$brandunitsql = "SELECT unit.unit_type,unit.id AS unitid, brand.id AS brandid,brand.brand_name from item_mstr item, brand_mstr brand, unit_mstr unit WHERE item.unit_id = unit.id AND item.brand_id = brand.id AND item.status = 1 AND item.id = $editid;";
$brandunit =  mysqli_query($connection, $brandunitsql);
$brandunitrow = mysqli_fetch_assoc($brandunit);
$allunit = mysqli_query($connection, $sqlunit);
$allbrand = mysqli_query($connection, $sqlbrand);


if (isset($_POST['submit'])) {
    $itemname = $_POST['itemname'];
    $itemcode = $_POST['itemcode'];
    $price = $_POST['itemprice'];
    $unitid = $_POST['unitid'];
    $brandid = $_POST['brandid'];


    $sql = "update `item_mstr` set item_name = '$itemname', item_code = $itemcode, price = $price, unit_id = $unitid, brand_id = $brandid, datetime = CURRENT_TIMESTAMP() where id = $editid";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        // echo "Data Inserted Successfully";
        header('location:item_display.php');
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
    <title>Edit Item</title>
    <!-- using bootstrap css file -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1 class="my-5">Edit Item </h1>
        <form method="POST" autocomplete="off" class="was-validate" novalidate>
            <div class="form-group">
                <label for="Name" class="font-weight-bold">Item Name</label>
                <input type="text" required class="form-control" id="itemname" aria-describedby="itemname" placeholder="Item Name" name="itemname" value="<?php echo $itemname;?>">
            </div>
            <div class="form-group">
                <label for="Mobile" class="font-weight-bold">Item Code</label>
                <input type="text" requird class="form-control" id="itemcode" placeholder="Item Code" name="itemcode" value="<?php echo $itemcode;?>">
            </div>
            <div class="form-group">
                <label for="Balance" class="font-weight-bold">Price</label>
                <input type="text" class="form-control" id="itemprice" placeholder="Item Price" name="itemprice" value="<?php echo $price;?>">
            </div>
            <div class="form-group">
                <label for="Balance" class="font-weight-bold">Unit </label>
                <select name="unitid" id="unitid" class="form-control" >
                <!-- <option value="">Select Unit....</option> -->
                <option value="<?php echo $brandunitrow['unitid']; ?>"><?php echo $brandunitrow['unit_type'];?></option>
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
                <select name="brandid" id="brandid" class="form-control">
                    <!-- <option value="">Select Brand....</option>-->
                    <option value="<?php echo $brandunitrow['brandid']; ?>"><?php echo $brandunitrow['brand_name'];?></option>
                    <?php
                    while ($brand = mysqli_fetch_array($allbrand, MYSQLI_ASSOC)) :;
                    ?>
                        <option value="<?php echo $brand['id']; ?>">
                            <?php echo $brand['brand_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>

            </div>
            <button type="submit" class="btn btn-primary" name="submit">Save</button>
        </form>
    </div>
</body>

</html>