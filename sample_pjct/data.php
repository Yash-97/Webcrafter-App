    <!DOCTYPE html>
    <html>
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.31&key=AIzaSyCWWvBB-QQfiV_SoI02jte5nmV827-1244&libraries=places"></script>
    <style>
/* Center the loader */
#loader {
  position: absolute;
  left: 50%;
  top: 50%;
  z-index: 1;
  width: 150px;
  height: 150px;
  margin: -75px 0 0 -75px;
  border: 16px solid #000000;
  border-radius: 50%;
  border-top: 16px solid #3498db;
  width: 120px;
  height: 120px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
}

@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Add animation to "page content" */
.animate-bottom {
  position: relative;
  -webkit-animation-name: animatebottom;
  -webkit-animation-duration: 1s;
  animation-name: animatebottom;
  animation-duration: 1s
}

@-webkit-keyframes animatebottom {
  from { bottom:-100px; opacity:0 } 
  to { bottom:0px; opacity:1 }
}

@keyframes animatebottom { 
  from{ bottom:-100px; opacity:0 } 
  to{ bottom:0; opacity:1 }
}

#myDiv {
  display: none;
}
</style>
    <title>Book Someone</title>
    
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/datepicker3.css" rel="stylesheet">
    <link href="css/styles.css" rel="stylesheet">
    <!--Icons-->
    <script src="js/lumino.glyphs.js"></script>
    
    <!--[if lt IE 9]>
    <script src="js/html5shiv.js"></script>
    <script src="js/respond.min.js"></script>
    <![endif]-->
    
    </head>
<?php  
    session_start();
    if(isset($_SESSION['logged_in']) && $_SESSION['logged_in']==true)
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
    $flag=0;
    $k=0;
    $x_st=0;
    $x_en=0;
    /*function get_client_ip() {
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
    }*/
    
