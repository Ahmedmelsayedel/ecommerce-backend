<?php
include "../connect.php";
$email=filterRequest("email");
$veryfy     =rand(10000,99999);
$stat=$con->prepare("SELECT * FROM users WHERE user_email=?");
$stat->execute(array($email));
$count=$stat->rowCount();
result($count);
if($count>0){

    $data=$con->prepare("UPDATE users SET user_verify=? WHERE user_email=?");
    $data->execute(array($veryfy,$email));
}