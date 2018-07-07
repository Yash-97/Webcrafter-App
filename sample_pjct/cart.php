<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
<title>Cart</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">

<!--Icons-->
<script src="js/lumino.glyphs.js"></script>

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	
		<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">

<br><br><br><br>		
<?php
		session_start();
		include 'header.php';
		 if(isset($_POST['logout']))
{
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true)
    {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
    }
    else{
        echo "<script>alert('Login first!')</script>";
    }
}
		if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true)
    {
        if($_SESSION['logged_as']=="customer")
        {
        	echo"
		<ul class='nav menu'>
			<li><a href='dashboard_c.php'><svg class='glyph stroked dashboard-dial'><use xlink:href='#stroked-dashboard-dial'></use></svg> Dashboard</a></li>
			<li class='active'><a href='data.php'><svg class='glyph stroked calendar'><use xlink:href='#stroked-calendar'></use></svg> Book Someone</a></li>
			<li><a href='history_c.php'><svg class='glyph stroked line-graph'><use xlink:href='#stroked-line-graph'></use></svg> Passbook</a></li>
			<li role='presentation' class='divider'></li>";
		}
		else {
			echo"
		<ul class='nav menu'>
			<li class='active'><a href='dashboard_s.php'><svg class='glyph stroked dashboard-dial'><use xlink:href='#stroked-dashboard-dial'></use></svg> Dashboard</a></li>
			<li><a href='history_s.php'><svg class='glyph stroked line-graph'><use xlink:href='#stroked-line-graph'></use></svg> Passbook</a></li>
			<li role='presentation' class='divider'></li>";
		}
		echo "
			<li><form method='POST' action=''><input class='btn btn-primary' type='submit' name='logout' value='Logout'></form></li>
		</ul>";
	}
	else{
		if($_SESSION['logged_as']=="customer")
        {
        	echo"<li><a href='login_c.php'><svg class='glyph stroked male-user'><use xlink:href='#stroked-male-user'></use></svg> Login Page</a></li>";
        }
        else
        {
        	echo "<li><a href='login_s.php'><svg class='glyph stroked male-user'><use xlink:href='#stroked-male-user'></use></svg> Login Page</a></li>";
        }
	}
?>
	</div>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="admin_dashboard.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<!--<li class="active">Icons</li>-->
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Cart</h1>
			</div>
		</div>
		<div class="row" style="padding:20px;">
			<div class='col-xs-12 col-md-6 col-lg-3 cards' style='margin-right:20px; margin-bottom:20px;'>
				<div class='container1'><?php
$selected_seller=$_SESSION['selected_seller'];
//$ip=$_SESSION['ip1'];
//$_SESSION['ip2']=$ip;
//$user=$_SESSION['sess_user2'];
$sellers=$_SESSION['sellers_available1'];
$category=$_SESSION['product1'];
$con=mysqli_connect('localhost','root','','WebDB') or die(mysqli_error());
//$query=mysqli_query($con,"SELECT * FROM Customer WHERE Email='".$user."'");
//$row=mysqli_fetch_assoc($query);
//echo "Welcome "."".$row['Name']."<br>";
//$custid=$row['CustID'];
$diff=$_SESSION['diff1'];
//$_SESSION['sess_user3']=$custid;
/*for($i=0;$i<sizeof($sellers);$i++)
{
    if(isset($sellers[$i]))
    {
        $curr=$sellers[$i];
        $query=mysqli_query($con,"SELECT * FROM Seller WHERE SellerID='".$curr."'");
        //echo $query;
        $numrows=mysqli_num_rows($query);  
        if($numrows!=0)
        {
            while($row=mysqli_fetch_assoc($query))
            {
                echo "SellerID : ".$row['SellerID']." Name : ".$row['Name']." Location : ".$row['Location']."<br>";
            }
        }
    }
}*/
$amt=0;
$amt=($diff+1)*100;
//echo "Product purchased : ".$category."<br>";
//echo "Amount : Rs.".$amt;
$query=mysqli_query($con,"SELECT * FROM Seller WHERE SellerID='".$selected_seller."'");
$numrows=mysqli_num_rows($query);  
        if($numrows!=0)
        {
            while($row=mysqli_fetch_assoc($query))
            {
                //echo "SellerID : ".$row['SellerID']." Name : ".$row['Name']." Location : ".$row['Location']."<br>";
                echo "<h4><b>Product&nbsp;<i class='fa fa-shopping-cart' aria-hidden='true'></i></b> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;".$category."</h4><br>
                <h4><b>Seller&nbsp;<i class='fa fa-user' aria-hidden='true'></i></b> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;".$row['Name']."</h4><br>
                <h4><b>Total&nbsp;<i class='fa fa-money' aria-hidden='true'></i></b> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp;Rs.".$amt."</h4><br>
                <h4><b>Select Payment&nbsp;</b></h4>";
            }
        }
if(isset($_POST['submit']))
{
    //$query1=mysqli_query($con,"INSERT INTO Orders VALUES('".$custid."".rand(100,99999)."','".$custid."','F')");
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true)
    {
    	$user=$_SESSION['logged_user'];
    	$query1=mysqli_query($con,"SELECT * FROM Customer WHERE Email='".$user."'");
    	$row1=mysqli_fetch_assoc($query1);
    	$custid=$row1['CustID'];
    	$location=$_SESSION['order_location'];
    $stdate=$_SESSION['order_stdate'];
    $endate=$_SESSION['order_endate'];
    $category=$_SESSION['product'];
    $query2=mysqli_query($con,"INSERT INTO Orders VALUES('".$custid."".rand(100,99999)."','".$custid."','".$_SESSION['selected_seller']."','F','".$location."','".$category."','".$stdate."','".$endate."')");
    $query3=mysqli_query($con,"UPDATE Seller SET Status = 'booked' WHERE SellerID = '".$_SESSION['selected_seller']."'");
    for($j=$stdate;$j<=$endate;$j=$j+86400)
    {
        $query4=mysqli_query($con,"INSERT INTO SellerAvailability VALUES('".$_SESSION['selected_seller']."','".$j."')");
    }
    header("Location: ./dashboard_c.php");
    }
    else{
    header("Location: ./login_c.php");
}
    //header("Location: PaytmKit/TxnTest.php");
}
?>
					<i class="fa fa-circle-o"></i><a href=""> PayTM</a><br>
					<i class="fa fa-circle-o"></i><a href=""> Cash On Delivery</a><br>
					<i class="fa fa-circle-o"></i><a href=""> Credit Card</a><br>
					<i class="fa fa-circle-o"></i><a href=""> Pay after delivery</a>
<br><br>
						<form method="POST" action="">
                            <input class="btn btn-primary" type="submit" name="submit" value="PLACE ORDER"><br>
                        </form>
				</div>
			</div>
	</div>
</body>
</html>