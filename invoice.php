<?php
include 'dbconn.php';

$sqlitem = "SELECT DISTINCT item_name, item_code FROM `item_mstr` WHERE `status` = 1";
$allitem = mysqli_query($connection, $sqlitem);

$sqlbrand = "SELECT id, brand_name FROM `brand_mstr` WHERE `status` = 1";
$allbrand = mysqli_query($connection, $sqlbrand);

if (isset($_POST['submit'])) {
    $invoiceno = $_POST['invoice_no'];
    $name = $_POST['cname'];
    $mobile = $_POST['mobile'];
    $totalAmount = $_POST['grand_total'];
    $caddress = $_POST['caddress'];


    $sql = "insert into `sale_mstr` (customer_name,number,customer_address,invoice_no,totalamount)
        values ('$name',$mobile,'$caddress',$invoiceno,$totalAmount)";

    // $result = mysqli_query($connection, $sql);
    // if($result){
    //     header('location:customer_display.php');
    // }
    // else{
    //     die(mysqli_error($connection));
    // }

    // insert the product 
    if ($connection->query($sql)) {
        $saleid = $connection->insert_id;

        $sql2 = "insert into `sale_details` (item_code,brand_id,qty,price,amount,sale_mstr_id) values ";
        $rows = [];

        for ($i = 0; $i < count($_POST["pname"]); $i++) {
            $pname = mysqli_real_escape_string($connection, $_POST['pname'][$i]);
            $brand = mysqli_real_escape_string($connection, $_POST['brand'][$i]);
            $price = mysqli_real_escape_string($connection, $_POST['price'][$i]);
            $qty = mysqli_real_escape_string($connection, $_POST['qty'][$i]);
            $total = mysqli_real_escape_string($connection, $_POST['total'][$i]);
            $rows[] = "('{$pname}','{$brand}','{$qty}','{$price}','{$total}','{$saleid}')";
        }
        $sql2 .= implode(",", $rows);

        for ($i = 0; $i < count($_POST["pname"]); $i++) {
            $pname = mysqli_real_escape_string($connection, $_POST['pname'][$i]);
            $brand = mysqli_real_escape_string($connection, $_POST['brand'][$i]);
            $qty = mysqli_real_escape_string($connection, $_POST['qty'][$i]);
            // $rows[] = "('{$pname}','{$brand}','{$qty}','{$price}','{$total}','{$saleid}')";
            $sql3 = "UPDATE stock_mstr set stock_val = stock_val-$qty WHERE item_code = $pname AND brand_id = $brand";
        }

        if ($connection->query($sql2) && $connection->query($sql3)) {
            header('location:customer_display.php');
        } else {
            die(mysqli_error($connection));
        }
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
    <title>Invoice Form</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.main.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container pt-4">
        <div class="text-heading">
            <h2>Add Sales</h2>
            <hr>
        </div>
        <form method="POST" autocomplete="off">
            <div class="row">
                <div class="col-md-4">
                    <h5 class="text-success">Invoice Details</h5>
                    <div class="form-group">
                        <label for="">Invoice No</label>
                        <input type="text" name="invoice_no" required class="form-control" placeholder="Invoice Numebr">
                    </div>
                    <!-- for date -->
                    <!-- <div class="form-group">
                        <label for="">Invoice Date</label>
                        <input type="text" name="invoice_date" id="date" required class="form-control" placeholder="Invoice Date">
                    </div> -->
                </div>
                <div class="col-md-8">
                    <h5 class="text-success">Customer Details</h5>
                    <div class="form-group">
                        <label for="">Name</label>
                        <input type="text" name="cname" required class="form-control" placeholder="Customer Name">
                    </div>
                    <div class="form-group">
                        <label for="">Address</label>
                        <input type="text" name="caddress" required class="form-control" placeholder="Customer Address">
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile</label>
                        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Customer Mobile Number" maxlength="10" minlength="10" required>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <h5 class="text-success">Product Details</h5>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Brand</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="product_tbody" class="product_tbody">
                            <tr class="tablerow">
                                <td class="itemcodetr">
                                    <input type="text" required name="pname[]" id='itemcode' class="form-control itemcode"  list="datalistitemname" placeholder="Product">
                                    <datalist id="datalistitemname">
                                        <?php
                                        while ($items = mysqli_fetch_array($allitem, MYSQLI_ASSOC)) :;
                                        ?>
                                            <option value="<?php echo $items['item_code']; ?>">
                                                <?php echo $items['item_name']; ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </datalist>
                                </td>
                                <!-- brand -->
                                <td id='selectbrand'>
                                    <select name="brand[]" id="brand" class="form-control brand" required>
                                        <option value="">Select Brand...</option>
                                    </select>
                                </td>
                                <!-- brand copy -->
                                <!-- <td> -->
                                <!-- <input type="text" required name="brand[]" id='brand' class="form-control brand" list="datalistbrandname" placeholder="Brand"> -->
                                <!-- <datalist id="datalistbrandname"> -->
                                <?php
                                // while ($brands = mysqli_fetch_array($allbrand, MYSQLI_ASSOC)) :;
                                ?>
                                <!-- <option value="<?php //echo $brands['id']; 
                                                    ?>"> -->
                                <?php //echo $brands['brand_name']; 
                                ?>
                                <!-- </option> -->
                                <?php //endwhile; 
                                ?>
                                <!-- </datalist> -->
                                <!-- </td> -->

                                <td><input type="text" required name="price[]" class="form-control price" readonly="readonly"></td>
                                <td><input type="text" required name="qty[]" class="form-control qty"></td>
                                <td><input type="text" required name="total[]" class="form-control total"></td>
                                <td><input type="button" value="X" class="btn btn-danger btn-sm btn-row-remove"></td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td><input type="button" value="+ Add Row" class="btn btn-primary btn-sm" id="btn-add-row"></td>
                                <td colspan="3" class="text-right font-weight-bold"> Grand Total</td>
                                <td><input type="text" name="grand_total" id="grand_total" class="form-control" required></td>
                            </tr>
                        </tfoot>
                    </table>
                    <button type="submit" class="btn btn-primary" name="submit">Add</button>
                    <button type="button" id="countrow" class="btn btn-primary" name="count">count</button>
                    <!-- <input type="submit" name="submit" value="Add" class="btn btn-success flat-right"> -->
                </div>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {

            let count = 0;

            $('#date').datepicker({
                dateFormat: "dd-mm-yy"
            });
            // adding new product row
            $('#btn-add-row').click(function(e) {
                e.preventDefault();
                ++count;
                // var row ="<tr><td><input type='text' required name='pname[]' class='form-control'></td><td><input type='text' required name='price[]' class='form-control price'></td><td><input type='text' required name='qyt[]' class='form-control qty'></td><td><input type='text' required name='total[]' class='form-control total'></td><td><input type='button' value='X' class='btn btn-danger btn-sm btn-row-remove'> </td> </tr>";
                var row = "<tr class='tablerow'><td class='itemcodetr'><input type='text' required name='pname[]' id='itemcode' class='form-control itemcode' list='datalistitemname' placeholder='Product'><datalist id='datalistitemname'> <option value=''>Select Item...</option><?php while ($items = mysqli_fetch_array($allitem, MYSQLI_ASSOC)) :; ?> <option value='<?php echo $items['item_code']; ?>'><?php echo $items['item_name']; ?></option><?php endwhile; ?></datalist></td><td id='selectbrand'><select name='brand[]' id='brand' class='form-control brand'><option value=''>Select Brand...</option></select></td><td><input type='text' required name='price[]' id='price' class='form-control price' ></td><td><input type='text' required name='qty[]' class='form-control qty'></td><td><input type='text' required name='total[]' class='form-control total'></td><td><input type='button' value='X' class='btn btn-danger btn-sm btn-row-remove'></td></tr>";
                // $("#product_tbody").append(row);
                $("#product_tbody").append(row);
            });

            $("body").on("click", ".btn-row-remove", function() {
                if (confirm("Are you Sure?")) {
                    $(this).closest("tr").remove();
                    grand_total();
                }
            });

            $("body").on("keyup", ".price", function() {
                var price = Number($(this).val());
                var qty = Number($(this).closest("tr").find(".qty").val());
                $(this).closest("tr").find(".total").val(price * qty);
            });

            $("body").on("keyup", ".qty", function() {
                var qty = Number($(this).val());
                var price = Number($(this).closest("tr").find(".price").val());
                $(this).closest("tr").find(".total").val(price * qty);
                grand_total();
            });

            // $('.tablerow').each(getproduct());

            function grand_total() {
                var tot = 0;
                $(".total").each(function() {
                    tot += Number($(this).val());
                });
                $("#grand_total").val(tot);
            }

            // function getproduct(){
            //     $('.itemcode').on('change',function(){
            //     var itemCode = $(this).val();
            //     alert("item code is "+itemCode);
            //     $.ajax({
            //         method:"POST",
            //         url:"response.php",
            //         data:{
            //             ic: itemCode
            //         },
            //         datatype:'html',
            //         success:function(data){
            //             $('.brand').html(data);
            //         }
            //     });
            // });
            // }

            // $('.itemcode').on('change',function(){
            //     var itemCode = $(this).val();
            //     alert("item code is "+itemCode);
            //     $.ajax({
            //         method:"POST",
            //         url:"response.php",
            //         data:{
            //             ic: itemCode
            //         },
            //         datatype:'html',
            //         success:function(data){
            //             $('.brand').html(data);
            //         }
            //     });
            // });
            // $('.tablerow').each(function(){
            //     var count = $(".tablerow").length;
            
            $('#product_tbody > tr ').on('change','.itemcode',function() {
                var itemCode = $(this).val();
                alert("item code is " + itemCode);
                $.ajax({
                    method: "POST",
                    url: "response.php",
                    data: {
                        ic: itemCode
                    },
                    datatype: 'html',
                    success: function(data) {
                        // $('.brand').html(data);
                        $('.itemcodetr').next().find('.brand').html(data);
                        // $('#product_tbody').each(function () {
                        //     $('.brand').html(data);
                        // });
                        // $(this).closest("tr").find(".total").val(price * qty);
                        // $("#selectbrand").find('.brand').html(data);
                    }
                });
            });

            $(this).on('change','.brand',function() {
                var brandId = $(this).val();
                var itemCode = $('.itemcode').val();
                alert("item code is " + itemCode + "//" + brandId);
                $.ajax({
                    method: "POST",
                    url: "response.php",
                    data: {
                        itemcode: itemCode,
                        brandid: brandId
                    },
                    datatype: 'html',
                    success: function(data) {
                        let price = parseInt(data);
                        // alert(typeof(price));
                        $('.price').val(price);
                    }
                });
            });
            // });



            // $('.itemcode').on('change',function() {
            //     var itemCode = $(this).val();
            //     alert("item code is " + itemCode);
            //     $.ajax({
            //         method: "POST",
            //         url: "response.php",
            //         data: {
            //             ic: itemCode
            //         },
            //         datatype: 'html',
            //         success: function(data) {
            //             $('.brand').html(data);
            //         }
            //     });
            // });

            // $('.brand').on('change',function() {
            //     var brandId = $(this).val();
            //     var itemCode = $('.itemcode').val();
            //     alert("item code is " + itemCode + "//" + brandId);
            //     $.ajax({
            //         method: "POST",
            //         url: "response.php",
            //         data: {
            //             itemcode: itemCode,
            //             brandid: brandId
            //         },
            //         datatype: 'html',
            //         success: function(data) {
            //             let price = data.slice(2, -2);
            //             $('.price').val(price);
            //         }
            //     });
            // });

            $('.qty').on('keyup', this, function() {
                let quantity = $(this).val();
                let itemcode = $('.itemcode').val();
                let brandid = $('.brand').val();
                // alert(quantity);
                $.ajax({
                    method: "POST",
                    url: "response.php",
                    data: {
                        qty: quantity,
                        brand: brandid,
                        item: itemcode
                    },
                    datatype: 'datastring',
                    success: function(data) {
                        let stval = parseInt(data);
                        // alert(typeof(stval));              
                        if (stval == 0) {
                            $('.qty').css('border', '2px solid red');
                            alert('Stock value of this item is 0 !!');
                        } else if ($('.qty').val() > stval) {
                            $('.qty').css('border', '2px solid red');
                            alert('Quantity is more than stock available !!');
                        } else {
                            $('.qty').css('border-color', '');
                        }
                    }
                });
            });

            $('#countrow').on('click', function() {
                alert("hello");
                var nuum = $(".product_tbody > tr").length;
                alert(nuum);
                // $('tbody > tr').each(function(index, value) {
                //     console.log(`tr${index}: ${this.id}`);

                // });
            });



            // ORIGINAL ONE
            // $('.itemcode').on('change', function(){
            //     var itemCode = $(this).val();
            //     alert("item code is "+itemCode);
            //     $.ajax({
            //         method:"POST",
            //         url:"response.php",
            //         data:{
            //             ic: itemCode
            //         },
            //         datatype:'html',
            //         success:function(data){
            //             $('.brand').html(data);
            //         }
            //     });
            // }); 

            // $('body').on('change','.brand',function(){
            //     var brandId = $(this).val();
            //     var itemCode = $('.itemcode').val();
            //     alert("item code is "+itemCode+"//"+brandId);
            //     $.ajax({
            //         method:"POST",
            //         url:"response.php",
            //         data:{
            //             itemcode: itemCode, brandid:brandId
            //         },
            //         datatype:'html',
            //         success:function(data){
            //             let price = data.slice(2,-2);
            //             $('.price').val(price);
            //         }
            //     });
            // }); 



        });
    </script>
</body>

</html>