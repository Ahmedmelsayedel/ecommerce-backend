<?php
include "../connect.php";
$userid       =filterRequest("userid");
$price       =filterRequest("price");
$payment=filterRequest("payment");
$typedelvery =filterRequest("type");
$delveryprice =filterRequest("deleveryprice");
$coupon       =filterRequest("coupon");
$adress       =filterRequest("adress");
$coupondiscount=filterRequest("coupondiscount");
$couponname=filterRequest("name");
if($typedelvery=="receive"){
    $delveryprice=0;
}

$totalprice=$price+$delveryprice;

$checkcoupon= getcoupon(false,$couponname);
if($checkcoupon>0){
   $totalprice=($price-$price*$coupondiscount/100)+$delveryprice;
   $stat=$con->prepare("UPDATE coupon SET coupon_count=coupon_count-1 WHERE coupon_id=$coupon");
   $stat->execute();
}



$stat=$con->prepare("INSERT INTO orders (ordrer_userid,order_price,	paymentmethod,order_type,order_deleveryprice,order_coupon,order_adress,order_total)VALUES(?,?,?,?,?,?,?,?)");
$stat->execute(array($userid,$price,$payment,$typedelvery,$delveryprice,$coupon,$adress,$totalprice));
$count=$stat->rowCount();
if($count>0){
    $stat2=$con->prepare("SELECT MAX(ordre_id) FROM orders ");
    $stat2->execute();
    $data=$stat2->fetchColumn();
    $count2=$stat2->rowCount();
    if($count2>0){
        $stat3=$con->prepare("UPDATE cart SET cart_order=? WHERE cart_userid=? AND cart_order=? ");
        $stat3->execute(array($data,$userid,0));
        $count3=$stat3->rowCount();
        if($count3>0){
            printsuccess();
        }else{
            printfailur();
        }
    }else{
        return $count2;
    }


}else{
    return $count;
}

