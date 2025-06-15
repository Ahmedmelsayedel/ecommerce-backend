<?php
include "../connect.php";
$username   =filterRequest("username");
$email      =filterRequest("email");
$phone      =filterRequest("phone");
$password=sha1($_POST["password"]);
$veryfy     =rand(10000,99999);
$stat=$con->prepare("SELECT * FROM users WHERE user_email=?  OR user_phone =?"  );
$stat->execute(array($email,$phone));
$count=$stat->rowCount();
if($count>0){

    printfailur();
}else{
  $data=array(
   "user_email"=>$email,
   "user_phone"=>$phone,
   "user_name"=>$username,
   "user_password"=>$password,
   "user_verify"=>$veryfy

  );
  //sendemail($email,"verfycode",$veryfy);

  insertData("users",$data);
}
