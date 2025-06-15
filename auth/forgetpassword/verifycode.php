<?php
include "../connect.php";
$email=filterRequest("email");
$verify=filterRequest("verifycode");
$stat=$con->prepare("SELECT * FROM users WHERE user_email =? AND user_verify=?");
$stat->execute(array($email,$verify));
$count=$stat->rowCount();
result($count);