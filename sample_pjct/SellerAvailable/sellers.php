<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style>
@font-face {
  font-family: Poppins-Regular;
  src: url('./fonts/poppins/Poppins-Regular.ttf'); 
}

@font-face {
  font-family: Poppins-Bold;
  src: url('./fonts/poppins/Poppins-Bold.ttf'); 
}

@font-face {
  font-family: Poppins-Medium;
  src: url('./fonts/poppins/Poppins-Medium.ttf'); 
}

@font-face {
  font-family: Montserrat-Bold;
  src: url('./fonts/montserrat/Montserrat-Bold.ttf'); 
}

html {
  box-sizing: border-box;
}

*, *:before, *:after {
  box-sizing: inherit;
}

h1{
  font-family: Poppins-Bold;
  text-transform: uppercase;
}

h2{
  font-family: Montserrat-Bold;
  color: #CC0000;
  font-size: 26px;
}

img{
  height: auto;
  width: auto;
}

.column {
  float: left;
  width: 33.3%;
  margin-bottom: 16px;
  padding: 0 8px;
}

@media screen and (max-width: 650px) {
  .column {
    width: 100%;
    display: block;
  }
}

.card {
  background-color: #F5F5F5;
  box-shadow: 0 8px 12px 0 rgba(0, 0, 0, 0.2);
  align-items: center;
  border-radius: 15px;
}

.container {
  padding: 10px 16px;
  background-color: #DCDCDC;
}

.container::after, .row::after {
  content: "";
  clear: both;
  display: table;
}

.container-contact100 {
  width: 100%;  
  min-height: 100vh;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  align-items: center;
  padding: 15px;
  background: rgba(132,106,221,0.9);
}

.wrap-contact100{
  background: #fff;
  border-radius: 10px;
  overflow: hidden;

  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  padding: 110px 130px 157px 148px;
}

.title {
  font-family: Poppins-Bold;
  color: grey;
  font-size: 18px;
  font-weight: 500;
}

.button {
  font-family: sans-serif;
  font-size: 14px;
  line-height: 1.5;
  color: #fff;
  text-transform: uppercase;

  width: 100%;
  height: 40px;
  border-radius: 25px;
  background: #57b846;
  display: -webkit-box;
  display: -webkit-flex;
  display: -moz-box;
  display: -ms-flexbox;
  display: flex;
  justify-content: center;
  align-items: center;
  padding: 0 25px;

  -webkit-transition: all 0.4s;
  -o-transition: all 0.4s;
  -moz-transition: all 0.4s;
  transition: all 0.4s;
}

.button:hover {
  background-color: #333333;
}
</style>
</head>
<body style="background-color: #bcdee7;">

<h1 style="text-align: center;">Select your seller</h1>
<br>
<!--<div class="container-contact100">-->
<div class="wrap-contact100">
<div class="row">
<?php
session_start(); 
$name_seller="";
$seller_loc="";
$sellers=$_SESSION['sellers_available'];
$_SESSION['sellers_available1']=$sellers;
//$user=$_SESSION['sess_user1'];
//$_SESSION['sess_user2']=$user;
$category=$_SESSION['product'];
$_SESSION['product1']=$category;
$ip=$_SESSION['ip'];
$_SESSION['ip1']=$ip;
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

  <div class='column'>
    <div class='card'>
      <img src='./logo3.png' alt='Jane' style='width:100%'>
      <div class='container'>
        <h2>".$row['Name']."</h2>
        <p class='title'>".$row['Location']."</p>
        <p>
        <form method='POST' action=''>
        <input class='button' type='submit' name='".$row['SellerID']."' value='Proceed'>
        </form>
        </p>
      </div>
    </div>
  </div>";
}
      }
  }
}
for($i=0;$i<sizeof($sellers);$i++)
{
  $x=$sellers[$i];
if(isset($_POST[$x]))
{
  $_SESSION['selected_seller']=$x;
  header("Location: ../Cart/cart.php");
  exit();
}
}
?>
</div>
</div>
</body>
</html>