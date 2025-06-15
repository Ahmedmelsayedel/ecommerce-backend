<?php
include "../connect.php";
$userid=filterRequest("userid");
$itemid=filterRequest("itemid");
$state=$con->prepare("INSERT INTO cart (cart_userid,cart_itemid) VALUES (?,?) ");
$state ->execute(array($userid,$itemid));
$count=$state->rowCount();
if($count>0){
 printsuccess();


}else{
  printfailur();

}