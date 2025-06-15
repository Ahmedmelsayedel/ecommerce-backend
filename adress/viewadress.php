<?php
include "../connect.php";
$userid=filterRequest("userid");
$stat=$con->prepare("SELECT * FROM adress WHERE user_id=?");
$stat->execute(array($userid));
$data = $stat->fetchAll(PDO::FETCH_ASSOC);
$count=$stat->rowCount();
if($count>0){
    echo json_encode(array("status" => "success", "data" => $data));
}else{
    echo json_encode(array("status" => "failure"));
}
