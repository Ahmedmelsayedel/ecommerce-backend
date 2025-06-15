<?php
include "../connect.php";
$itemid=filterRequest("itemid");
$userid=filterRequest("userid");
$stat=$con->prepare("SELECT COUNT(cart.cartid) AS count FROM cart  WHERE cart_userid=? AND cart_itemid=? ");
$stat->execute(array($userid,$itemid));
$data=$stat->fetchColumn();
$count=$stat->rowCount();
if($count>0){
    echo json_encode(array("status" => "success", "data" => $data));

}else {
    echo json_encode(array("status" => "success", "data" => "0"));
}