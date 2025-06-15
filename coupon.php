<?php
include "../connect.php";
$couponname=filterRequest("name");
$data=date("Y-m-d H:i:s" );
$stat=$con->prepare("SELECT * FROM `coupon` WHERE `coupon_name`=? AND `coupon_time`>? AND `coupon_ended`=0");
$stat->execute(array($couponname,$data));
$data=$stat->fetchAll(PDO::FETCH_ASSOC);
$count=$stat->rowCount();
if($count>0){
    echo json_encode(array("status" => "success", "data" => $data));
}else{
    printfailur();
}