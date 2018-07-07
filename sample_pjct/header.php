
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Dashboard</title>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<script src="js/lumino.glyphs.js"></script>
</head>
<body>
	<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#sidebar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="admin_dashboard.php"><span>FEEDBACK</span> PORTAL</a>
				<ul class="user-menu">
					<li class="dropdown pull-right">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user-secret" aria-hidden="true" style="font-size:16px;color:white"></i> &nbsp;<?php
						ob_start();
						//session_start();
						if(isset($_SESSION['user']))
						 	echo $_SESSION['user'];
						else if(isset($_SESSION['logged_user']))
							echo $_SESSION['logged_user'];
						else if(isset($_SESSION['logged_trainee']))
							echo $_SESSION['logged_trainee'];
						 ?><span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="admin_dashboard.php"><i class="fa fa-home" aria-hidden="true" style="font-size:16px;color:black"></i> &nbsp;Home</a></li>
							<li><a href="logout.php"><i class="fa fa-user" aria-hidden="true" style="font-size:16px;color:black"></i>&nbsp; Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
						
		</div>
	</nav>
</body>
</html>
