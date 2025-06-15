<?php
include "../connect.php";
$id=filterRequest("id");
$rate=filterRequest("rate");
$note=filterRequest("note");
$state=$con->prepare("UPDATE orders SET order_rate=?,order_note=? WHERE ordre_id=?");
$state->execute(array($rate,$note,$id));
$count=$state->rowCount();
result($count)
;