if(isset($_POST["submit"]))
{  
  
if(!empty($_POST['location']) && !empty($_POST['stdate'])) 
{  
    if(isset($_POST['same_date']))
    {
        $endate=$_POST['stdate'];
    }
    else
    {
        $endate=$_POST['endate'];
    }
    //$ip=get_client_ip();
    //$_SESSION['ip']=$ip;
    $location=$_POST['location'];  
    $stdate=$_POST['stdate']; 
    $category=$_POST['category'];
    $_SESSION['product']=$category;
    $_SESSION['order_location']=$location;
    //$_SESSION['order_stdate']=$stdate;
    //$_SESSION['order_endate']=$endate;
    $m_stdate=substr($stdate, 5,2);
    $m_endate=substr($endate, 5,2);
    $d_stdate=substr($stdate, 8);
    $d_endate=substr($endate, 8);

    $stdate=strtotime($stdate);
    $endate=strtotime($endate);
    $_SESSION['order_stdate']=$stdate;
    $_SESSION['order_endate']=$endate;

    if($stdate>$endate)
    {
        echo "<script>swal('Oops!', 'Invalid start and end dates. Please enter valid information!', 'warning', {
  button: 'Try Again',
});</script>";
    }
    else{

    if((int)$m_stdate==1 || (int)$m_stdate==3 || (int)$m_stdate==5 || (int)$m_stdate==7 || (int)$m_stdate==8 || (int)$m_stdate==10 || (int)$m_stdate==12)
        $x_st=31;
    else
        $x_st=30;

    $sellers=array();
    $ava=0;
    $con=mysqli_connect('localhost','root','','WebDB') or die(mysqli_error());
    $query=mysqli_query($con,"SELECT * FROM Seller WHERE verified=1");    
    $numrows=mysqli_num_rows($query);  
    if($numrows!=0)
    {  
        //echo "Location is available!";
        while($row=mysqli_fetch_assoc($query))
        {
            $flag=0;    
            $dbseller=$row['SellerID'];
            $extract=explode("!", $row['Location']);
            for($i=0;$i<sizeof($extract);$i++)
            {
                //echo $extract[$i];
                $from = $extract[$i];
                $to = $location;
                $from = urlencode($from);
                $to = urlencode($to);
                $data = file_get_contents("http://maps.googleapis.com/maps/api/distancematrix/json?origins=$from&destinations=$to&language=en-EN&sensor=false");
                $data = json_decode($data);
                $distance = 0;
                foreach($data->rows[0]->elements as $road) {
                    if(isset($road->distance->value))
                    $distance += $road->distance->value;
                }
                echo $distance." ";
                //if(strcmp($location, $extract[$i])==0)
                if($distance<=10000)
                {
                    $ava++;
                    $query1=mysqli_query($con,"SELECT * FROM SellerAvailability WHERE SellerID=".$dbseller);
            $numrows1=mysqli_num_rows($query1);
            if($numrows1!=0)
            {
                while($row1=mysqli_fetch_assoc($query1))
                {
                    $datex=$row1['BookedDates']; //string
                    //$m_date=substr($date, 5,2);
                    //$d_date=substr($date, 8);
                    //$date=strtotime($date);
                    $date=(int)$datex;
                    for($i=$stdate;$i<=$endate;$i=$i+86400)
                    {
                        if($i==$date)
                            $flag++;
                    }
                }
                
                if($flag==0)
                {
                    $sellers[$k]=$dbseller;
                    $k++;
                }   
            }
            else
            {
                $sellers[$k]=$dbseller;
                $k++;
            }
            break;
                }
            }
            
            if((int)$m_stdate==(int)$m_endate)
                {
                    $diff=(int)$d_endate-(int)$d_stdate;
                }
                else if((int)$m_stdate<(int)$m_endate)
                {
                    if($x_st==30)
                    {
                        $diff=30-(int)$d_stdate+(int)$d_endate;
                    }
                    else if($x_st==31)
                    {
                        $diff=31-(int)$d_stdate+(int)$d_endate;
                    }
                }
        }
        if($ava==0)
    {  
        echo "<script>swal('Oops!', 'Seller not available at location entered!', 'warning', {
  button: 'Try Again',
});</script>";  
    }
    else{
        $_SESSION['diff']=$diff;
            $_SESSION['sellers_available']=$sellers;
            header("Location: sellers.php"); 
    }
    } 
    } 
  
} 
else 
{  
    echo "<script>swal('Oops!', 'All fields are required!', 'warning', {
  button: 'Try Again',
});</script>";
}  
}  
?>
	<body onload="myFunction(); getLocation();">
        <div id="loader"></div>
    <div id="myDiv" class="animate-bottom">
		<div id="sidebar-collapse" class="col-sm-3 col-lg-2 sidebar">
			<br><br><br><br>
		<?php
		//session_start();
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
					<h1 class="page-header">Enter some Details</h1>
				</div>
			</div><!--/.row-->
			
			<div class="row">
				<div class="col-md-8">
					<div class="panel panel-default" style="position:absolute;
					width:600px;
					right:0px;
					">
					 	  <div class="panel-heading"  > <i class="fa fa-user-plus" aria-hidden="true" style="font-size:20px;color:black; "></i>Enter Information</div> 
						 <div class="panel-body">
                            <!--<button id="hi" onclick="getLocation()">Click me</button>-->
                            
							<form class="form-horizontal" action="" method="POST">
								<fieldset>
									<!-- Location-->
									<div class="form-group">
										<label class="col-md-3 control-label" for="email">	
											<b>Location &nbsp;<i class="fa fa-map-marker" aria-hidden="true"></i></b>
										</label>
										<!--<div class="col-md-9">
											<input style="width: 50%;" id="name" name="location" list="places" required autofocus class="form-control">
                                            <datalist id="places">
                                            <option value="Delhi">
                                            <option value="Kolkata">
                                            <option value="Mumbai">
                                            <option value="Bangalore">
                                            <option value="Chennai">
                                            <option value="Pune">
                                            <option value="Hyderabad">
                                            </datalist>
										</div>-->
                                        <input style="width: 50%;" id="searchTextField" name="location" type="text" placeholder="" required autofocus class="form-control">
                                        <div class="form-group">
                                        <input id="same_loc" style="margin-left: 20px; " type="checkbox" name="same_date" value="same_date" onclick="disableLoc()">&nbsp;&nbsp;Same as current location.<br>
                                    </div>
									</div>
								
									<div class="form-group">
										<label class="col-md-2 control-label" style="font-size:11px;">Start Date <i class="fa fa-calendar" aria-hidden="true" style="font-size:11px;"></i>
										</label>
										<div class="col-md-4">
											<input id="startDate" name="stdate" type="date" required autofocus class="form-control">
										</div>
										<label class="col-md-2 control-label" style="font-size:12px;">End Date <i class="fa fa-calendar" aria-hidden="true" style="font-size:11px;"></i>
										</label>
										
										<div class="col-md-4">
											<input id="endDate" name="endate" type="date" required autofocus class="form-control">
										</div>
									</div>

                                    <div class="form-group">
                                        <input id="same_date" style="margin-left: 20px; " type="checkbox" name="same_date" value="same_date" onclick="disableDate()">&nbsp;&nbsp;Need only for one day.<br>
                                    </div>

									<div class="form-group">
										<label class="col-md-2 control-label" style="font-size:11px;">Select Product <i class="fa fa-image" aria-hidden="true" style="font-size:11px;"></i>
										</label>
										<div class="col-md-4">
											<select class="input100" id="category" name="category" style="height: 30px;">
      										<option value="books">Books</option>
      										<option value="cars">Cars</option>
      										<option value="clothes">Clothes</option>
    									</select>
										</div>
									</div>
									
									</div>
									<!-- Form actions -->
									<div class="form-group">
										<div class="col-md-12 widget-right">
											<input id="btn1" type="submit" name="submit" class="btn btn-default btn-md pull-right">
										</div>
									</div>
								</fieldset>
							</form>
						</div>
					</div>
                </div>
		<script src="js/jquery-1.11.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
        <script>
