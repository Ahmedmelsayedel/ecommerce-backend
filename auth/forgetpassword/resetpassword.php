<?php
include "../connect.php";
$email=filterRequest("email");
$password=sha1($_POST["password"]);
$stat=$con->prepare("UPDATE users SET user_password=? WHERE user_email=?");
$stat->execute(array($password,$email));
$count=$stat->rowCount();
result($count);