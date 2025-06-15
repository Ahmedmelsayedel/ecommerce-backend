<?php
include "../connect.php";
$itemid=filterRequest("itemid");
$userid=filterRequest("userid");
$stat=$con->prepare("UPDATE cartview SET cartview.item_count=cartview.item_count+1  WHERE cartview.item_id=? AND cartview.user_id=?");
$stat->execute(array($itemid,$userid));
$count=$stat->rowCount();
result($count);