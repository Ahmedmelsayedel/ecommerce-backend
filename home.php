<?php
include "connect.php";
$alldata=array();
$alldata["status"]="success";
$catagries=getAllData("catagries",null,null,false);
$alldata["catagries"]=$catagries;
$items=getAllData("itemview","1=1 ",null,false);
$titel=getAllData("title","1=1",null,false);
$alldata["items"]=$items;
$alldata["title"]=$titel;
echo json_encode($alldata);