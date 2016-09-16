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

 <!-- Page Header -->
        
<div class="row">
<div class="col-lg-12">
</div>
</div>
        <!-- /.row -->

        <!-- Projects Row -->
         <div class="row" >

            <div class="col-md-6 portfolio-item" >
                <a href="personalcare.php">
                    <img class="img-responsive" src="images/personal_care.jpg" height="300" width="400" alt="">
                </a>
                <h3>
                    <a href="personalcare.php">Personal Care</a>
                </h3>
                
            </div>
            <div class="col-md-6 portfolio-item">
                <a href="household.php">
                    <img class="img-responsive" src="images/house_hold.jpg" height="300" width="400"  alt="">
                </a>
                <h3>
                    <a href="household.php">House Hold</a>
                </h3>
          </div>
        </div>
        <!-- /.row -->

        <!-- Projects Row -->
        <div class="row">
            <div class="col-md-6 portfolio-item">
                <a href="beverages.php">
                    <img class="img-responsive" src="images/beverages.jpg" height="300" width="400"  alt="">
                </a>
                <h3>
                    <a href="beverages.php">Beverages</a>
                </h3>
                
            </div>
            <div class="row">
            <div class="col-md-6 portfolio-item">
                <a href="aircraft.php">
                    <img class="img-responsive" src="images/aircraft.jpg" height="300" width="400"  alt="">
                </a>
                <h3>
                    <a href="aircraft.php">Aircraft</a>
                </h3>
                
            </div>
            
        </div>
         
            <div class="col-md-6 portfolio-item">
                <a href="games.php">
                    <img class="img-responsive" src="images/video_game.jpg" height="300" width="400" alt="">
                </a>
                <h3>
                    <a href="games.php">Video Games</a>
                </h3>
                
            </div>
        </div>
        <!-- /.row -->
</div>


        <!-- Pagination -->
        <!-- /.row -->

        <hr>

        <!-- Footer -->
        <footer>
            <div class="row">
                <div class="col-lg-12">
                    <p>Copyright &copy; You have been boombasketed</p>
                </div>
            </div>
            <!-- /.row -->
        </footer>

    </div>
    <!-- /.container -->


</body>

</html>
