<?php
include 'dbconn.php';
$editid = $_GET['edit'];
// to store perivious data of the particular editid
$sqlsupplier = "SELECT * FROM `supplier_mstr` WHERE `status` = 1";
$allsupplier = mysqli_query($connection,$sqlsupplier);

$sql ="SELECT purchase_mstr.id, purchase_mstr.invoice_no, purchase_mstr.invoice_date, purchase_mstr.total_amount,purchase_mstr.datetime,purchase_mstr.status, supplier_mstr.supplier_name, supplier_mstr.id AS supplierid FROM purchase_mstr
        INNER JOIN supplier_mstr
        ON purchase_mstr.supplier_id = supplier_mstr.id
        WHERE purchase_mstr.status = 1 AND purchase_mstr.id = $editid";
$result = mysqli_query($connection,$sql);
$row = mysqli_fetch_assoc($result);
$einvoice = $row['invoice_no']; 
$esuppliername = $row['supplier_name'];
$esupplierid = $row['supplierid'];
// END to store perivious data of the particular editid

if (isset($_POST['submit'])) {
    $invoiceno = $_POST['invoiceno'];
    $supplierid = $_POST['supplierid'];
    // $totalamount = $_POST['amount'];

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

    $sql = "UPDATE `purchase_mstr`SET invoice_no = $invoiceno, supplier_id = $supplierid, total_amount = 0, invoice_date = CURRENT_DATE(), datetime = CURRENT_TIMESTAMP() WHERE id = $editid";
    // $sql = "INSERT INTO `purchase_mstr` (invoice_no,supplier_id,total_amount)
    // values($invoiceno,$supplierid,$totalamount)";
    $result = mysqli_query($connection, $sql);
    if ($result) {
        // echo "Data Inserted Successfully";
        header('location:purchase_display.php');
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
    <title>Edit Purchase</title>
    <!-- using bootstrap css file -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <h1 class="my-5">Edit Purchase </h1>
        <form method="POST" autocomplete="off" class="was-validate" novalidate>
            <div class="form-group">
                <label for="Name" class="font-weight-bold">Invoice No</label>
                <input type="text" required class="form-control" id="invoiceno" aria-describedby="invoiceno" placeholder="Invoice Number" name="invoiceno" value="<?php echo $einvoice;?>">
            </div>
            <div class="form-group">
                <label for="Balance" class="font-weight-bold">Suppliers </label>
                <select name="supplierid" id="supplierid" class="form-control" required>
                    <!-- <option value="">Select Suppliers...</option> -->
                    <option value="<?php echo $esupplierid;?>"><?php echo $esuppliername;?></option>
                    <?php
                    while ($suppliers = mysqli_fetch_array($allsupplier, MYSQLI_ASSOC)) :;
                    ?>
                        <option value="<?php echo $suppliers['id']; ?>">
                            <?php echo $suppliers['supplier_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
            <!-- <div class="form-group">
                    <label for="Balance" class="font-weight-bold">Total Amount</label>
                    <input type="text" class="form-control" id="amount" placeholder="Total Amount" name="amount">
            </div> -->
            <button type="submit" class="btn btn-primary" name="submit">Save</button>
        </form>
    </div>
</body>

</html>