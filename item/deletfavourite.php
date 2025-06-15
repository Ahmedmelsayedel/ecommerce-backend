<?php
include "../connect.php";
$userid=filterRequest("userid");
$itemid=filterRequest("itemid");
$stat=$con->prepare("DELETE FROM favourite WHERE favourite_userid=? AND favourite_itemid=?");
$stat->execute(array($userid,$itemid));


$count=$stat->rowCount();
if($count>0){
 printsuccess(); 
}else{
printfailur();
}