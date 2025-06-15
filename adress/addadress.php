<?php
include "../connect.php";
$userid=filterRequest("userid");
$city=filterRequest("city");
$street=filterRequest("street");

$stat=$con->prepare("INSERT INTO adress (user_id,city ,street  )VALUES (?,?,?)");
$stat->execute(array($userid,$city,$street,));
$count=$stat->rowCount();
result($count);