<?php
include "connect.php";
$state =$con->prepare("SELECT * FROM catagries");
$state->execute();
$data=$state->fetchAll(PDO::FETCH_ASSOC);

$count=$state->rowCount();
if($count>0){
    echo json_encode(array("status" => "success","data"=>$data));
}else{
    echo json_encode(array("status" => "failure"));
}