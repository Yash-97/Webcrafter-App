<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Seller sign up</title>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/datepicker3.css" rel="stylesheet">
<link href="css/styles.css" rel="stylesheet">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
  <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.31&key=AIzaSyCWWvBB-QQfiV_SoI02jte5nmV827-1244&libraries=places"></script>
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<script src="js/respond.min.js"></script>
<![endif]-->

</head>

<body>
	
	<div class="row">
		<div class="col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
			<div class="login-panel panel panel-default">
				<div class="panel-heading">Seller Sign Up</div>
				<div class="panel-body">
					<form role="form" method="POST" action="" enctype="multipart/form-data">
						<fieldset>
							<div class="form-group">
								<input class="form-control" placeholder="Name" name="user" type="text" autofocus="">
							</div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Email**" name="email" type="email" autofocus="">
                            </div>
                            <div id="add_loc_div" class="form-group">
							<div class="form-group">
								<input id="searchTextField" class="form-control" placeholder="Location**" name="location0" type="text" autofocus="">
							</div>
                            </div>
                            <!--<div class="form-group">
                                <button style="background: lightgreen;" class="form-control" id="add_loc" onclick="addLocation(); return false;" autofocus="">+</button>
                            </div>-->
							<div class="form-group">
								<input class="form-control" placeholder="Password**" name="pass" type="password" autofocus="">
							</div>
							Upload your previous work(upto 10 images)**<br><br>
							<div class="form-group" data-validate = "Image is required">
							<input class="form-control" type="file" name="files[]" multiple="multiple">
							</div>
                            **marked fields are mandatory<br><br>
							<input type="submit" name="submit" value="Request for Verification" class="btn btn-primary"><br>
						</fieldset>
					</form>
				</div>
			</div>
		</div><!-- /.col-->
	</div><!-- /.row -->	
	<?php 
