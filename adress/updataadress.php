<?php
include "../connect.php";
$adressid=filterRequest("adressid");
$city=filterRequest("city");
$street=filterRequest("street");

$stat=$con->prepare("UPDATE adress SET  adressid=? ,city=? ,street=?");
$stat->execute(array($adressid,$city,$street));
$count=$stat->rowCount();
result($count);