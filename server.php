<?php
	session_start();

	// variable declaration
	$username = "";
	$email    = "";
	$errors = array();
	$_SESSION['success'] = "";

	// connect to database
	$db = mysqli_connect('localhost', 'root', '', 'ecorp');

	// REGISTER USER
	if (isset($_POST['reg_user'])) {
		// receive all input values from the form
		$username = mysqli_real_escape_string($db, $_POST['username']);
		$email = mysqli_real_escape_string($db, $_POST['email']);
		$password_1 = mysqli_real_escape_string($db, $_POST['password_1']);
		$password_2 = mysqli_real_escape_string($db, $_POST['password_2']);

		// form validation: ensure that the form is correctly filled
		if (empty($username)) { array_push($errors, "Username is required"); }
		if (empty($email)) { array_push($errors, "Email is required"); }
		if (empty($password_1)) { array_push($errors, "Password is required"); }

		if ($password_1 != $password_2) {
			array_push($errors, "The two passwords do not match");
		}

		// register user if there are no errors in the form
		if (count($errors) == 0) {
			$password = md5($password_1);//encrypt the password before saving in the database
			$query = "INSERT INTO mytable1 (username, email, password)
					  VALUES('$username', '$email', '$password')";
			mysqli_query($db, $query);

			$_SESSION['username'] = $username;
			$_SESSION['success'] = "You are now logged in";
			header('location: index.php');
		}

	}

	// ...

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

	// LOGIN USER
	if (isset($_POST['login_user'])) {

		$username = encrypt_decrypt('encrypt',mysqli_real_escape_string($db, $_POST['username']));
		$password = md5(mysqli_real_escape_string($db, $_POST['password']));


		if (empty($username)) {
			array_push($errors, "Username is required");
		}
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		if (count($errors) == 0) {
			//$password = md5($password);
			$query = "SELECT cust_ID FROM customer WHERE email='$username' AND password='$password'";
			$results = mysqli_query($db, $query);



			if (mysqli_num_rows($results) >0) {
				while($row = mysqli_fetch_array($results)){
					$cust = $row[0];
				}
				$_SESSION['username'] = $username;
				$_SESSION['cust_id'] = $cust;
				$_SESSION['success'] = "You are now logged in";
				echo $cust;
				header('location: index.php');
			}else {
				array_push($errors, "Wrong username/password combination");
			}
		}
	}

	if (isset($_POST['verify_user'])) {

		$password = md5(mysqli_real_escape_string($db, $_POST['password']));
		if (empty($password)) {
			array_push($errors, "Password is required");
		}

		if (count($errors) == 0) {
			//$password = md5($password);
			$query = "SELECT cust_ID FROM customer WHERE password='$password'";
			$results = mysqli_query($db, $query);



			if (mysqli_num_rows($results) >0) {
				while($row = mysqli_fetch_array($results)){
					$cust = $row[0];
				}

				$_SESSION['cust_id'] = $cust;
				$_SESSION['success'] = "You have verified";
				echo $cust;
				header('location: ConfirmOrder.php');
			}else {
				array_push($errors, "Wrong password");
			}
		}
	}

?>
