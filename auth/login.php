<?php
include "../connect.php";
$email=filterRequest("email");
$password=sha1($_POST["password"]);
$stat=$con->prepare("SELECT * FROM users WHERE user_email=? AND user_password=?  ");
$stat->execute(array($email,$password));
$data=$stat->fetch(PDO::FETCH_ASSOC);
$count=$stat->rowCount();
if($count>0){
    echo json_encode(array("status" => "success","data"=>$data));

}else{
    printfailur();
}