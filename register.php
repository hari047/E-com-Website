<!DOCTYPE html>
<?php
    session_start();

    // $servername = "localhost";
    // $username = "root";
    // $password = "";
    // $dbname = "ecorp";
    error_reporting(0);
    $fname = $_POST["fname"];
    $lname = $_POST["lname"];
    $email = $_POST["email"];
    $age = $_POST["age"];
    $address1 = $_POST["address1"];
    $address2 = $_POST["address2"];
    $city = $_POST["city"];
    $state = $_POST["state"];
    $zip = $_POST["zip"];
    $country = $_POST["country"];
    $mobile = $_POST["mobile"];
    $password = $_POST["password"];
    $fnameErr = $lnameErr = $fnameErr = $emailErr = $ageErr = $address1Err = $address2Err = $cityErr = $StateErr = $zipErr = $countryErr = $mobileErr = $passwordErr = "";



    $link = mysqli_connect("localhost", "root", "", "ecorp");

    if(!$link) {
        die("Connection failed: " . $link->connect_error);
    }
    $errFlag = 0;

    if (empty($_POST["fname"])) {
    $fnameErr = "Name is required";
    $errFlag = 1;
  } else {
    $fname = test_input($_POST["fname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
      $errFlag=1;
      $fnameErr = "Only letters and white space allowed";
    }
  }


  if (empty($_POST["lname"])) {
    $errFlag = 1;
  $lnameErr = "Name is required";
} else {
  $lname = test_input($_POST["lname"]);
  // check if name only contains letters and whitespace
  if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
    $errFlag = 1;
    $lnameErr = "Only letters and white space allowed";
  }
}


    if (empty($_POST["email"])) {
      $errFlag = 1;
    $emailErr = "Email is required";
  } else {

    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $errFlag = 1;
      $emailErr = "Invalid email format";
    }
  }

     if(!empty($_POST["password"]) ) {
        $password = test_input($_POST["password"]);
        if (strlen($_POST["password"]) <= '8') {
            $passwordErr = "Your Password Must Contain At Least 8 Characters!";
            $errFlag = 1;
        }
        elseif(!preg_match("#[0-9]+#",$password)) {
            $errFlag = 1;
            $passwordErr = "Your Password Must Contain At Least 1 Number!";
        }
        elseif(!preg_match("#[A-Z]+#",$password)) {
            $errFlag = 1;
            $passwordErr = "Your Password Must Contain At Least 1 Capital Letter!";
        }
        elseif(!preg_match("#[a-z]+#",$password)) {
            $errFlag = 1;
            $passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
        }
    }
    else {
      $errFlag=1;
      $passwordErr="Password is required";
    }
    // Check length of inserted phone number
    if(strlen($mobile)==0){
       $errFlag = 1;
     $mobileErr='Phone number is required';
   }

else if (strlen($mobile) > 10) {
    $errFlag = 1;
    $mobileErr = 'Error: Invalid phone number!';
}


else {

    if (strlen($mobile) < 10) {
        $errFlag = 1;
        $mobileErr = 'Error: Invalid phone number!';
    } else {

        // Check is phone number typed only with numbers not letters or some special signs
        if (!is_numeric($mobile)) {
            $errFlag = 1;
            $mobileErr = 'Error: Your number contain some letter or special sign!';
        }
    }
}

if (empty($_POST["age"])) {
  $errFlag = 1;
$ageErr = "Age is required";
}

