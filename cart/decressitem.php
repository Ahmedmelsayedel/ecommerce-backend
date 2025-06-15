<?php
include "../connect.php";
$itemid=filterRequest("itemid");
$userid=filterRequest("userid");
$stat=$con->prepare("SELECT cartview.item_count FROM cartview WHERE cartview.item_id=? AND cartview.user_id=?");
$stat->execute(array($itemid,$userid));

if($stat>0){
    $stat=$con->prepare("UPDATE cartview SET cartview.item_count=cartview.item_count-1");
    $stat->execute();
   $coun=$count=$stat->rowCount();
   if($coun>0){
    printsuccess();
   }
}else{
    printfailur();
}