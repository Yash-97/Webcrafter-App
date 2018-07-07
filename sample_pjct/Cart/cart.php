<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Webcrafter and Designers</title>

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="css/core-style.css">
    <link rel="stylesheet" href="style.css">

</head>

<body>
    <div style="background: blue; border-radius: 25px;">
</div>
    <div style="align-content: center; margin-left: 25%; margin-top: 50px;">
            <div style="max-width: 700px" class="row">
                    <div class="order-details-confirmation">
                        <div class="cart-page-heading">
                            <h5>Your Order</h5>
                            <p>The Details</p>
                        </div>
                        <ul class="order-details-form mb-4">
    <?php
session_start(); 
$selected_seller=$_SESSION['selected_seller'];
$ip=$_SESSION['ip1'];
$_SESSION['ip2']=$ip;
//$user=$_SESSION['sess_user2'];
$sellers=$_SESSION['sellers_available1'];
$category=$_SESSION['product1'];
$con=mysqli_connect('localhost','root','','WebDB') or die(mysqli_error());
//$query=mysqli_query($con,"SELECT * FROM Customer WHERE Email='".$user."'");
//$row=mysqli_fetch_assoc($query);
//echo "Welcome "."".$row['Name']."<br>";
//$custid=$row['CustID'];
$diff=$_SESSION['diff1'];
//$_SESSION['sess_user3']=$custid;
/*for($i=0;$i<sizeof($sellers);$i++)
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
                echo "SellerID : ".$row['SellerID']." Name : ".$row['Name']." Location : ".$row['Location']."<br>";
            }
        }
    }
}*/
$amt=0;
$amt=($diff+1)*100;
//echo "Product purchased : ".$category."<br>";
//echo "Amount : Rs.".$amt;
$query=mysqli_query($con,"SELECT * FROM Seller WHERE SellerID='".$selected_seller."'");
$numrows=mysqli_num_rows($query);  
        if($numrows!=0)
        {
            while($row=mysqli_fetch_assoc($query))
            {
                //echo "SellerID : ".$row['SellerID']." Name : ".$row['Name']." Location : ".$row['Location']."<br>";
                echo "<li><span>Product</span> <span>Total</span></li>
                            <li><span>".$category."</span> <span>Rs. ".$amt."</span></li>
                            <li><span>Seller</span> <span>".$row['Name']."</span></li>
                            <li><span>Total</span> <span>Rs. ".$amt."</span></li>";
            }
        }
if(isset($_POST['submit']))
{
    //$query1=mysqli_query($con,"INSERT INTO Orders VALUES('".$custid."".rand(100,99999)."','".$custid."','F')");
    header("Location: ../login_c.php");
    //header("Location: PaytmKit/TxnTest.php");
}
?>
    
                        </ul>

                        <div id="accordion" role="tablist" class="mb-4">
                            <div class="card">
                                <div class="card-header" role="tab" id="headingOne">
                                    <h6 class="mb-0">
                                        <a data-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne"><i class="fa fa-circle-o mr-3"></i>PayTM</a>
                                    </h6>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" role="tab" id="headingTwo">
                                    <h6 class="mb-0">
                                        <a class="collapsed" data-toggle="collapse" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"><i class="fa fa-circle-o mr-3"></i>cash on delievery</a>
                                    </h6>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" role="tab" id="headingThree">
                                    <h6 class="mb-0">
                                        <a class="collapsed" data-toggle="collapse" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree"><i class="fa fa-circle-o mr-3"></i>credit card</a>
                                    </h6>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header" role="tab" id="headingFour">
                                    <h6 class="mb-0">
                                        <a class="collapsed" data-toggle="collapse" href="#collapseFour" aria-expanded="true" aria-controls="collapseFour"><i class="fa fa-circle-o mr-3"></i>pay after delivery</a>
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <form method="POST" action="">
                            <input class="btn essence-btn" type="submit" name="submit" value="PLACE ORDER"><br>
                        </form>
                        
                    </div>
                </div>
            </div>
       

        <script src="js/bootstrap.min.js"></script>
        
        </body>

</html>