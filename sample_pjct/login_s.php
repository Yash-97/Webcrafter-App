<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Seller Login</title>

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
				<div class="panel-heading">Seller Log in</div>
				<div class="panel-body">
					<form role="form" method="POST" action="">
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="Email" name="user" type="email" autofocus="">
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Password" name="pass" type="password" value="">
							</div>
							<div class="checkbox">
								<label>
									<input name="remember" type="checkbox" value="Remember Me">Remember Me
								</label>
							</div>
							<input type="submit" name="submit" value="Login" class="btn btn-primary"><br><br>
							<a class="txt2" href="./signup_s.php">
							Create your Account
							<i class="fa fa-long-arrow-right" aria-hidden="true"></i>
						</a>
						</fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
	<?php  
if(isset($_POST["submit"])){  
  
if(!empty($_POST['user']) && !empty($_POST['pass'])) {  
    $user=$_POST['user'];  
    $pass=$_POST['pass']; 
    $_SESSION['user'] = $user; 
  
    $con=mysqli_connect('localhost','root','','WebDB') or die(mysqli_error());    
  
    $query=mysqli_query($con,"SELECT * FROM Seller WHERE Email='".$user."' AND Password='".$pass."'");  
    $numrows=mysqli_num_rows($query);  
    if($numrows!=0)  
    {  
    while($row=mysqli_fetch_assoc($query))  
    {  
    $dbusername=$row['Email'];  
    $dbpassword=$row['Password'];  
    $verified=$row['verified'];
    }  
  
    if($user == $dbusername && $pass == $dbpassword)  
    {  
    	if($verified==1)
    	{
    	session_start();  
    	$_SESSION['logged_in']=true;
    	$_SESSION['logged_user']=$user;  
    	echo "success";
    	/* Redirect browser */  
    	header("Location: dashboard_s.php");
    	}
    	else
    	{
    		echo "<script>swal('Sorry!', 'Your account verification is due. Kindly wait for our response!', 'warning');</script>";
    	}
    }  
    } 
    else 
    {  
    	 echo "<script>swal('Error!', 'Incorrect username or password!', 'warning');</script>";
    }  
  
} else {  
    echo "<script>swal('Error!', 'All fields are required!', 'warning');</script>";  
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
</body>

</html>
