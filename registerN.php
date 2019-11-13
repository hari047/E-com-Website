<?php


    // $servername = "localhost";
    // $username = "root";
    // $password = "";
    // $dbname = "ecorp";

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
    $fnameErr = $fnameErr = $emailErr = $ageErr = $address1Err = $address2Err = $cityErr = $StateErr = $zipErr = $countryErr = $mobileErr = $passwordErr = "";



    $link = mysqli_connect("localhost", "root", "", "ecorp");

    if(!$link) {
        die("Connection failed: " . $link->connect_error);
    }


    if (empty($_POST["fname"])) {
    $fnameErr = "Name is required";
  } else {
    $fname = test_input($_POST["fname"]);
    // check if name only contains letters and whitespace
    if (!preg_match("/^[a-zA-Z ]*$/",$fname)) {
      $fnameErr = "Only letters and white space allowed";
    }
  }


  if (empty($_POST["lname"])) {
  $lnameErr = "Name is required";
} else {
  $lname = test_input($_POST["lname"]);
  // check if name only contains letters and whitespace
  if (!preg_match("/^[a-zA-Z ]*$/",$lname)) {
    $lnameErr = "Only letters and white space allowed";
  }
}


    if (empty($_POST["email"])) {
    $emailErr = "Email is required";
  } else {
    $email = test_input($_POST["email"]);
    // check if e-mail address is well-formed
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $emailErr = "Invalid email format";
    }
  }

     if(!empty($_POST["password"]) ) {
        $password = test_input($_POST["password"]);
        if (strlen($_POST["password"]) <= '8') {
            $passwordErr = "Your Password Must Contain At Least 8 Characters!";
        }
        elseif(!preg_match("#[0-9]+#",$password)) {
            $passwordErr = "Your Password Must Contain At Least 1 Number!";
        }
        elseif(!preg_match("#[A-Z]+#",$password)) {
            $passwordErr = "Your Password Must Contain At Least 1 Capital Letter!";
        }
        elseif(!preg_match("#[a-z]+#",$password)) {
            $passwordErr = "Your Password Must Contain At Least 1 Lowercase Letter!";
        }
    }
    // Check length of inserted phone number
if (strlen($mobile) > 10) {

    $mobileErr = 'Error: Invalid phone number!';
} else {

    if (strlen($mobile) < 10) {
        $mobileErr = 'Error: Invalid phone number!';
    } else {

        // Check is phone number typed only with numbers not letters or some special signs
        if (!is_numeric($mobile)) {
            $mobileErr = 'Error: Your number contain some letter or special sign!';
        }
    }
}

if (empty($_POST["age"])) {
$ageErr = "Age is required";
}

if (empty($_POST["address1"])) {
$address1Err = "Address is required";
}
if (empty($_POST["address2"])) {
$address2Err = "Address is required";
}
if (empty($_POST["city"])) {
$cityErr = "City is required";
}
if (empty($_POST["state"])) {
$stateErr = "State is required";
}
if (empty($_POST["zip"])) {
$zipErr = "Zip is required";
}
if (empty($_POST["country"])) {
$countryErr = "Country is required";
}

function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

    $stmt = $link->prepare("INSERT INTO customer (first_name, last_name, email, password, age, address1, address2, city, state, zip, country, mobile) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssissssisi", $fname, $lname, $email, $password, $age, $address1, $address2, $city, $state, $zip, $country, $mobile);
    $stmt->execute();
    header('location: login.php');


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
