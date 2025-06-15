<?php
include "../connect.php";
$userid=filterRequest("userid");
$itemid=filterRequest("itemid");
$stat=$con->prepare("INSERT INTO favourite (favourite_itemid,favourite_userid) VALUES(?,?) ");
$stat->execute(array($itemid,$userid));


$count=$stat->rowCount();
if($count>0){
    printsuccess();
}else{
printfailur();
}