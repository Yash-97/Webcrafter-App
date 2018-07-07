<?php
session_start();
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
echo "<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'>
<meta name='viewport' content='width=device-width, initial-scale=1'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css'>
<title>Sellers</title>

<link href='css/bootstrap.min.css' rel='stylesheet'>
<link href='css/datepicker3.css' rel='stylesheet'>
<link href='css/styles.css' rel='stylesheet'>
<link rel='stylesheet' href='https://www.w3schools.com/w3css/4/w3.css'>
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css'>
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
<!--Icons-->
<script src='js/lumino.glyphs.js'></script>

<!--[if lt IE 9]>
<script src='js/html5shiv.js'></script>
<script src='js/respond.min.js'></script>
<![endif]-->

</head>

<body>
	
		<div id='sidebar-collapse' class='col-sm-3 col-lg-2 sidebar'>

<br><br><br><br>";
include 'header.php';
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
	echo "</div><!--/.sidebar-->
	<div class='col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main'>			
		<div class='row'>
			<ol class='breadcrumb'>
				<li><a href='admin_dashboard.php'><svg class='glyph stroked home'><use xlink:href='#stroked-home'></use></svg></a></li>
				<!--<li class='active'>Icons</li>-->
			</ol>
		</div><!--/.row-->
		
		<div class='row'>
			<div class='col-lg-12'>
				<h1 class='page-header'>Dashboard</h1>
			</div>
		</div><!--/.row-->
		<div class='col' style='padding:20px;'>";
//session_start(); 
$name_seller="";
$seller_loc="";
$sellers=$_SESSION['sellers_available'];
$_SESSION['sellers_available1']=$sellers;
//$user=$_SESSION['sess_user1'];
//$_SESSION['sess_user2']=$user;
$category=$_SESSION['product'];
$_SESSION['product1']=$category;
//$ip=$_SESSION['ip'];
//$_SESSION['ip1']=$ip;
$diff=$_SESSION['diff'];
$_SESSION['diff1']=$diff;

//echo $sellers[0];
$i=0;
$con=mysqli_connect('localhost','root','','WebDB') or die(mysqli_error());
for($i=0;$i<sizeof($sellers);$i++)
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
            //echo "SellerID : ".$row['SellerID']." Name : ".$row['Name']." Location : ".$row['Location']."<br>";
            echo "
			<div class='col-xs-12 col-md-6 col-lg-3 cards' style='margin-right:20px; margin-bottom:20px;'>
				<img src='19.jpg' alt='test' style='width:100%'>
				<div class='container1'>

					<h4><b>Seller&nbsp;<i class='fa fa-user' aria-hidden='true'></i></b> &nbsp;".$row['Name']."</h4> 
					<span><b>Rating&nbsp;<i class='fa fa-calendar' aria-hidden='true'></i></b></span>&nbsp;
					<span style='font-size:11px;''>
						<span class='fa fa-star checked'></span>
						<span class='fa fa-star checked'></span>
						<span class='fa fa-star checked'></span>
						<span class='fa fa-star checked'></span>
						<span class='fa fa-star'></span>
					</span>
					<br>
					<span><b>Pricing&nbsp;<i class='fa fa-money' aria-hidden='true'></i></b></span>&nbsp;
					<span>2000INR</span> 
					<br/><br/>
					<form method='POST' action=''>
					<input class='btn btn-default btn-md pull-left' type='submit' name='c_".$row['SellerID']."' value='Check his Work'>
					<input class='btn btn-default btn-md pull-right' type='submit' name='".$row['SellerID']."' value='Order via him'></form>					
				</div>
			</div>";
}
      }
  }
}
if(sizeof($sellers)==0)
{
	echo "<div class='col-xs-12 col-md-6 col-lg-3 cards' style='margin-right:20px; margin-bottom:20px;'><div class='container1'>No sellers are available for selected date(s)!</div></div>";
	exit();
}
$uploadfiles=array();
$c=0;
$dir = "UploadFolder";
// Open a directory, and read its contents
if (is_dir($dir)){
  if ($dh = opendir($dir)){
    while (($file = readdir($dh)) !== false){
      //echo "filename:" . $file . "<br>";
      $uploadfiles[$c]=$file;
      $c++;
    }
    closedir($dh);
  }
}
for($i=0;$i<sizeof($sellers);$i++)
{
  $x1=$sellers[$i];
  $var="c_".$x1;
if(isset($_POST[$var]))
{
	echo "<div class='container'>
  <!-- Trigger the modal with a button -->

  <!-- Modal -->
  <div class='modal fade' id='myModal' role='dialog'>
    <div class='modal-dialog'>
    
      <!-- Modal content-->
      <div class='modal-content'>
        <div class='modal-header'>
          <button type='button' class='close' data-dismiss='modal'>&times;</button>
          <h4 class='modal-title'><b>Portfolio</b></h4>
        </div>
        <div class='modal-body'><div class='w3-content w3-display-container'>";
        for($j=0;$j<sizeof($uploadfiles);$j++)
        {
        	if(strlen($uploadfiles[$j])>4)
        	{
        		$ss=substr($uploadfiles[$j], 0, 3);
        		if((int)$ss==$x1)
        		{
        			echo "<img class='mySlides w3-animate-zoom' src='./UploadFolder/".$uploadfiles[$j]."' style='width:100%'>";
        		}
        	}
        }
        echo "<button class='w3-button w3-black w3-display-left' onclick='plusDivs(-1)'>&#10094;</button>
  <button class='w3-button w3-black w3-display-right' onclick='plusDivs(1)'>&#10095;</button>
</div></div>
        <div class='modal-footer'>
          <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
<script> $('#myModal').modal('show');</script>
<script>
var slideIndex = 1;
showDivs(slideIndex);

function plusDivs(n) {
  showDivs(slideIndex += n);
}

function showDivs(n) {
  var i;
  var x = document.getElementsByClassName('mySlides');
  if (n > x.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = x.length}
  for (i = 0; i < x.length; i++) {
     x[i].style.display = 'none';  
  }
  x[slideIndex-1].style.display = 'block';  
}
</script>";
	exit();
}
}
for($i=0;$i<sizeof($sellers);$i++)
{
  $x=$sellers[$i];
if(isset($_POST[$x]))
{
  $_SESSION['selected_seller']=$x;
  header("Location: cart.php");
  exit();
}
}
?></div>	

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