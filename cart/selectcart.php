<?php
include "../connect.php";
$userid =filterRequest("userid");
$state=$con->prepare("SELECT * FROM cartview WHERE cartview.cart_userid=?");
$state->execute(array($userid));
$data=$state->fetchAll(PDO::FETCH_ASSOC);
$stat2=$con->prepare("SELECT SUM(cartview.totalprice)AS sumprice ,SUM(cartview.cartcount)AS sumcount FROM cartview 
WHERE cartview.cart_userid=? ");
$stat2->execute(array($userid));
$datatotal=$stat2->fetch(PDO::FETCH_ASSOC);
echo json_encode(array("status"=>"success",
"data"=>$data,
"total"=>$datatotal));