<?php
include "../connect.php";
$adressid=filterRequest("id");
$stat=$con->prepare("DELETE FROM adress WHERE adressid=?");
$stat->execute(array($adressid));
$count=$stat->rowCount();
result($count);