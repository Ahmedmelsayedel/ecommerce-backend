<?php
include "../connect.php";
$email=filterRequest("email");
$verify=filterRequest("verifycode");
$stat=$con->prepare("SELECT * FROM users WHERE user_email =? AND user_verify=?");
$stat->execute(array($email,$verify));
$count=$stat->rowCount();
if($count>0){

    $update=$con->prepare("UPDATE users SET user_approve=1");
    $update->execute();
    echo json_encode(array("status" => "success"));
}else{
    printfailur();
}