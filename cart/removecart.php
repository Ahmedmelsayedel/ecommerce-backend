<?php
include "../connect.php";
$userid=filterRequest("userid");
$itemid=filterRequest("itemid");
$state=$con->prepare("DELETE FROM cart WHERE cart_userid=? AND cart_itemid=? LIMIT 1");
$state ->execute(array($userid,$itemid));
$count=$state->rowCount();
if($count>0){
 printsuccess();


}else{
  printfailur();

}