<?php

use LDAP\Result;

    include 'dbconn.php'; 
    $editid = $_GET['edit'];

    $sqlitem = "SELECT DISTINCT item_name, item_code FROM `item_mstr` WHERE `status` = 1";
    $allitem = mysqli_query($connection,$sqlitem);

    $sqlbrand = "SELECT id, brand_name FROM `brand_mstr` WHERE `status` = 1";
    $allbrand = mysqli_query($connection,$sqlbrand);

    
    $sql = "SELECT * FROM `sale_mstr` WHERE id = $editid";
    $result = mysqli_query($connection,$sql);
    $row = mysqli_fetch_assoc($result);
    $name = $row['customer_name'];
    $mobile =$row['number'];
    $balance =$row['totalamount'];
    $invoiceno = $row['invoice_no'];
    $caddress = $row['customer_address'];

    $sql2 = "SELECT * FROM `sale_details` WHERE status = 1 AND sale_mstr_id = $editid";
    
    $result2 = mysqli_query($connection,$sql2);
    // $row2 = mysqli_fetch_array($result2);
    
    if(isset($_POST['submit'])){
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
        if($connection->query($sql)){
            $saleid = $connection->insert_id;

            $sql2 = "insert into `sale_details` (item_code,brand_id,qty,price,amount,sale_mstr_id) values ";
            $rows=[];
            for($i = 0; $i<count($_POST["pname"]);$i++){
                $pname = mysqli_real_escape_string($connection,$_POST['pname'][$i]);
                $brand = mysqli_real_escape_string($connection,$_POST['brand'][$i]);
                $price = mysqli_real_escape_string($connection,$_POST['price'][$i]);
                $qty = mysqli_real_escape_string($connection,$_POST['qty'][$i]);
                $total = mysqli_real_escape_string($connection,$_POST['total'][$i]);
                $rows[] = "('{$pname}','{$brand}','{$qty}','{$price}','{$total}','{$saleid}')";
            }
            $sql2.=implode(",",$rows);
            if($connection->query($sql2)){
                header('location:customer_display.php');
            }
            else{
                die(mysqli_error($connection));
            }
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
                        <input type="text" name="invoice_no" required class="form-control" placeholder="Invoice Numebr" value="<?php echo $invoiceno; ?>">
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
                        <input type="text" name="cname" required class="form-control" placeholder="Customer Name" value="<?php echo $name;?>">
                    </div>
                    <div class="form-group">
                        <label for="">Address</label>
                        <input type="text" name="caddress" required class="form-control" placeholder="Customer Address" value="<?php echo $caddress;?>">
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile</label>
                        <input type="text" name="mobile" id="mobile" class="form-control" placeholder="Customer Mobile Number" maxlength="10" required value="<?php echo $mobile;?>">
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
                        <tbody id="product_tbody">
                        <tr>
                            <td>
                                <input type="text" required name="pname[]" class="form-control" list="datalistitemname">
                                <datalist id="datalistitemname">
                                    <?php
                                        while ($items = mysqli_fetch_array($allitem, MYSQLI_ASSOC)) :;
                                    ?>
                                    <option value="<?php echo $items["item_code"]; ?>">
                                        <?php echo $items["item_name"]; ?>
                                    </option>
                                    <?php endwhile; ?>
                                </datalist>
                            </td>
                            <td>
                                <input type="text" required name="brand[]" class="form-control brand" list="datalistbrandname">
                                <datalist id="datalistbrandname"> 
                                    <?php
                                        while ($brands = mysqli_fetch_array($allbrand, MYSQLI_ASSOC)) :;
                                    ?>
                                    <option value="<?php echo $brands["id"]; ?>">
                                        <?php echo $brands["brand_name"]; ?>
                                    </option>
                                    <?php endwhile; ?>
                                </datalist>
                            </td>
                            <td><input type="text" required name="price[]" class="form-control price"></td>
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
                    <!-- <input type="submit" name="submit" value="Add" class="btn btn-success flat-right"> -->
                </div>
            </div>
        </form>
    </div>
    <script>
        $(document).ready(function() {
            $('#date').datepicker({
                dateFormat:"dd-mm-yy"
            });
            // adding new product row
            $('#btn-add-row').click(function(){
                // var row ="<tr><td><input type='text' required name='pname[]' class='form-control'></td><td><input type='text' required name='price[]' class='form-control price'></td><td><input type='text' required name='qyt[]' class='form-control qty'></td><td><input type='text' required name='total[]' class='form-control total'></td><td><input type='button' value='X' class='btn btn-danger btn-sm btn-row-remove'> </td> </tr>";
                var row = "<tr><td><input type='text' required name='pname[]' class='form-control' list='datalistitemname'><datalist id='datalistitemname'> <option value=''>Select Item...</option><?php while ($items = mysqli_fetch_array($allitem, MYSQLI_ASSOC)) :;?> <option value='<?php echo $items['item_code']; ?>'><?php echo $items['item_name']; ?></option><?php endwhile; ?></datalist></td><td><input type='text' required name='brand[]' class='form-control brand' list='datalistbrandname'><datalist id='datalistbrandname'> <?php while ($brands = mysqli_fetch_array($allbrand, MYSQLI_ASSOC)) :;?><option value='<?php echo $brands['id']; ?>'><?php echo $brands['brand_name']; ?></option><?php endwhile;?></datalist></td><td><input type='text' required name='price[]' class='form-control price'></td><td><input type='text' required name='qty[]' class='form-control qty'></td><td><input type='text' required name='total[]' class='form-control total'></td><td><input type='button' value='X' class='btn btn-danger btn-sm btn-row-remove'></td></tr>"
                $("#product_tbody").append(row);
            });

            $("body").on("click",".btn-row-remove",function(){
                if(confirm("Are you Sure?")){
                $(this).closest("tr").remove();
                grand_total();
                }
            });

            $("body").on("keyup",".price",function(){
                var price = Number($(this).val());
                var qty = Number($(this).closest("tr").find(".qty").val());
                $(this).closest("tr").find(".total").val(price*qty);
            });

            $("body").on("keyup",".qty",function(){
                var qty = Number($(this).val());
                var price = Number($(this).closest("tr").find(".price").val());
                $(this).closest("tr").find(".total").val(price*qty);
                grand_total();
            });

            function grand_total(){
                var tot=0;
                $(".total").each(function(){
                    tot+=Number($(this).val());
                });
                $("#grand_total").val(tot);
            }
        });
    </script>
</body>
</html>