if(isset($_POST["submit"])){  
  
if(!empty($_POST['email']) && !empty($_POST['pass']) && !empty($_POST['location0'])) {  
	session_start();
    $user=$_POST['user'];  
    $email=$_POST['email'];
    $pass=$_POST['pass']; 
    //$location=$_POST['location'];
    $con=mysqli_connect('localhost','root','','WebDB') or die(mysqli_error());
    $locations=array();
    $locations[0]=$_POST['location0'];
    $k=1;
    for($i=1;$i<=10;$i++)
    {
        $varloc="location".$i;
        if(isset($_POST[$varloc]))
        {
            $locations[$k]=$_POST[$varloc];
            $k++;
        }
    }

    $locationstring=implode("!", $locations);

    $query=mysqli_query($con,"SELECT MAX(SellerID) AS MAXID FROM Seller");    
    $row=mysqli_fetch_assoc($query);
    $nid=$row['MAXID'];
    $nnid=$nid+1;

    //File Upload with validation logic

$errors = array();
$uploadedFiles = array();
$extension = array("jpeg","jpg","png","gif","mp3","mp4","wav");
$bytes = 1024;
$KB = 3000;
$totalBytes = $bytes * $KB;
$UploadFolder = "UploadFolder";
$nameoffiles="";
 
$counter = 0;
 
foreach($_FILES["files"]["tmp_name"] as $key=>$tmp_name){
    $temp = $_FILES["files"]["tmp_name"][$key];
    $name = $_FILES["files"]["name"][$key];
     
    if(empty($temp))
    {
        break;
    }
     
    $counter++;
    $UploadOk = true;
     
    if($_FILES["files"]["size"][$key] > $totalBytes)
    {
        $UploadOk = false;
        array_push($errors, $name." file size is larger than the 3 MB.");
        echo "<div class='container'>
  <!-- Trigger the modal with a button -->

  <!-- Modal -->
  <div class='modal fade' id='myModal' role='dialog'>
    <div class='modal-dialog'>
    
      <!-- Modal content-->
      <div class='modal-content'>
        <div class='modal-header'>
          <button type='button' class='close' data-dismiss='modal'>&times;</button>
          <h4 class='modal-title'>Error!</h4>
        </div>
        <div class='modal-body'>
          <p>Each file size should be less than 3MB.</p>
        </div>
        <div class='modal-footer'>
          <button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>
        </div>
      </div>
      
    </div>
  </div>
  
</div>
<script> $('#myModal').modal('show');</script>";
        exit();
    }
     
    $ext = pathinfo($name, PATHINFO_EXTENSION);
    if(in_array($ext, $extension) == false){
        $UploadOk = false;
        array_push($errors, $name." is invalid file type.");
    }
     
    if(file_exists($UploadFolder."/".$name) == true){
        $UploadOk = false;
        array_push($errors, $name." file is already exist.");
    }
     
    if($UploadOk == true){
        move_uploaded_file($temp,$UploadFolder."/".$nnid."_".$name);
        array_push($uploadedFiles, $name);
    }
}

if($counter>10)
    {
        $UploadOk=false;
        array_push($errors, "Select maximum 10 images.");
        echo "<script>swal('Error', 'Select maximum 10 images!', 'warning');</script>";
exit();
}
//echo "<script>alert('".implode(',', $uploadedFiles)."')</script>";
$nameoffiles=implode(',', $uploadedFiles);
$query1=mysqli_query($con,"INSERT INTO Seller VALUES('".$nnid."','".$user."','".$email."','".$locationstring."','".$pass."','available','0')");
$query = mysqli_query($con,"INSERT INTO Images VALUES('".$nnid."','UploadFolder','".$nameoffiles."')");
 
/*if($counter>0){
    if(count($errors)>0)
    {
        echo "<b>Errors:</b>";
        echo "<br/><ul>";
        foreach($errors as $error)
        {
            echo "<li>".$error."</li>";
        }
        echo "</ul><br/>";
    }
     
    if(count($uploadedFiles)>0){
        echo "<b>Uploaded Files:</b>";
        echo "<br/><ul>";
        foreach($uploadedFiles as $fileName)
        {
            echo "<li>".$fileName."</li>";

        }
        echo "</ul><br/>";
         
        echo count($uploadedFiles)." file(s) are successfully uploaded.";
    }                               
}
else{
    echo "Please, Select file(s) to upload.";
} */     
    
    //mail part
$to = $email;
$subject = "Request for seller registration";
$txt = "Thank you! We have received your request and will get back shortly!";
//$txt = wordwrap($txt,70);
//$headers = "From: singhania.yash125@gmail.com" . "\r\n" ."CC: somebodyelse@example.com";
$headers = "From: singhania.yash125@gmail.com". "\r\n";

$retval=mail($to, $subject, $txt, $headers);
echo"<script>swal('Thank You!', 'Your request has been received and we will get back to you within 24 hours.', 'success');</script>";
  
} else {  
    echo "<script>swal('Sorry!', 'All fields are required!', 'warning');</script>";
        exit();
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
    <script type="text/javascript">
        var c=0;
        function addLocation()
        {
            c++;
            var dummy = '<div id="add_loc_div" class="form-group"><input id="searchTextField" class="form-control" placeholder="Location**" name="location'+c+'" type="text" autofocus=""></div>';
            document.getElementById('add_loc_div').innerHTML += dummy;    
        }
        //window.location.href = "signup_s.php?c=" + c;  
    </script>
    <!--<script>
        var x = document.getElementById("demo");
function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        x.innerHTML = "Geolocation is not supported by this browser.";
        //alert('Geolocation is not supported by this browser.');

    }
}
function showPosition(position) {
    x.innerHTML = "Latitude: " + position.coords.latitude + "<br>Longitude: " + position.coords.longitude; 
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
            console.log(results);
            var address = (results[0].formatted_address); 
        }
    });
}
    </script>-->
    <script>
        function initialize() {
  var input = document.getElementById('searchTextField');
  new google.maps.places.Autocomplete(input);
}

google.maps.event.addDomListener(window, 'load', initialize);
    </script>
</body>

</html>
