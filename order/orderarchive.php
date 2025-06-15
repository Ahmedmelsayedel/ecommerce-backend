<?php
include "../connect.php";
$userid=filterRequest("id");
$stat=$con->prepare("SELECT * FROM orders WHERE ordrer_userid=? AND order_status=2");
$stat->execute(array($userid));
$data=$stat->fetchAll(PDO::FETCH_ASSOC);
$count=$stat->rowCount();
if($count>0){
    echo json_encode(array("status" => "success", "data" => $data));
}else{
    printfailur();

}