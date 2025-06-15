<?php
include "../connect.php";
$id=filterRequest("id");

$stat=$con->prepare("DELETE FROM favourite WHERE favourite_id=?");
$stat->execute(array($id));


$count=$stat->rowCount();
if($count>0){
 printsuccess(); 
}else{
printfailur();
}