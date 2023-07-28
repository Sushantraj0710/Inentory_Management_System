<?php
include 'dbconn.php';

// $sqlsupplier = "SELECT * FROM `supplier_mstr` WHERE `status` = 1";
$sqlsupplier = "SELECT * FROM `supplier_mstr` WHERE `status` = 1 ORDER by supplier_mstr.supplier_name ASC";
$allsupplier = mysqli_query($connection,$sqlsupplier);

if (isset($_POST['submit'])) {
    // $invoiceno = $_POST['invoiceno'];
    $supplierid = $_POST['supplierid'];
    $code = rand(1,99999);
    $autoinvoiceno = $code;
    // $totalamount = $_POST['amount'];

    // $sql = "INSERT INTO `purchase_mstr` (invoice_no,supplier_id)
    // values($invoiceno,$supplierid)";
    $sql = "INSERT INTO `purchase_mstr` (invoice_no,supplier_id)
    values($autoinvoiceno,$supplierid)";
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
    <title>Add Purchase</title>
    <!-- using bootstrap css file -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <h1 class="my-5">Add New Purchase </h1>
        <form method="POST" autocomplete="off" class="was-validate" novalidate>
                <!-- <div class="form-group">
                    <label for="Name" class="font-weight-bold">Invoice No</label>
                    <input type="text" required class="form-control" id="invoiceno" aria-describedby="invoiceno" placeholder="Invoice Number" name="invoiceno">
                </div> -->
            <div class="form-group">
                <label for="Balance" class="font-weight-bold">Suppliers </label>
                <select name="supplierid" id="supplierid" class="form-control" required>
                    <option value="">Select Suppliers...</option>
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

