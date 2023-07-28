<?php 
include 'dbconn.php';
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: index.html');
	exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./display.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
    <title>Sales</title>
</head>
<body>
    <div class="cus-container">
        <div class="cus-navbar">
            <div class="cus-nav-li">
                <ul>
                    <li><a href="">Home</a></li>
                    <li><a href="./customer_display.php">Sales</a></li>
                    <li><a href="./customer_detail_display.php">Sale Details</a></li>
                    <li><a href="./unit_display.php">Unit</a></li>
                    <li><a href="./brand_display.php">Brand</a></li>
                    <li><a href="./supplier_display.php">Supplier</a></li>
                    <li><a href="./purchase_display.php">Purchase</a></li>
                    <li><a href="./purchase_details_display.php">Purchase Details</a></li>
                    <li><a href="./item_display.php">Item</a></li>
                    <li><a href="./stock_display.php">Stock</a></li>
                    <li><a href=""><?=$_SESSION['name']?></a></li>
                </ul>
                <a href="logout.php" class="light-text float-right"><button class="btn btn-danger float-right ">Logout</button> </a> 
            </div>
        </div>