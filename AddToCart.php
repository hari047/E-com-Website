<?php
  session_start();

  $cust = $_SESSION['cust_id'];
  $qty = $_POST["qty"];

  if($qty==0){
    $qty=1;
  }
  foreach ($_POST as $key => $value){
    $pid = $key;
  //  echo "$key";
  }


  $db = mysqli_connect("localhost","root","","ecorp");

  if(!$db)
    die("Cannot connect");
  $query = "insert into cart values('$cust','$pid','$qty')";

  $result = mysqli_query($db,$query);

  header('location: index.php');
?>