if (empty($_POST["address1"])) {
$errFlag = 1;
$address1Err = "Address is required";
}
if (empty($_POST["address2"])) {
$errFlag = 1;
$address2Err = "Address is required";
}
if (empty($_POST["city"])) {
$errFlag = 1;
$cityErr = "City is required";
}
if (empty($_POST["state"])) {
$errFlag = 1;
$stateErr = "State is required";
}
if (empty($_POST["zip"])) {
$zipErr = "Zip is required";
$errFlag = 1;
}
if (empty($_POST["country"])) {
$errFlag = 1;
$countryErr = "Country is required";
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

function encrypt_decrypt($action, $string) {
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $secret_key = 'This is my secret key';
    $secret_iv = 'This is my secret iv';
    // hash
    $key = hash('sha256', $secret_key);

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
    $iv = substr(hash('sha256', $secret_iv), 0, 16);
    if ( $action == 'encrypt' ) {
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        $output = base64_encode($output);
    } else if( $action == 'decrypt' ) {
        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }
    return $output;
}





    if(!$errFlag){
      $key = "encryption key";
      $pw = md5($password);
      $e_fname=encrypt_decrypt('encrypt',$fname);
      $e_lname=encrypt_decrypt('encrypt',$lname);
      $e_email=encrypt_decrypt('encrypt',$email);
      // $age=(string)$age;
      // $e_age=encrypt_decrypt('encrypt',$age);
      $e_address1=encrypt_decrypt('encrypt',$address1);
      $e_address2=encrypt_decrypt('encrypt',$address2);
      $e_city=encrypt_decrypt('encrypt',$city);
      // $zip=(string)$zip;
      // $e_zip=encrypt_decrypt('encrypt',$zip);
      $e_country=encrypt_decrypt('encrypt',$country);
      $stmt = $link->prepare("INSERT INTO customer (first_name, last_name, email, password, age, address1, address2, city, state, zip, country, mobile) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
      $stmt->bind_param("ssssissssisi", $e_fname, $e_lname, $e_email, $pw, $age, $e_address1, $e_address2, $e_city, $state, $zip, $e_country, $mobile);
      $stmt->execute();
      $_SESSION['e_fname'] = $e_fname;
      $_SESSION['e_lname'] = $e_lname;
      $_SESSION['e_email'] = $e_email;
      $_SESSION['e_age'] = $e_age;
      $_SESSION['e_address1'] = $e_address1;
      $_SESSION['e_address2'] = $e_address2;
      $_SESSION['e_city'] = $e_city;
      $_SESSION['e_zip'] = $e_zip;
      $_SESSION['e_country'] = $e_country;
      $_SESSION['e_mobile'] = $e_mobile;
      header('location: login.php');
    }



    /*echo "\nFirst Name : $fname";
    echo "\n";
    echo "\nLast Name : $lname";
    echo "\nEmail : $email";
    echo "\nAge : $age";
    echo "\nAddress 1 : $address1";
    echo "\nAddress 2 : $address2";
    echo "\nCity : $city";
    echo "\nState : $state";
    echo "\nZip : $zip";
    echo "\nCountry : $country";
    echo "\nMobile phone : $mobile";
    */



?>


<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Bootshop online Shopping cart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
<!--Less styles -->
   <!-- Other Less css file //different less files has different color scheam
	<link rel="stylesheet/less" type="text/css" href="themes/less/simplex.less">
	<link rel="stylesheet/less" type="text/css" href="themes/less/classified.less">
	<link rel="stylesheet/less" type="text/css" href="themes/less/amelia.less">  MOVE DOWN TO activate
	-->
	<!--<link rel="stylesheet/less" type="text/css" href="themes/less/bootshop.less">
	<script src="themes/js/less.js" type="text/javascript"></script> -->

<!-- Bootstrap style -->
    <link id="callCss" rel="stylesheet" href="themes/bootshop/bootstrap.min.css" media="screen"/>
    <link href="themes/css/base.css" rel="stylesheet" media="screen"/>
<!-- Bootstrap style responsive -->
	<link href="themes/css/bootstrap-responsive.min.css" rel="stylesheet"/>
	<link href="themes/css/font-awesome.css" rel="stylesheet" type="text/css">
<!-- Google-code-prettify -->
	<link href="themes/js/google-code-prettify/prettify.css" rel="stylesheet"/>
<!-- fav and touch icons -->
    <link rel="shortcut icon" href="themes/images/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="themes/images/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="themes/images/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="themes/images/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="themes/images/ico/apple-touch-icon-57-precomposed.png">
	<style type="text/css" id="enject"></style>
  </head>
<body>
<div id="header">
<div class="container">
<div id="welcomeLine" class="row">
	<!-- <div class="span6">Welcome!<strong> User</strong></div> -->
	</div>
<!-- Navbar ================================================== -->
<div id="logoArea" class="navbar">
<a id="smallScreen" data-target="#topMenu" data-toggle="collapse" class="btn btn-navbar">
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</a>
  <div class="navbar-inner">
    <a class="brand" ><img src="themes/images/logo.png" alt="Bootsshop"/></a>
		<!-- <form class="form-inline navbar-search" method="post" action="products.html" >
		<input id="srchFld" class="srchTxt" type="text" />
		  <select class="srchTxt">
			<option>All</option>
			<option>CLOTHES </option>
			<option>FOOD AND BEVERAGES </option>
			<option>SPORTS & LEISURE </option>
			<option>BOOKS & ENTERTAINMENTS </option>
		</select>
		  <button type="submit" id="submitButton" class="btn btn-primary">Go</button>
    </form> -->
    <ul id="topMenu" class="nav pull-right">
	 <!-- <li class=""><a href="special_offer.html">Latest Products</a></li>
	 <li class=""><a href="product_summary.html">CART</a></li>
	 <li class=""><a href="contact.html">Contact</a></li>
	 <li class="">
	 < <a href="" role="button" data-toggle="modal" style="padding-right:0"><span class="btn btn-large btn-success">Login</span></a> --> -->
	<div id="login" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
			<h3>Login Block</h3>
		  </div>
		  <div class="modal-body">
			<form class="form-horizontal loginFrm">
			  <div class="control-group">
				<input type="text" id="inputEmail" placeholder="Email">
			  </div>
			  <div class="control-group">
				<input type="password" id="inputPassword" placeholder="Password">
			  </div>
			  <div class="control-group">
				<label class="checkbox">
				<input type="checkbox"> Remember me
				</label>
			  </div>
			</form>
			<button type="submit" class="btn btn-success">Sign in</button>
			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
		  </div>
	</div>
	</li>
    </ul>
  </div>
</div>
</div>
</div>
<!-- Header End====================================================================== -->
<div id="mainBody">
	<div class="container">
	<div class="row">
<!-- Sidebar ================================================== -->
<!-- <div id="sidebar" class="span3">
  <div class="well well-small"><a id="myCart" href="product_summary.html"><img src="themes/images/ico-cart.png" alt="cart">3 Items in your cart  <span class="badge badge-warning pull-right">$155.00</span></a></div>
  <ul id="sideManu" class="nav nav-tabs nav-stacked">
    <li class="subMenu"><a> ELECTRONICS [15]</a>
      <ul style="display:none">
      <li><a class="active" href="cameras.html"><i class="icon-chevron-right"></i>Cameras (5) </a></li>
      <li><a class="active" href="Computers.html"><i class="icon-chevron-right"></i>Computers, Tablets & laptop (5)</a></li>
      <li><a class="active" href="mobile.html"><i class="icon-chevron-right"></i>Mobile Phone (5)</a></li>

      </ul>
    </li>
    <li class="subMenu"><a> CLOTHES [5] </a>
    <ul style="display:none">
      <li><a href="clothes.html"><i class="icon-chevron-right"></i>Women's Clothing (1)</a></li>
      <li><a href="clothes.html"><i class="icon-chevron-right"></i>Women's Shoes (1)</a></li>
      <li><a href="clothes.html"><i class="icon-chevron-right"></i>Women's Hand Bags (1)</a></li>
      <li><a href="clothes.html"><i class="icon-chevron-right"></i>Men's Clothings  (1)</a></li>
      <li><a href="clothes.html"><i class="icon-chevron-right"></i>Men's Shoes (1)</a></li>
      </ul>
    </li> -->
    <!-- <li class="subMenu"><a>FOOD AND BEVERAGES [25]</a>
      <ul style="display:none">
      <li><a href="products.html"><i class="icon-chevron-right"></i>Angoves  (35)</a></li>
      <li><a href="products.html"><i class="icon-chevron-right"></i>Bouchard Aine & Fils (8)</a></li>
      <li><a href="products.html"><i class="icon-chevron-right"></i>French Rabbit (5)</a></li>
      <li><a href="products.html"><i class="icon-chevron-right"></i>Louis Bernard  (45)</a></li>
      <li><a href="products.html"><i class="icon-chevron-right"></i>BIB Wine (Bag in Box) (8)</a></li>
      </ul>
    </li> -->
    <!-- <li class="subMenu"><a> SPORTS & LEISURE [20] </a>
    <ul style="display:none">
      <li><a href="products.html"><i class="icon-chevron-right"></i>Women's (5)</a></li>
      <li><a href="products.html"><i class="icon-chevron-right"></i>Women's Shoes (5)</a></li>
      <li><a href="products.html"><i class="icon-chevron-right"></i>Men's  (5)</a></li>
      <li><a href="products.html"><i class="icon-chevron-right"></i>Men's Shoes (5)</a></li>
      </ul>
    </li> -->
    <!-- <li class="subMenu"><a> BOOKS  [5] </a>
    <ul style="display:none">
      <li><a class="active" href="books.html"><i class="icon-chevron-right"></i>Fiction (1)</a></li>
      <li><a href="books.html"><i class="icon-chevron-right"></i>Thriller (1)</a></li>
      <li><a href="books.html"><i class="icon-chevron-right"></i>Romantic  (1)</a></li>
      <li><a href="books.html"><i class="icon-chevron-right"></i>Textbooks (1)</a></li>
      </ul>
    </li>
  </ul>
  <br/>
    <div class="thumbnail">
    <img src="themes/images/products/panasonic.jpg" alt="Bootshop panasonoc New camera"/>
    <div class="caption">
      <h5>Panasonic</h5>
      <h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary">$222.00</a></h4>
    </div>
    </div><br/>
    <div class="thumbnail">
      <img src="themes/images/products/kindle.png" title="Bootshop New Kindel" alt="Bootshop Kindel">
      <div class="caption">
        <h5>Kindle</h5>
          <h4 style="text-align:center"><a class="btn" href="product_details.html"> <i class="icon-zoom-in"></i></a> <a class="btn" href="#">Add to <i class="icon-shopping-cart"></i></a> <a class="btn btn-primary">$222.00</a></h4>
      </div>
      </div><br/>
    <div class="thumbnail">
      <img src="themes/images/payment_methods.png" title="Bootshop Payment Methods" alt="Payments Methods">
      <div class="caption">
        <h5>Payment Methods</h5>
      </div>
      </div>
</div> -->
<!-- Sidebar end=============================================== -->
	<div class="span9">
    <ul class="breadcrumb">
		<li><a href="index.php">Home</a> <span class="divider">/</span></li>
		<li class="active">Registration</li>
    </ul>
	<h3> Registration</h3>
	<div class="well">
	<!--
	<div class="alert alert-info fade in">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>Lorem Ipsum is simply dummy</strong> text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s
	 </div>
	<div class="alert fade in">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>Lorem Ipsum is simply dummy</strong> text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s
	 </div>
	 <div class="alert alert-block alert-error fade in">
		<button type="button" class="close" data-dismiss="alert">×</button>
		<strong>Lorem Ipsum is simply</strong> dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s
	 </div> -->
	<form class="form-horizontal" action = "register.php" method = "post" >
		<h4>Your personal information</h4>
		<div class="control-group">
			<label class="control-label" for="inputFname1">First name <sup>*</sup></label>
			<div class="controls">
			  <input type="text" id="inputFname1" placeholder="First Name" name = "fname">
        <?php
        if($errFlag==1)
          echo $fnameErr ?>
			</div>
		 </div>
		 <div class="control-group">
			<label class="control-label" for="inputLnam">Last name <sup>*</sup></label>
			<div class="controls">
			  <input type="text" id="inputLnam" placeholder="Last Name" name = "lname">
        <?php
          if($errFlag==1)
        echo $lnameErr ?>
      </div>
		 </div>
		<div class="control-group">
		<label class="control-label" for="input_email">Email <sup>*</sup></label>
		<div class="controls">
		  <input type="text" id="input_email" placeholder="Email" name = "email">
      <?php
        if($errFlag==1)
      echo $emailErr ?>
		</div>
	  </div>
	<div class="control-group">
		<label class="control-label" for="inputPassword1">Password <sup>*</sup></label>
		<div class="controls">
		  <input type="password" id="inputPassword1" placeholder="Password" name = "password">
      <?php
        if($errFlag==1)
      echo $passwordErr ?>
    </div>
	  </div>
		<div class="control-group">
		<label class="control-label">Age <sup>*</sup></label>
		<div class="controls">
		  <input type = "text" placeholder="Age" name = "age">
      <?php
        if($errFlag==1)
      echo $ageErr ?>
		</div>
	  </div>

		<h4>Your address</h4>

		<div class="control-group">
			<label class="control-label" for="address">Address<sup>*</sup></label>
			<div class="controls">
			  <input type="text" id="address" placeholder="Address" name = "address1"/> <span>Street address, P.O. box, company name, c/o</span>
        <?php
            if($errFlag==1)
        echo $address1Err; ?>
      </div>
		</div>

		<div class="control-group">
			<label class="control-label" for="address2">Address (Line 2)<sup>*</sup></label>
			<div class="controls">
			  <input type="text" id="address2" placeholder="Adress line 2" name = "address2"/> <span>Apartment, suite, unit, building, floor, etc.</span>
        <?php
            if($errFlag==1)
        echo $address2Err; ?>
      </div>
		</div>
		<div class="control-group">
			<label class="control-label" for="city">City<sup>*</sup></label>
			<div class="controls">
			  <input type="text" id="city" placeholder="city" name = "city"/>
        <?php
          if($errFlag==1)
        echo $cityErr; ?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="state">State<sup>*</sup></label>
			<div class="controls">
			  <select id="state" name = "state" >
				<option value="">-</option>
				<option value="1">Andhra Pradesh</option><option value="2">Arunachal Pradesh</option><option value="3">Assam</option><option value="4">Bihar</option><option value="5">Chhattisgarh</option><option value="6">Goa</option><option value="7">Gujarat</option><option value="8">Haryana</option><option value="53">Himachal Pradesh</option><option value="9">Jammu & Kashmir</option><option value="10">Jharkhand</option><option value="11">Karnataka</option><option value="12">Kerala</option><option value="13">Madhya Pradesh</option><option value="14">Maharashtra</option><option value="15">Manipur</option><option value="16">Meghalaya</option><option value="17">Mizoram</option><option value="18">Nagaland</option><option value="19">Odisha</option><option value="20">Punjab</option><option value="21">Rajasthan</option><option value="22">Sikkim</option><option value="23">Tamil Nadu</option><option value="24">Telangana</option><option value="25">Tripura</option><option value="26">Uttar Pradesh</option><option value="27">Uttarakand</option><option value="28">West Bengal</option><option value="29">Andaman and Nicobar Islands</option><option value="30">Chandigarh</option><option value="31">Dadra and Nagar Haveli</option><option value="32">Daman and Diu</option><option value="33">Delhi</option><option value="34">Lakshwadeep</option><option value="35">Puducherry</option><option value="36">Oklahoma</option></select>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="postcode">Zip / Postal Code<sup>*</sup></label>
			<div class="controls">
			  <input type="text" id="postcode" placeholder="Zip / Postal Code" name = "zip"/>
        <?php
          if($errFlag==1)
        echo $zipErr; ?>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="country">Country<sup>*</sup></label>
			<div class="controls">
			<input type="text" placeholder="Country" name="country">
      <?php
        if($errFlag==1)
      echo $countryErr; ?>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="mobile">Mobile Phone </label>
			<div class="controls">
			  <input type="text"  name="mobile" id="mobile" placeholder="Mobile Phone" name = "mobile"/>
        <?php
        if($errFlag==1)
        echo $mobileErr; ?>
      </div>
		</div>

	<!-- <p><sup>*</sup>Required field	</p> -->

	<div class="control-group">
			<div class="controls">
				<input type="hidden" name="email_create" value="1">
				<input type="hidden" name="is_new_customer" value="1">
				<input class="btn btn-large btn-success" type="submit" value="Register" />
			</div>
		</div>
	</form>
</div>

</div>
</div>
</div>
</div>
<!-- MainBody End ============================= -->
<!-- Footer ================================================================== -->
	<div  id="footerSection">
	<div class="container">
		<div class="row">
			<!-- <div class="span3">
				<h5>ACCOUNT</h5>
				<a href="login.html">YOUR ACCOUNT</a>
				<a href="login.html">PERSONAL INFORMATION</a>
				<a href="login.html">ADDRESSES</a>
				<a href="login.html">ORDER HISTORY</a>
			 </div> -->
			<div class="span3">
				<h5>INFORMATION</h5>
				<a href="contact.html">CONTACT</a>
				<!-- <a href="register.html">REGISTRATION</a> -->
				<!-- <a href="legal_notice.html">LEGAL NOTICE</a> -->
				<a href="tac.html">TERMS AND CONDITIONS</a>
				<!-- <a href="faq.html">FAQ</a> -->
			 </div>
			<div id="socialMedia" class="span3 pull-right">
				<h5>SOCIAL MEDIA </h5>
				<a href="#"><img width="60" height="60" src="themes/images/facebook.png" title="facebook" alt="facebook"/></a>
				<a href="#"><img width="60" height="60" src="themes/images/twitter.png" title="twitter" alt="twitter"/></a>
				<a href="#"><img width="60" height="60" src="themes/images/youtube.png" title="youtube" alt="youtube"/></a>
			 </div>
		 </div>
		<p class="pull-right">&copy; ECORP</p>
	</div><!-- Container End -->
	</div>
<!-- Placed at the end of the document so the pages load faster ============================================= -->
	<script src="themes/js/jquery.js" type="text/javascript"></script>
	<script src="themes/js/bootstrap.min.js" type="text/javascript"></script>
	<script src="themes/js/google-code-prettify/prettify.js"></script>

	<script src="themes/js/bootshop.js"></script>
    <script src="themes/js/jquery.lightbox-0.5.js"></script>

	<!-- Themes switcher section ============================================================================================= -->
<div id="secectionBox">
<link rel="stylesheet" href="themes/switch/themeswitch.css" type="text/css" media="screen" />
<script src="themes/switch/theamswitcher.js" type="text/javascript" charset="utf-8"></script>
	<div id="themeContainer">
	<div id="hideme" class="themeTitle">Style Selector</div>
	<div class="themeName">Oregional Skin</div>
	<div class="images style">
	<a href="themes/css/#" name="bootshop"><img src="themes/switch/images/clr/bootshop.png" alt="bootstrap business templates" class="active"></a>
	<a href="themes/css/#" name="businessltd"><img src="themes/switch/images/clr/businessltd.png" alt="bootstrap business templates" class="active"></a>
	</div>
	<div class="themeName">Bootswatch Skins (11)</div>
	<div class="images style">
		<a href="themes/css/#" name="amelia" title="Amelia"><img src="themes/switch/images/clr/amelia.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="spruce" title="Spruce"><img src="themes/switch/images/clr/spruce.png" alt="bootstrap business templates" ></a>
		<a href="themes/css/#" name="superhero" title="Superhero"><img src="themes/switch/images/clr/superhero.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="cyborg"><img src="themes/switch/images/clr/cyborg.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="cerulean"><img src="themes/switch/images/clr/cerulean.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="journal"><img src="themes/switch/images/clr/journal.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="readable"><img src="themes/switch/images/clr/readable.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="simplex"><img src="themes/switch/images/clr/simplex.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="slate"><img src="themes/switch/images/clr/slate.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="spacelab"><img src="themes/switch/images/clr/spacelab.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="united"><img src="themes/switch/images/clr/united.png" alt="bootstrap business templates"></a>
		<p style="margin:0;line-height:normal;margin-left:-10px;display:none;"><small>These are just examples and you can build your own color scheme in the backend.</small></p>
	</div>
	<div class="themeName">Background Patterns </div>
	<div class="images patterns">
		<a href="themes/css/#" name="pattern1"><img src="themes/switch/images/pattern/pattern1.png" alt="bootstrap business templates" class="active"></a>
		<a href="themes/css/#" name="pattern2"><img src="themes/switch/images/pattern/pattern2.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern3"><img src="themes/switch/images/pattern/pattern3.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern4"><img src="themes/switch/images/pattern/pattern4.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern5"><img src="themes/switch/images/pattern/pattern5.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern6"><img src="themes/switch/images/pattern/pattern6.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern7"><img src="themes/switch/images/pattern/pattern7.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern8"><img src="themes/switch/images/pattern/pattern8.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern9"><img src="themes/switch/images/pattern/pattern9.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern10"><img src="themes/switch/images/pattern/pattern10.png" alt="bootstrap business templates"></a>

		<a href="themes/css/#" name="pattern11"><img src="themes/switch/images/pattern/pattern11.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern12"><img src="themes/switch/images/pattern/pattern12.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern13"><img src="themes/switch/images/pattern/pattern13.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern14"><img src="themes/switch/images/pattern/pattern14.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern15"><img src="themes/switch/images/pattern/pattern15.png" alt="bootstrap business templates"></a>

		<a href="themes/css/#" name="pattern16"><img src="themes/switch/images/pattern/pattern16.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern17"><img src="themes/switch/images/pattern/pattern17.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern18"><img src="themes/switch/images/pattern/pattern18.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern19"><img src="themes/switch/images/pattern/pattern19.png" alt="bootstrap business templates"></a>
		<a href="themes/css/#" name="pattern20"><img src="themes/switch/images/pattern/pattern20.png" alt="bootstrap business templates"></a>

	</div>
	</div>
</div>
<span id="themesBtn"></span>
</body>
</html>
