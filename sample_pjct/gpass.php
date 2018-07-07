<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Customer Sign Up</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">Customer Sign Up</div>
				<div class="panel-body">
					<form role="form" method="POST" action="">
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="Password" name="pass" type="password" value="">
							</div>
							<input type="submit" name="submit" value="Create Account" class="btn btn-primary"><br><br>
						</fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
	<?php  
if(isset($_POST["submit"])){  
  
if(!empty($_POST['pass'])) {  
	session_start(); 
    $pass=$_POST['pass'];
    $con=mysqli_connect('localhost','root','','WebDB') or die(mysqli_error());

    $query=mysqli_query($con,"SELECT MAX(CustID) AS MAXID FROM Customer");    
    $row=mysqli_fetch_assoc($query);
    $nid=$row['MAXID'];
    $nnid=$nid+1;
    $query1=mysqli_query($con,"INSERT INTO Customer VALUES('".$nnid."','".$user."','".$phone."','".$email."','".$pass."','0')");
    header("Location: ./login_c.php");  
  
} else {  
    echo "<script>swal('Oops!', 'All fields are required!', 'warning');</script>"; 
}  
}  
?>
		

	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script>
		!function ($) {
			$(document).on("click","ul.nav li.parent > a > span.icon", function(){		  
				$(this).find('em:first').toggleClass("glyphicon-minus");	  
			}); 
			$(".sidebar span.icon").find('em:first').addClass("glyphicon-plus");
		}(window.jQuery);

		$(window).on('resize', function () {
		  if ($(window).width() > 768) $('#sidebar-collapse').collapse('show')
		})
		$(window).on('resize', function () {
		  if ($(window).width() <= 767) $('#sidebar-collapse').collapse('hide')
		})
	</script>	
	<script>
		window.onload = alert(localStorage.getItem("storageName"));
	</script>
</body>

</html>
