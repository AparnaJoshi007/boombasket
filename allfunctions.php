
<?php
function readjson($fname){
	$json_file = file_get_contents($fname);
	$_SESSION['prodid']="";
	$category = explode('.', $fname);
	$ffname=$category[0].".php";
	$raw_data = json_decode($json_file, true);
	$page = !isset($_GET['page']) ? 1 : $_GET['page'];
	$limit = 10; // five rows per page
	$offset = ($page - 1) * $limit; // offset
	$total_items = count($raw_data); // total items
	$total_pages = ceil($total_items / $limit);
	$final = array_splice($raw_data, $offset, $limit); // splice them according to offset and limit
	for($x = 1; $x <= $total_pages; $x++){
		echo "<a href='$ffname?page= $x'>";
		echo $x;
		echo "&nbsp";
		echo "</a>";
	}

if($fname == "games.json"){
	
	echo "<div class='row'>";
   foreach($final as $item){
        $prodid = $category[0].'_' .$item["Name"];
			echo " <div class='col-md-6 portfolio-item'>
			<div  style='width:300px;height:220px;border:1px solid #000;'> 
			<form method='post' action= 'addcart.php'>";
			echo "<div class='panel panel-default'><h4 class='panel-heading' >".$item["Name"]."</h4></div>";
			echo "<div style='float:left'>";
			$img = $item["Name"].'.jpg';
			$imgsrc = '/boombasket/images/'.$category[0].'/'.$img;
			echo "<img src='";
			echo $imgsrc;
			echo "' height='100' width='100' > </img>
			<br>
			</div>";
			 setlocale(LC_MONETARY, 'en_IN');
			$prodPrice= money_format('%!i', $item["Price"]);
			echo "Price = &#8377;".$prodPrice;
			//echo "<br>";
			$pprice = $item["Price"];
			$prodid=$prodid.'_gamify';
			echo "<br>";
			echo "<input type='number' name='quant' style='width:50px;' min='1' value='1'>
			<input type= 'hidden' name='id' value='$prodid'>
			<input type= 'hidden' name='pprice' value='$pprice'>
			<input type='submit' value='Add to cart' class='btn btn-default' style= 'background-color : #33ACFF; color : #fff;'>
			</form></div></div>";
        }  
        echo "</div>";
    }
    else{

    	echo "<div class='row'>";
    	foreach($final as $item){
        $prodid = $category[0].'_' .$item["Name"];
			echo "<div class='col-md-6 portfolio-item'>
			<div  style='width:300px;height:220px;border:1px solid #000;'> 
			<form method='post' action= 'addcart.php'>";
			echo "<div class='panel panel-default'><h4 class='panel-heading'>".$item["Name"]."</h4></div>";
			echo "<div style='float:left'>";
			$des=$item['Description'];
			$img = $item["Name"].'.jpg';
			
			$imgsrc = '/boombasket/images/'.$category[0].'/'.$img;
			echo "<img src='";
			echo $imgsrc;
			echo "' height='100' width='100' title='$des' > </img>
			<br>
			</div>";
			 setlocale(LC_MONETARY, 'en_IN');
			$prodPrice= money_format('%!i', $item["Price"]);
			echo "Price = &#8377;".$prodPrice;
			
			$pprice = $item["Price"];
			echo "<br>";
			echo "Quantity = ".$item["Quantity"];
			echo "<br>";
			$prodid=$prodid.'_'.$item["Quantity"];
			//  echo $item["Description"];
			echo "<br>";
			echo "<input type='number' name='quant' style='width:50px;' min='1' value='1' >
			<input type= 'hidden' name='id' value='$prodid'>
			<input type= 'hidden' name='pprice' value='$pprice'>
			<input type='submit' value='Add to cart' class='btn btn-default' style= 'background-color : #33ACFF; color : #fff;'>
			</form></div></div>";
        } 
        echo "</div>";
    } 	
}


function mylogin(){
	if(isset($_SESSION['email'])){
	    echo "<div class='btn-group'>
		<button id='username' type='button' style='margin-top:8px' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";   
		echo $_SESSION['name'];
		echo "<span class='caret'></span>
		</button><ul class='dropdown-menu' id='dropdown' >
		<li><a href='orders.php'>My Orders</a></li>
		<li><a href='logout.php'>Logout</a></li>
		</ul>
		</div>";
    }
    else{
    	echo  "<a href='login.php' style='margin-top:8px' class='btn btn-default'>Login</a>";
    }    
}

