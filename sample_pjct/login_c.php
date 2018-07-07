<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Forms</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<meta name="google-signin-client_id" content="190279350949-j6v301uq1sov4ktkr961lv6vko0pjmon.apps.googleusercontent.com">
<script src="https://apis.google.com/js/api.js"></script>
<script src="https://apis.google.com/js/platform.js?onload=init" async defer></script>
<script src="js/jquery-1.11.1.min.js"></script>
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
				<div class="panel-heading">Customer Log in</div>
				<div class="panel-body">
					<form role="form" method="POST" action="">
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="E-mail" name="user" type="email" autofocus="">
							</div>
							<div class="form-group">
								<input class="form-control" placeholder="Password" name="pass" type="password" value="">
							</div>
							<div class="checkbox">
								<label>
									<input name="remember" type="checkbox" value="Remember Me">Remember Me
								</label>
							</div>
							<input type="submit" name="submit" value="Login" class="btn btn-primary">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>OR</b>&nbsp;
							<div class="g-signin2 btn" onclick="onSignIn()" data-longtitle="true"></div><br><br>
							<a class="txt2" href="./signup.php">
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
	function get_client_ip() {
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if(isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if(isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
    } 
if(isset($_POST["submit"])){  
  
if(!empty($_POST['user']) && !empty($_POST['pass'])) {
	
    $user=$_POST['user'];  
    $pass=$_POST['pass']; 
    $_SESSION['user'] = $user; 
  
    $con=mysqli_connect('localhost','root','','WebDB') or die(mysqli_error());    
  
    $query=mysqli_query($con,"SELECT * FROM Customer WHERE Email='".$user."' AND password='".$pass."'");  
    $numrows=mysqli_num_rows($query);  
    if($numrows!=0)  
    {  
    while($row=mysqli_fetch_assoc($query))  
    {  
    $dbusername=$row['Email'];  
    $dbpassword=$row['password'];  
    $custid=$row['CustID'];
    }  
  
    if($user == $dbusername && $pass == $dbpassword)  
    {  
    session_start();  
    //$_SESSION['sess_user']=$user;
    //$ip=$_SESSION['ip2']; 
    $_SESSION['sess_custid']=$custid;
    $location=$_SESSION['order_location'];
    $stdate=$_SESSION['order_stdate'];
    $endate=$_SESSION['order_endate'];
    $category=$_SESSION['product'];
    //$_SESSION['user']=$user;
    $_SESSION['logged_in']=true;
    //$query=mysqli_query($con,"SELECT * FROM Customer WHERE Email='".$user."'");
	//$row=mysqli_fetch_assoc($query);
	//echo "Welcome "."".$row['Name']."<br>";
	$ip=get_client_ip();
	$query1=mysqli_query($con,"UPDATE Customer SET IP_Address = '".$ip."' WHERE Email = '".$user."'");
	$query2=mysqli_query($con,"INSERT INTO Orders VALUES('".$custid."".rand(100,99999)."','".$custid."','".$_SESSION['selected_seller']."','F','".$location."','".$category."','".$stdate."','".$endate."')");
  $query3=mysqli_query($con,"UPDATE Seller SET Status = 'booked' WHERE SellerID = '".$_SESSION['selected_seller']."'");
  for($j=$stdate;$j<=$endate;$j=$j+86400)
    {
        $query4=mysqli_query($con,"INSERT INTO SellerAvailability VALUES('".$_SESSION['selected_seller']."','".$j."')");
    }
    /* Redirect browser */  
    //header("Location: ../Data/data.php");
    $_SESSION['logged_user']=$user;
    header("Location: dashboard_c.php");
    }  
    } else {  
    	//echo "<script>swal('Oops!', 'Incorrect E-mail ID or Password!', 'warning');</script>";
    	echo "<script>swal('Oops!', 'Incorrect E-mail ID or Password!', 'warning', {
  button: 'Try Again',
});</script>";
    //echo "<script type='text/javascript'>alert('Invalid username or password!');</script>";
    }  
  
} else {  
    //echo "<script>swal('Oops!', 'All fields are required!', 'warning');</script>";  
    echo "<script>swal('Oops!', 'All fields are required!', 'warning', {
  button: 'Try Again',
});</script>";
}  
}  
?>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
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
	<script type="text/javascript">
		function init() {
  	gapi.load('auth2', function()
   {
    // Ready.
     });
}
		function onSignIn(googleUser) 
		{
			gapi.load('auth2', function() {
  auth2 = gapi.auth2.getAuthInstance({
    client_id: 'CLIENT_ID.apps.googleusercontent.com',
    fetch_basic_profile: false,
    scope: 'profile'
  });

  // Sign the user in, and then retrieve their ID.
  auth2.signIn().then(function() {
    console.log(auth2.currentUser.get().getId());
    if (auth2.isSignedIn.get()) {
  var profile = auth2.currentUser.get().getBasicProfile();
  console.log('ID: ' + profile.getId());
  console.log('Full Name: ' + profile.getName());
  console.log('Given Name: ' + profile.getGivenName());
  console.log('Family Name: ' + profile.getFamilyName());
  console.log('Image URL: ' + profile.getImageUrl());
  console.log('Email: ' + profile.getEmail());
  document.location.href='./dashboard_c.php';
  //var id_token = googleUser.getAuthResponse().id_token;
  //console.log("ID Token: " + id_token);
  //localStorage.setItem("storageName",profile.getName());
}
  });
});
		}
	</script>
</body>

</html>
