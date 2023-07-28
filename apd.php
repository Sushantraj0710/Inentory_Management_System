<?php
include 'dbconn.php';

$sqlitem = "SELECT DISTINCT item_name, item_code FROM `item_mstr` WHERE `status` = 1";
$allitem = mysqli_query($connection,$sqlitem);
$items = mysqli_fetch_array($allitem, MYSQLI_ASSOC);
$sqlbrand = "SELECT id,brand_name FROM `brand_mstr` WHERE `status` = 1";
$allbrands = mysqli_query($connection,$sqlbrand);
$sqlpurchase = "SELECT * FROM `purchase_mstr` WHERE `status` = 1";
$allpurchaseid = mysqli_query($connection,$sqlpurchase);

if (isset($_POST['submit'])) {
    $quantity = $_POST['quantity'];
    $itemcode = $_POST['itemcode'];
    $brandid = $_POST['brandid'];
    $price = $_POST['price'];
    $amount = ($price*$quantity);
    $purchaseid = $_POST['purchaseid'];

    // echo 'Selected Brand: '.$_POST['brand_name']; 


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

    $sql = "INSERT INTO `purchase_details` (item_code,brand_id,quantity,price,amount,purchase_master_id)
    values($itemcode,$brandid,$quantity,$price,$amount,$purchaseid)";
    $sql2 = "UPDATE stock_mstr SET stock_val = stock_val+$quantity WHERE Item_code = $itemcode AND brand_id = $brandid AND status = 1";
    $result = mysqli_query($connection, $sql);
    $result2 = mysqli_query($connection, $sql2);

    if ($result && $result2) {
        // echo "Data Inserted Successfully";
        header('location:purchase_details_display.php');
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
    <title>Add Purchase</title>
    <!-- using bootstrap css file -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
</head>

<body>
    <div class="container">
        <h1 class="my-5">Add New Purchase Detials </h1>
        <form method="POST" autocomplete="off" class="was-validate" novalidate>
            <!-- <div class="form-group">
                <label for="Balance" class="font-weight-bold">Brand</label>
                <input type="text" list="datalistbrandname" class="form-control" id="brandid" aria-describedby="brandid" placeholder="Brand Name" name="brandid" required>
                <datalist name="brandid" id="datalistbrandname"> 
                <option  value="">Select brand...</option>
                    <?php
                    // while ($brands = mysqli_fetch_array($allbrands, MYSQLI_ASSOC)) :;
                    ?>
                        <option value="<?php 
                        // echo $brands['id']; ?>">
                            <?php 
                            // echo $brands['brand_name']; ?>
                        </option>
                    <?php 
                // endwhile; ?>
                </datalist>
                </select>
            </div>  -->
            <!-- Brand -->
            <div class="form-group">
                <label for="Balance" class="font-weight-bold">Brand</label>
                <input type="text" list="datalistbrandname" class="form-control" id="brandid" aria-describedby="brandid" placeholder="Brand Name" name="brandid" required>
                <datalist name="brandid" id="datalistbrandname"> 
                <option  value="">Select brand...</option>
                    <?php
                    while ($brands = mysqli_fetch_array($allbrands, MYSQLI_ASSOC)) :;
                    ?>
                        <option value="<?php echo $brands['id']; ?>">
                            <?php echo $brands['brand_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </datalist>
                </select>
            </div> 
            <!-- Item -->
            <div class="form-group">
                <label for="item" class="font-weight-bold">Item</label>
                <!-- <input type="text" list ="datalistitemname" class="form-control" id="itemcode" aria-describedby="itemcode" placeholder="Item Name" name="itemcode" required> -->
                <select  class ="form-control" name="itemcode" id="itemcode" required>
                    <option value="">Select Item</option>
                </select>
            </div>     
            <!-- original price input box        -->
            <!-- <div class="form-group">
                <label for="Balance" class="font-weight-bold">Price</label>
                <input type="text" class="form-control" id="price" placeholder="Price of the Item" name="price">
            </div> -->
            <!-- Price` -->
            <div class="form-group">
                <label for="price" class="font-weight-bold">Price</label>
                <input type="text" name="price" id="price" class="form-control price" placeholder="Price" readonly="readonly">
                
            </div>
            <!-- Quantity -->
            <div class="form-group">
                <label for="Balance" class="font-weight-bold">Quantity</label>
                <input type="text" class="form-control quantity" id="quantity" placeholder="Quantity in Number" name="quantity" >
            </div>
            <!-- Calculate Total Amount  -->

            <div class="form-group">
                <label for="Balance" class="font-weight-bold">Purchase Id</label>
                <select name="purchaseid" id="purchaseid" class="form-control" required>
                    <option value="">Select Purchase Invoice Number</option>
                    <?php
                    while ($purchases = mysqli_fetch_array($allpurchaseid, MYSQLI_ASSOC)) :;
                    ?>
                        <option value="<?php echo $purchases['id']; ?>">
                            <?php echo $purchases['invoice_no']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div> 
            <button type="submit" class="btn btn-primary" name="submit">Save</button>
        </form>
    </div>
    <!-- <?php
        //$sql2 = "SELECT * from item_mstr WHERE item_code = 4008 AND brand_id = 5 AND status = 1" ;
        //$result2 = mysqli_query($connection,$sql2);
        //$row = mysqli_fetch_assoc($result2);
        //echo mysqli_num_rows($result2)."/".$row['price'];
    ?> -->


</body>
<script>
    $(document).ready(function(){
        $('#brandid').on('change', function(){
            var brandId = $(this).val();
            $.ajax({
                method:"POST",
                url:"response2.php",
                data:{
                    bi: brandId
                },
                datatype:'html',
                success:function(data){
                    $('#itemcode').html(data);
                    
                }
            });
        });

        $('#itemcode').on('change', function(){
            var itemCode = $(this).val();
            var brandid = $('#brandid').val();
            $.ajax({
                method:"POST",
                url:"price.php",
                data:{
                    ic: itemCode, bi: brandid,
                },
                datatype:'html',
                success:function(data){
                    let price = data.slice(2,-2);
                    $('#price').val(price);   
                }
            });
        })

    });
</script>

</html>