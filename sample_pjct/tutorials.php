<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
<title>Tutorials</title>

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
if(isset($_SESSION['trainee_loggedin']) && $_SESSION['trainee_loggedin']==true)
    {
        	echo"
		<ul class='nav menu'>
			<li><a href='dashboard_ts.php'><svg class='glyph stroked dashboard-dial'><use xlink:href='#stroked-dashboard-dial'></use></svg> Dashboard</a></li>
			<li class='active'><a href='tutorials.php'><svg class='glyph stroked calendar'><use xlink:href='#stroked-calendar'></use></svg> Tutorials</a></li>
			<li><a href='checkpoints.php'><svg class='glyph stroked line-graph'><use xlink:href='#stroked-line-graph'></use></svg> Checkpoints</a></li>
			<li role='presentation' class='divider'></li>";
		echo "
			<li><form method='POST' action=''><input class='btn btn-primary' type='submit' name='logout' value='Logout'></form></li>
		</ul>";
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
				<h1 class="page-header">Tutorials</h1>
			</div>
		</div><!--/.row-->
		
		<div class="row" style="padding:20px;">
			<?php
			//session_start();
			if(isset($_POST['logout']))
{
    if(isset($_SESSION['trainee_loggedin']) && $_SESSION['trainee_loggedin']==true)
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
if(!(isset($_SESSION['sess_tid'])))
{
    echo "Login first!";
    exit();
}
$tid=$_SESSION['sess_tid'];
$con=mysqli_connect('localhost','root','','WebDB') or die(mysqli_error());
//$query=mysqli_query($con,"SELECT * FROM Trainee WHERE Trainee_ID='".$tid."'");
//$numrows=mysqli_num_rows($query);  
//if($numrows!=0)
//{
        //echo "OrderID : ".$row['Order_ID']."<br>";
        echo "
					<iframe width='560' height='315' src='https://www.youtube.com/embed/OTni8bLLr2w' frameborder='0' allow='autoplay; encrypted-media' allowfullscreen></iframe>				
			";
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
