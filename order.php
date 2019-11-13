<?php
  session_start();
  $cust = $_SESSION["cust_id"];

  $db = mysqli_connect("localhost","root","","ecorp");

  $query = "select * from cart";

  $result = mysqli_query($db,$query);

  while($row = mysqli_fetch_array($result)){
    $cust = $row[0];
    $pid = $row[1];
    $qty = $row[2];

    $stmt = $db->prepare("INSERT INTO orders (cust_ID,pid,qty) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $cust,$pid,$qty);
    $stmt->execute();


    //$query2 =  "insert into orders values('$cust','$pid','$qty')";
    //$result2 = mysqli_query($db,$query2);
  }

  $query3 = "delete from cart where cust_ID = '$cust'";
  $result3 = mysqli_query($db,$query3);

  header('location: index.php');
 ?>
