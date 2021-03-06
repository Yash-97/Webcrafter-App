<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
<title>Dashboard</title>

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
if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true)
    {
        if($_SESSION['logged_as']=="customer")
        {
        	echo"
		<ul class='nav menu'>
			<li class='active'><a href='dashboard_c.php'><svg class='glyph stroked dashboard-dial'><use xlink:href='#stroked-dashboard-dial'></use></svg> Dashboard</a></li>
			<li><a href='data.php'><svg class='glyph stroked calendar'><use xlink:href='#stroked-calendar'></use></svg> Book Someone</a></li>
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
	</div><!--/.sidebar-->
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">			
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="admin_dashboard.php"><svg class="glyph stroked home"><use xlink:href="#stroked-home"></use></svg></a></li>
				<!--<li class="active">Icons</li>-->
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">Dashboard</h1>
			</div>
		</div><!--/.row-->
		
		<div class="row" style="padding:20px;">
			<?php
			//session_start();
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
//session_start();
if(!(isset($_SESSION['sess_custid'])))
{
    echo "Login first!";
    exit();
}
$custid=$_SESSION['sess_custid'];
echo "<h2>Your Orders</h2>";
$con=mysqli_connect('localhost','root','','WebDB') or die(mysqli_error());
$query=mysqli_query($con,"SELECT * FROM Orders WHERE CustID='".$custid."' AND Status='F'");
$numrows=mysqli_num_rows($query);  
if($numrows!=0)
{
    while($row=mysqli_fetch_assoc($query))
    {
    	$st=date("Y-m-d", (int)$row['StDate']);
    	$en=date("Y-m-d", (int)$row['EnDate']);
        //echo "OrderID : ".$row['Order_ID']."<br>";
        echo "<div class='col-xs-12 col-md-6 col-lg-3 cards' style='margin-right:20px; margin-bottom:20px;'>
				
				<div class='container1'>
					<h4><b>Order ID&nbsp;<i class='fa fa-shopping-cart' aria-hidden='true'></i></b> &nbsp;".$row['Order_ID']."</h4> 
					<br>	
					<h4><b>Location&nbsp;<i class='fa fa-map-marker' aria-hidden='true'></i></b> &nbsp;".$row['Location']."</h4> 
					<br>
					<h4><b>Product&nbsp;<i class='fa fa-shopping-cart' aria-hidden='true'></i></b> &nbsp;".$row['Product']."</h4> 
					<br>
					<h4><b>Start Date&nbsp;<i class='fa fa-calendar' aria-hidden='true'></i></b> &nbsp;".$st."</h4> 
					<br>
					<h4><b>End Date&nbsp;<i class='fa fa-calendar' aria-hidden='true'></i></b> &nbsp;".$en."</h4> 
					<br>			
				</div>
			</div>";
    }
}
?>
		</div>
		
</body>
<style>

.cards {
    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
    transition: 0.3s;
    width: 35%;
	background-color:white;
	padding:20px;
}

.cards:hover {
    box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
}

.container1 {
    padding: 2px 16px;
}
.checked {
    color: orange;
}
</style>
</html>
