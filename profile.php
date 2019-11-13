<!DOCTYPE html>
<?php
  session_start();





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
	<!-- <div class="span6">Welcome!<strong> User</strong></div>
	<div class="span6">
	<div class="pull-right">
		<a href="product_summary.html"><span class="">Fr</span></a>
		<a href="product_summary.html"><span class="">Es</span></a>
		<span class="btn btn-mini">En</span>
		<a href="product_summary.html"><span>&pound;</span></a>
		<span class="btn btn-mini">$155.00</span>
		<a href="product_summary.html"><span class="">$</span></a>
		<a href="product_summary.html"><span class="btn btn-mini btn-primary"><i class="icon-shopping-cart icon-white"></i> [ 3 ] Itemes in your cart </span> </a>
	</div>
	</div> -->
</div>
<!-- Navbar ================================================== -->
<div id="logoArea" class="navbar">
<a id="smallScreen" data-target="#topMenu" data-toggle="collapse" class="btn btn-navbar">
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
	<span class="icon-bar"></span>
</a>
  <div class="navbar-inner">
    <a class="brand" href="index.php"><img src="themes/images/logo.png" alt="Bootsshop"/></a>
		<!-- <form class="form-inline navbar-search" method="post" action="products.html" >
		<input id="srchFld" class="srchTxt" type="text" />
		  <select class="srchTxt">
			<option>All</option>
			<option>CLOTHES </option>
			<option>FOOD AND BEVERAGES </option>
			<option>HEALTH & BEAUTY </option>
			<option>SPORTS & LEISURE </option>
			<option>BOOKS & ENTERTAINMENTS </option>
		</select>
		  <button type="submit" id="submitButton" class="btn btn-primary">Go</button>
    </form> -->
    <ul id="topMenu" class="nav pull-right">
	 <li class=""><a href="special_offer.html">Latest Products</a></li>
	 <li class=""><a href="cart.php">CART</a></li>
	 <li class=""><a href="contact.html">Contact</a></li>
   <li class=""><a href="profile.php">Your Profile</a></li>
	 <li class="">
	 <a href="logout.php"><span class="btn btn-large btn-success">Logout</span></a>
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
	<hr class="soften">
	<h1>Your Profile</h1>
	<hr class="soften"/>
	<div class="row">
		<div class="span4">

        <?php
          error_reporting(E_ALL);



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



      ?>