function mycount(){
	$sid = session_id();
	if(!(isset($_SESSION['count']))){
	     echo "<p class='navbar-btn'>
		<a href='cart.php' class='btn btn-default'  id='cartCount'><i class='glyphicon glyphicon-shopping-cart'></i>Cart <span id='myId'><span></a>
		</p>";
	}
	else{
		echo "<p class='navbar-btn'>
		<a href='cart.php' class='btn btn-default'  id='cartCount'><i class='glyphicon glyphicon-shopping-cart'></i>Cart (";
		echo $_SESSION['count'];
		echo ")<span id='myId'><span></a>
		</p>";
	}
}

function addtomycart(){
	$id = isset($_POST['id']) ? $_POST['id'] : "";
	$pprice = isset($_POST['pprice']) ? $_POST['pprice'] : "";
	$quant = isset($_POST['quant']) ? $_POST['quant'] : "";
	
	$sid = session_id();
	$fn = (explode('_',$id));
	$file = $fn[0];
	$file = $file.'.php';
	$_SESSION['price']=$pprice;
	$_SESSION['prodid']=$id;
	if(!(isset($_SESSION['prodlist']))){
		$_SESSION['prodlist']=$_SESSION['prodid']."|".$quant;
	}
	else{
		$_SESSION['prodlist']= $_SESSION['prodlist'].",".$_SESSION['prodid']."|".$quant;
	}

	if(!(isset($_SESSION['totalp']))){
		$_SESSION['totalp']=$_SESSION['price'];
	}
	else{
		$_SESSION['totalp']= $_SESSION['totalp'].",".$_SESSION['price'];
	}
	$prodlist=$_SESSION['prodlist'];
	$prodarray = (explode(',',$prodlist));
	$count=sizeof($prodarray);
	$_SESSION['count']=$count;

	header("Location:$file");
}

function addaircraft(){
	if(!empty($_POST['aircraft'])){
		foreach($_POST['aircraft'] as $selected){
			$fn = (explode('_',$selected));
			$file = $fn[0];
			$file = $file.'.php';
			$split=(explode('.',$selected));
			$id=$split[0];
			$pprice=$split[1];
			$quant=1;
			$_SESSION['price']=$pprice;
			$_SESSION['prodid']=$id;
			if(!(isset($_SESSION['prodlist']))){
				$_SESSION['prodlist']=$_SESSION['prodid']."|".$quant;
			}
			else{
				$_SESSION['prodlist']= $_SESSION['prodlist'].",".$_SESSION['prodid']."|".$quant;
			}

			if(!(isset($_SESSION['totalp']))){
				$_SESSION['totalp']=$_SESSION['price'];
			}
			else{
				$_SESSION['totalp']= $_SESSION['totalp'].",".$_SESSION['price'];
			}
			$prodlist=$_SESSION['prodlist'];
			$prodarray = (explode(',',$prodlist));
			$count=sizeof($prodarray);
			$_SESSION['count']=$count;

			header("Location:$file");
		}
	}
}

function addtomydb(){
	$hostname="localhost"; 
	$username="root"; 
	$password=""; 
	$database="boom";
	$random=$_SESSION['random'];
	$email=$_SESSION['email'];
	$prodlist=$_SESSION['prodlist'];
	$total=$_SESSION['total'];
	$con=mysqli_connect($hostname,$username,$password,$database);
	if(!$con)
	{
	        die('Connection Failed'.mysqli_error());
	}
    $sql=" INSERT INTO `boomorder`(`oid`, `email`, `products`, `price`, `payment` ) VALUES ('$random', '$email', '$prodlist', '$total', 'COD' ) ";

    $result=mysqli_query($con,$sql);

    if($result)
	{
	    unset($_SESSION['prodlist']);
	    unset($_SESSION['count']);
	    unset($_SESSION['totalp']);
	    unset($_SESSION['total']);
	    header("Location:index.php");
	} 
}

function mycart(){
	$sid = session_id();
	if(isset($_SESSION['count'])){
		if($_SESSION['count'] > 0){
		    echo "<h4> You have " .$_SESSION['count']. " item(s) in your cart</h4>";
		    echo "<table id='cartTable' class='table' style='border-bottom: 1px solid #000;'cellspacing='50px'>
                                
		    <thead>
		    <tr>
		    <th>&nbsp &nbsp &nbsp</th>
		    <th><h4>Item </h4></th>
		    <th>&nbsp &nbsp &nbsp</th>		    
		    <th><h4>Quantity</h4></th>
		    <th>&nbsp &nbsp &nbsp</th>
		    <th><h4>Price</h4></th>
		    </tr>
		    </thead>";
		    
		    $prodarray = (explode(',',$_SESSION['prodlist']));
		    $total=(explode(',',$_SESSION['totalp']));
		    $sum = 0;
		    
		    for($i=0; $i < $_SESSION['count'] ; $i++){
		        $prodid = $prodarray[$i];
		        $quantt = (explode('|',$prodid));
		        $sum+=($total[$i]*$quantt[1]);
		        $prodid = $prodarray[$i];
		        $fn = (explode('_',$prodid));
		        $category = $fn[0];
		        if($category=='aircraft'){
		        	$name = (explode('|',$fn[1]));
		        	$name = $name[0];
		        	$img = (explode('-',$name));
		        	$img = $img[0].".jpg";
					echo "<tr style='border-bottom: 1px solid #000;'>";
			        echo "<td>";
			        echo "<form method='post' action='deletecart.php' >";
			       
			        echo "<img src='images/$category/$img' style='float:left' height='75px' width='75px' />";
			        echo "</td>";
			        echo "<td>";
			        echo $name;
			        echo "</td>";
		        }
		        else{
			        $name= $fn[1];
			        $img = $name.".jpg";
			        echo "<tr style='border-bottom: 1px solid #000;'>";
			        echo "<td>";
			        echo "<form method='post' action='deletecart.php' >";
			     	echo "<img src='images/$category/$img' style='float:left' height='75px' width='75px' />";
			        echo "</td>";
			        echo "<td valign=middle align=left>";
			        echo $name;
			        echo "</td>";
		    	}
		        echo "<td>&nbsp &nbsp &nbsp</td>";
		        echo "<td valign=middle align=left>" . $quantt[1] . "</td>";
		        echo "<td>&nbsp &nbsp &nbsp</td>";
		         setlocale(LC_MONETARY, 'en_IN');
			$prodPrice= money_format('%!i', $total[$i]);
		
			
		        echo "<td valign=middle align=left>&#8377;" . $prodPrice . "</td>";
				echo "<td> <a href='deletecart.php?id={$i}' class='btn btn-default' style= 'background-color : #33ACFF; color : #fff;'> Delete </a> </td>";
		        echo "</tr>";
		    }
		    echo "</table>";
		    echo "<br>";
		    $_SESSION['total'] =$sum;
		     setlocale(LC_MONETARY, 'en_IN');
			$prodPrice= money_format('%!i', $sum);
		    echo "<h4>Your order total is : &#8377;".$prodPrice."  <a href='placeorder.php' class='btn btn-default' style= 'background-color : #33ACFF; color : #fff;'> CheckOut </a> </h4>";
	    }

    	else{
    		echo "<h4>You have 0 item(s) in your cart</h4>";
    	}
    }
    else{
    	echo "<h4>You have 0 item(s) in your cart</h4>";
    }
}


function mychecklogin(){
	$hostname="localhost"; 
	$username="root"; 
	$password=""; 
	$database="boom";
	  
	$con=mysqli_connect($hostname,$username,$password,$database);
	if(!$con)
	{
	    die('Connection Failed'.mysqli_error());
	}
	$email=$_REQUEST['email']; 
	$password=$_REQUEST['password']; 
	$password=md5($password);
	
	// To protect MySQL injection (more detail about MySQL injection)
	$email = stripslashes($email);
	$password = stripslashes($password);
	//echo $password;
	$sql="SELECT `name`, `email` FROM user WHERE email='$email' and password_a='$password'";
	$result=mysqli_query($con,$sql);	
	// Mysql_num_row is counting table row
	$count=mysqli_num_rows($result);
	//echo $count;
	// Mysql_num_row is counting table row
	if($count==1)
	{
		$row=mysqli_fetch_assoc($result);
		$_SESSION['email'] =$row['email'];
		//echo $row['name'];
		$_SESSION['name']=$row['name'];
		// Register $myusername, $mypassword and redirect to file "login_success.php
		header("Location:index.php");
	}
	else {
		unset($_SESSION['email']);
		echo "Wrong Username or Password";
	}
	
}

function mydeletecart(){
	$id = isset($_GET['id']) ? $_GET['id'] : "";
	$prod = (explode(',',$_SESSION['prodlist']));
	$pr = (explode(',',$_SESSION['totalp']));
	$len = sizeof($prod);
		if($len == 1){
			unset($_SESSION['prodlist']);
			unset($_SESSION['totalp']);

		}
		else if($id != 0){
				$_SESSION['prodlist']=$prod[0];
				$_SESSION['totalp']=$pr[0];
				for($i=1;$i<$len;$i++){
					if($i != $id){
						$_SESSION['prodlist']=$_SESSION['prodlist'].','.$prod[$i];
						$_SESSION['totalp']=$_SESSION['totalp'].','.$pr[$i];
					}
				}
		}
		else{
			$_SESSION['prodlist']=$prod[1];
			$_SESSION['totalp']=$pr[1];
			for($i=2;$i<$len;$i++){
				$_SESSION['prodlist']=$_SESSION['prodlist'].','.$prod[$i];
				$_SESSION['totalp']=$_SESSION['totalp'].','.$pr[$i];
			}	
		}
	$_SESSION['count'] = $_SESSION['count'] - 1;
		if($_SESSION['count']==0){
			unset($_SESSION['count']);
		}
	header("Location:cart.php");
}


function myorders(){
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
	$sql="SELECT * FROM `boomorder` WHERE email = '$email'";
	$result=mysqli_query($con,$sql);
	$count=mysqli_num_rows($result);
	if($result->num_rows>0)
	{
		echo "<h4> Your order history has " .$count. " item(s)</h4>";
		echo "
		    <table>                                
		    <thead>
		    <tr>
		    <th><h4>Order Id </h4></th>
		    <th>&nbsp &nbsp &nbsp</th>
		    <th><h4>Price</h4></th>
		    <th>&nbsp &nbsp &nbsp</th>
		    <th><h4>Payment Method</h4></th>
		    <th>&nbsp &nbsp &nbsp</th>
		    <th><h4>Order date</h4></th>
		   
		    </tr>
		    </thead>";
			while($row = mysqli_fetch_assoc($result)){
		        echo "<tr>";
		        echo "<td valign=middle align=left>" . $row['oid'] . "</td>";
		        echo "<td>&nbsp &nbsp &nbsp</td>";
		         setlocale(LC_MONETARY, 'en_IN');
			$prodPrice= money_format('%!i', $row["price"]);
		
		        echo "<td valign=middle align=left> &#8377;" . $prodPrice . "</td>";
		        echo "<td>&nbsp &nbsp &nbsp</td>";
		        echo "<td valign=middle align=left>" . $row['payment'] . "</td>";
		        echo "<td>&nbsp &nbsp &nbsp</td>";
		        echo "<td valign=middle align=left>" . $row['ts'] . "</td>";
		        echo "</tr>";
		        }
		    echo "</table>";
		    echo "</form>";
	}
    else{
        echo "<h4>You haven't placed any orders yet !!!</h4>";
    }
}

function myplaceorder(){
	if(isset($_SESSION['email'])) {
        $email=$_SESSION['email'];
        $random = mt_rand(100,999999); 
        echo "<h4>Your order information :</h4>";
        echo "<p>Order id : ".$random."</p>";
        $_SESSION['random']=$random;
         setlocale(LC_MONETARY, 'en_IN');
			$prodPrice= money_format('%!i', $_SESSION['total']);
	
        echo "<p> Total : &#8377;".$prodPrice."</p>";
        echo " <a href='adddb.php' class='btn btn-default' style= 'background-color : #33ACFF; color : #fff;' >Confirm Order </a>";
	}
	else{
    	header("Location:login.php");
	}
}



function mychecksignin(){
	$hostname="localhost"; 
	$username="root"; 
	$password=""; 
	$database="boom";
	  
	$con=mysqli_connect($hostname,$username,$password,$database);
	if(!$con)
	{
	    die('Connection Failed'.mysqli_error());
	}
	$name=$_REQUEST['name'];
	$email=$_REQUEST['email']; 
	$password=$_REQUEST['password']; 
	$password=md5($password);
	
	$sql="INSERT INTO `user`(`name`, `email`, `password_a`) VALUES ('$name', '$email', '$password')";
	$result=mysqli_query($con,$sql);
	if($result){
		header("Location:index.php");
	}

}
?>