<?php
session_start();
include 'allfunctions.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
<link rel="shortcut icon" href="images/favicon.ico">
    <title>Boombasket</title>
<script src="category.js"></script>
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/2-col-portfolio.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
       <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
   
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
<?php
   mylogin();
?>
        <?php
        if(!isset($_SESSION['email']))     
        echo "<a href='signin.php' class='btn btn-default'  style='margin-top:8px' id='signin'>Signup</a>";
        ?>
        <a class="navbar-brand" href="index.php" style="color:#fff; font-weight:bold" >Boombasket.com</a>

            </div>
  
          <div style="float:right;">
            <ul class="nav navbar-nav">
            <li> 
<?php
    mycount();
?>
        </li>
      </ul>
        </div> 

        <form class="navbar-form navbar-right" action= "javascript:searcha()">
            <div class="input-group">
              <input type="text" id="query" placeholder="Search" class="form-control">
            
           <div class="input-group-btn">
                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
            </div>
        </div>
        </form>
        
             
        
            <!-- Collect the nav links, forms, and other content for toggling -->

            <!-- /.navbar-collapse -->

        </div>
        <!-- /.container -->
         
    </nav>

    <!-- Page Content -->
     <div class="container" id="heading">
     </div>
    <div class="container">
<div id="searchlist">

    <div class="container">
      <!-- Example row of columns -->
      <div class="row"  id='list'>
        <?php
 $hostname="localhost"; 
  $username="root"; 
  $password=""; 
  $database="boom";
  $email=$_SESSION['email'];
  $con=mysqli_connect($hostname,$username,$password,$database);
  if(!$con)
  {
          die('Connection Failed'.mysqli_error());
  }
  $sql="SELECT * FROM `boomorder` WHERE email = '$email' ORDER BY ts DESC;";
  $result=mysqli_query($con,$sql);
     if(mysqli_num_rows($result)>0)
    {
      echo "<h4> Your order history has " .mysqli_num_rows($result). " order(s)</h4>";
    
      while($row=mysqli_fetch_assoc($result))
      {
        echo "<div class='panel panel-default'> <h4 class='panel-heading'>Order# : ";
        echo $row['oid'];
        echo "</h4>";
        
        $cartList = $row['products'];
        $productsArray = explode(",",$cartList);
        $plen=sizeof($productsArray);
        for($i=0;$i<$plen;$i++){
          $prodName=explode("_",$productsArray[$i]);
          $productName = $prodName[1];
          $category=$prodName[0];
          $qty=explode("|", $productsArray[$i]);
          $qty=$qty[1];
          if($category != 'aircraft')
        echo "<img height='100px' width='100px' src='images/$category/$productName.jpg' style='float:left'/><p>&nbsp&nbsp$productName</p><p>&nbsp&nbspQuantity : $qty</p><hr><br>";
        else {
          $prod1=explode("|",$productName);
          $prod=explode("-",$prod1[0]);

        echo "<img height='100px' width='100px' src='images/$category/$prod[0].jpg' style='float:left'/><p>&nbsp&nbsp$prod1[0]</p><p>&nbsp&nbspQuantity : $qty</p><hr><br>";  
      }

        }
    
setlocale(LC_MONETARY, 'en_IN');
$total = money_format('%!i', $row['price']);
  echo "<h3 style='text-align:right'>Total : <i class='fa fa-inr'></i>&#8377;$total</h3></div>";
            
        }
      }
    else
      echo "<h2>No orders found</h2>";
  
?> 