<?php
  $link = mysqli_connect("localhost", "root", "", "ecorp");

  if(!$link) {
      die("Connection failed: " . $link->connect_error);
    }
  $user=$_SESSION["username"];
  $d_fname= "SELECT * FROM customer WHERE email='$user'";
  $result = mysqli_query($link,$d_fname);
  if (mysqli_num_rows($result) >0) {
    while($row = mysqli_fetch_row($result)){
      $d_fname = $row[0];
      $d_lname = $row[1];
      $d_email = $row[2];
      $d_age = $row[4];
      $d_address1 = $row[5];
      $d_address2 = $row[6];
      $d_city = $row[7];
      $d_zip = $row[9];
      $d_country = $row[10];
      $d_mobile = $row[11];
    //  $decrypted=openssl_decrypt(hex2bin($encrypted),'AES-128-CBC',$key);
      // $key1 = "encryption key";

    }
  }
 ?>
		<h4>Personal Details :</h4><br/>
    <p>
      <h5>First Name : <?php
                        echo encrypt_decrypt('decrypt',"$d_fname");
                        // $key = "encryption key";
                        // $text="12345";
                        // $encrypted = bin2hex(openssl_encrypt($text,'AES-128-CBC', $key));
                        // $decrypted=openssl_decrypt(hex2bin($encrypted),'AES-128-CBC',$key);
                        // echo $encrypted;
                        // var_dump($encrypted,$decrypted);
                        ?>
                        <br/><br/>
      Last Name :<?php

                    echo encrypt_decrypt('decrypt',"$d_lname");

                  ?><br/><br/>
      Email :<?php

                echo encrypt_decrypt('decrypt',"$d_email");

                ?><br/><br/>
      Age :<?php
      // $i_age=encrypt_decrypt('decrypt',$d_age);
      // $n_age=(int)$i_age;
      echo $d_age;


              ?><br/><br/></h5>
    </p>
    <p>

      <br/><br/>
      <h4>Address </h4><br/>
      <h5>Address (Line 1) : <?php

      echo encrypt_decrypt('decrypt',"$d_address1");

      ?><br/><br/><br/>
      Address (Line 2) : <?php

      echo encrypt_decrypt('decrypt',"$d_address2");

      ?><br/><br/><br/></h5>
      </p>
			<br/><br/>

		</p>
		</div>

		<div class="span4">
		<h4>Address Details : </h4><br/>
    <h5>City : <?php

    echo encrypt_decrypt('decrypt',"$d_city");
    ?><br/><br/>
    ﻿<!-- State : <?php

    echo encrypt_decrypt('decrypt',"$d_state");

    ?><br/><br/> -->
    Zip Code : <?php

    // $i_zip=encrypt_decrypt('decrypt',$d_zip);
    // $n_zip=(int)$i_zip;
    echo $d_zip;

    ?><br/><br/>
    Country : <?php

    echo encrypt_decrypt('decrypt',$d_country);

    ?><br/><br/>
    Mobile Phone : <?php


    // $i_mobile=encrypt_decrypt('decrypt',$d_mobile);
    // $n_mobile=(int)$i_mobile;
    echo $d_mobile;
    ?><br/><br/></h5></div>
		<div class="span4">
		<!-- <h4>Email Us</h4>
		<form class="form-horizontal">
        <fieldset>
          <div class="control-group">

              <input type="text" placeholder="name" class="input-xlarge"/>

          </div>
		   <div class="control-group">

              <input type="text" placeholder="email" class="input-xlarge"/>

          </div>
		   <div class="control-group">

              <input type="text" placeholder="subject" class="input-xlarge"/>

          </div>
          <div class="control-group">
              <textarea rows="3" id="textarea" class="input-xlarge"></textarea>

          </div>
--><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/><br/>
            <!-- <button class="btn btn-large" type="Edit Details">Edit Details</button> -->

        </fieldset>
      </form>
		</div>
	</div>
	<!-- <div class="row">
	<div class="span12">
	<iframe style="width:100%; height:300; border: 0px" scrolling="no" src="https://maps.google.co.uk/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=18+California,+Fresno,+CA,+United+States&amp;aq=0&amp;oq=18+California+united+state&amp;sll=39.9589,-120.955336&amp;sspn=0.007114,0.016512&amp;ie=UTF8&amp;hq=&amp;hnear=18,+Fresno,+California+93727,+United+States&amp;t=m&amp;ll=36.732762,-119.695787&amp;spn=0.017197,0.100336&amp;z=14&amp;output=embed"></iframe><br />
	<small><a href="https://maps.google.co.uk/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=18+California,+Fresno,+CA,+United+States&amp;aq=0&amp;oq=18+California+united+state&amp;sll=39.9589,-120.955336&amp;sspn=0.007114,0.016512&amp;ie=UTF8&amp;hq=&amp;hnear=18,+Fresno,+California+93727,+United+States&amp;t=m&amp;ll=36.732762,-119.695787&amp;spn=0.017197,0.100336&amp;z=14" style="color:#0000FF;text-align:left">View Larger Map</a></small>
	</div>
	</div> -->
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
				<a href="login.html">DISCOUNT</a>
				<a href="login.html">ORDER HISTORY</a>
			 </div> -->
			<div class="span3">
				<h5>INFORMATION</h5>
				<a href="contact.html">CONTACT</a>
				<!-- <a href="register.html">REGISTRATION</a>
				<a href="legal_notice.html">LEGAL NOTICE</a> -->
				<a href="tac.html">TERMS AND CONDITIONS</a>
				<!-- <a href="faq.html">FAQ</a> -->
			 </div>
			<!-- <div class="span3">
				<h5>OUR OFFERS</h5>
				<a href="#">NEW PRODUCTS</a>
				<a href="#">TOP SELLERS</a>
				<a href="special_offer.html">SPECIAL OFFERS</a>
				<a href="#">MANUFACTURERS</a>
				<a href="#">SUPPLIERS</a>
			 </div> -->
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