var myVar;

function myFunction() {
    myVar = setTimeout(showPage, 3000);
}

function showPage() {
  document.getElementById("loader").style.display = "none";
  document.getElementById("myDiv").style.display = "block";
}

//var x = document.getElementById("demo");
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
        //alert('Geolocation is not supported by this browser.');

    }
}
function showPosition(position) {
    //x.innerHTML = "Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude; 
    getReverseGeocodingData(position.coords.latitude,position.coords.longitude);
    //alert(position.coords.latitude);
}
function getReverseGeocodingData(lat, lng) {
    var latlng = new google.maps.LatLng(lat, lng);
    // This is making the Geocode request
    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({ 'latLng': latlng }, function (results, status) {
        if (status !== google.maps.GeocoderStatus.OK) {
            alert(status);
        }
        // This is checking to see if the Geoeode Status is OK before proceeding
        if (status == google.maps.GeocoderStatus.OK) {
            console.log(results[0].formatted_address);
            var address = (results[0].formatted_address); 
            document.getElementById('searchTextField').value=results[0].formatted_address;
        }
    });
}

function disableLoc()
{
    if(document.getElementById("same_loc").checked==true)
    {
        document.getElementById("searchTextField").disabled=true;
        getLocation();
        //document.getElementById('searchTextField').value=address;
    }
    else if(document.getElementById("same_loc").checked==false)
    {
        document.getElementById("searchTextField").disabled=false;
    }
}
</script>
<script>
    function initialize() {
  var input = document.getElementById('searchTextField');
  new google.maps.places.Autocomplete(input);
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>
<script>
    function disableDate() {
    if(document.getElementById("same_date").checked==true)
    {
        document.getElementById("endDate").disabled=true;
    }
    else if(document.getElementById("same_date").checked==false)
    {
        document.getElementById("endDate").disabled=false;
    }
}
</script>
		
	</body>
	
	</html>
