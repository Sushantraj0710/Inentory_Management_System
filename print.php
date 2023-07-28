<?php 
  require ("fpdf/fpdf.php");
  require ("./word.php"); 

  
  
  $connection = new mysqli('localhost','root','','new_inventory');
  $sid = $_GET['print'];
  // $sql = "SELECT sale_details.id, item_mstr.item_name, sale_details.qty, sale_details.price, sale_details.amount, sale_mstr.customer_name, sale_details.datetime, sale_details.status FROM sale_details 
  // INNER JOIN sale_mstr
  // on sale_details.sale_mstr_id = sale_mstr.id
  // INNER JOIN item_mstr
  // ON item_mstr.item_code = sale_details.item_code 
  // WHERE sale_details.status = 1 AND sale_details.id = $sid";
  $sql = "SELECT * FROM `sale_mstr` WHERE status = 1 AND id = $sid";
  $result = mysqli_query($connection,$sql);
  if($result->num_rows>0){
    $row = $result->fetch_assoc();

    $obj=new IndianCurrency($row['totalamount']);
    

    $info=[
        "customer"=>$row['customer_name'],
        "address"=>$row['customer_address'],
        "mobile"=>$row['number'],
        "invoice_no"=>$row['invoice_no'],
        "invoice_date"=>$row['datetime'],
        "total_amt"=>$row['totalamount'],
        "words"=>$obj->get_words(),
    ];
  }
  //

  //customer and invoice details 
//   $info=[
//     "customer"=>"",
//     "address"=>"",
//     "city"=>"",
//     "invoice_no"=>"",
//     "invoice_date"=>"",
//     "total_amt"=>"",
//     "words"=>"",
//   ];
  
  
  //invoice Products
  $products_info=[];
  $sql2 = "SELECT sale_details.id, sale_details.brand_id,brand_mstr.brand_name,item_mstr.item_name, sale_details.qty, sale_details.price, sale_details.amount, sale_mstr.customer_name, sale_details.datetime, sale_details.status FROM sale_details 
  INNER JOIN sale_mstr
  on sale_details.sale_mstr_id = sale_mstr.id
  INNER JOIN item_mstr
  ON item_mstr.item_code = sale_details.item_code
  INNER JOIN brand_mstr
  ON  sale_details.brand_id = brand_mstr.id
  WHERE sale_details.status = 1 AND sale_details.brand_id = item_mstr.brand_id AND sale_mstr_id = $sid";

  $res = mysqli_query($connection,$sql2);
  if($res->num_rows>0){
    $row2;
    while($row2 = $res->fetch_assoc()){
      $products_info[]=[
        "name"=>$row2['brand_name'].' '.$row2["item_name"],
        "price"=>$row2["price"],
        "qty"=>$row2["qty"],
        "total"=>$row2["amount"]
      ];
    }
  }


    // [
    //   "name"=>"Keyboard",
    //   "price"=>"500.00",
    //   "qty"=>2,
    //   "total"=>"1000.00"
    // ]
  
  class PDF extends FPDF
  {
    function Header(){
      
      //Display Company Info
      $this->SetFont('Arial','B',14);
      $this->Cell(50,10,"ShopWell Store",0,1);
      $this->SetFont('Arial','',14);
      $this->Cell(50,7,"Bhagwati Parvati Mension, Harmu Road, Basant Vihar",0,1);
      $this->Cell(50,7,"Ranchi, Jharkhand.",0,1);
      $this->Cell(50,7,"PH : 8778731770",0,1);
      
      //Display INVOICE text
      $this->SetY(10);
      $this->SetX(-60);
      $this->SetFont('Arial','B',18);
      $this->Cell(50,10,"SALES INVOICE",0,1);
      
      //Display Horizontal line
      $this->Line(0,48,210,48);
    }
    
    function body($info,$products_info){
      
      //Billing Details
      $this->SetY(55);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(50,10,"Bill To: ",0,1);
      $this->SetFont('Arial','',12);
      $this->Cell(50,7,$info["customer"],0,1);
      $this->Cell(50,7,$info["mobile"],0,1);
      $this->Cell(50,7,$info["address"],0,1);
      
      
      //Display Invoice no
      $this->SetY(55);
      $this->SetX(-75);
      $this->Cell(50,7,"Invoice No : ".$info["invoice_no"]);
      
      //Display Invoice date
      $this->SetY(63);
      $this->SetX(-75);
      $this->Cell(50,7,"Invoice Date : ".$info["invoice_date"]);
      
      //Display Table headings
      $this->SetY(95);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(80,9,"DESCRIPTION",1,0);
      $this->Cell(40,9,"PRICE",1,0,"C");
      $this->Cell(30,9,"QTY",1,0,"C");
      $this->Cell(40,9,"TOTAL",1,1,"C");
      $this->SetFont('Arial','',12);
      
      //Display table product rows
      foreach($products_info as $row){
        $this->Cell(80,9,$row["name"],"LR",0);
        $this->Cell(40,9,$row["price"],"R",0,"R");
        $this->Cell(30,9,$row["qty"],"R",0,"C");
        $this->Cell(40,9,$row["total"],"R",1,"R");
      }
      //Display table empty rows
      for($i=0;$i<12-count($products_info);$i++)
      {
        $this->Cell(80,9,"","LR",0);
        $this->Cell(40,9,"","R",0,"R");
        $this->Cell(30,9,"","R",0,"C");
        $this->Cell(40,9,"","R",1,"R");
      }
      //Display table total row
      $this->SetFont('Arial','B',12);
      $this->Cell(150,9,"GRAND TOTAL",1,0,"R");
      $this->Cell(40,9,$info["total_amt"],1,1,"R");
      
      //Display amount in words
      $this->SetY(225);
      $this->SetX(10);
      $this->SetFont('Arial','B',12);
      $this->Cell(0,9,"Amount in Words ",0,1);
      $this->SetFont('Arial','',12);
      $this->Cell(0,9,$info["words"],0,1);
      
    }
    function Footer(){
      
      //set footer position
      $this->SetY(-50);
      $this->SetFont('Arial','B',12);
      $this->Cell(0,10,"for Shopwell Store",0,1,"R");
      $this->Ln(15);
      $this->SetFont('Arial','',12);
      $this->Cell(0,10,"Authorized Signature",0,1,"R");
      $this->SetFont('Arial','',10);
      
      //Display Footer Text
      $this->Cell(0,10,"This is a computer generated invoice",0,1,"C");
      
    }
    
  }
  //Create A4 Page with Portrait 
  $pdf=new PDF("P","mm","A4");
  $pdf->AddPage();
  $pdf->body($info,$products_info);
  $pdf->Output();
?>