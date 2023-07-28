<?php
include 'dbconn.php';

$sqlitem = "SELECT DISTINCT item_name, item_code FROM `item_mstr` WHERE `status` = 1";
$allitem = mysqli_query($connection, $sqlitem);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Row Test</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>

  <script src="https://code.jquery.com/jquery-3.6.0.main.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.3/jquery.min.js" integrity="sha512-STof4xm1wgkfm7heWqFJVn58Hm3EtS31XFaagaa8VMReCXAkQnJZ+jEy8PCC/iT18dFy95WcExNHFTqLyp72eQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
  <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js" integrity="sha256-xLD7nhI62fcsEZK2/v8LsBcb4lG7dgULkuXoXB/j91c=" crossorigin="anonymous"></script>
</head>

<body>
  <?php
  include 'headder.php';
  ?>
  <div class="container">
    <h3 align="center"> Add Remove Dynamaic dependent select box using ajax jquery with php</h3>
    <br>
    <h4 align="center">Enter item details</h4>
    <form action="" method="POST" id="insert-form">
      <div class="table-repsonsive">
        <table class="table table-bbordered" id="item_table">
          <thead>
            <tr>
              <th>Product</th>
              <th>Brand</th>
              <th>Price</th>
              <th>qty</th>
              <th>total</th>
              <th></th>
              <th><button type="button" name="add" class="btn btn-success btn-xs add"><span class="glyphicon glyphicon-plus">Add</span></button></th>
            </tr>
          </thead>
          <tbody>

          </tbody>
        </table>
        <div align="center">
          <input type="submit" name="submit" class="btn- btn-info" value="Insert">
        </div>
      </div>
    </form>
  </div>
</body>

</html>
<script>
  $(document).ready(function() {

    var count = 0;
    $(document).on('click', '.add', function() {
      count++;
      var html = "<tr class='tablerow'><td><input type='text' required name='pname[]' id='itemcode" + count + "' class='form-control itemcode' list='datalistitemname' placeholder='Product'><datalist id='datalistitemname'><?php while ($items = mysqli_fetch_array($allitem, MYSQLI_ASSOC)) :; ?><option value='<?php echo $items['item_code']; ?>'><?php echo $items['item_name']; ?></option><?php endwhile; ?></datalist></td><td id='selectbrand'><select name='brand[]' id='brand" + count + "' class='form-control brand' required><option value=''>Select Brand...</option></select></td><td><input type='text' required name='price[]' id='price" + count + "' class='form-control price' readonly='readonly'></td><td><input type='text' required name='qty[]' class='form-control qty'></td><td><input type='text' required name='total[]' class='form-control total'></td><td><input type='button' value='X' class='btn btn-danger btn-sm btn-row-remove'></td></tr>";
      // html+='<tr>';
      // html+= '<td><input type = "text" name="item_name[]" class="form-control item_name" /></td>';
      // html+= '<td>';
      $('tbody').append(html);

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

    $('#itemcode1').on('change', function() {
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
          $('.brand1').html(data);
        }
      });
    });

    $('#brand1').on('change', function() {
      var brandId = $(this).val();
      var itemCode = $('#itemcode1').val();
      // var itemCode = $('.itemcode').val();
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
          alert(typeof(price));
          $('#price1').val(price);
        }
      });
    });
  });
</script>