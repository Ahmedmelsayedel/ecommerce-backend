<?php
include "../connect.php";
$orderid=filterRequest("id");
$stat=$con->prepare("DELETE FROM orders WHERE ordre_id=? AND order_status=0");
$stat->execute(array($orderid));
$count=$stat->rowCount();
result($count);