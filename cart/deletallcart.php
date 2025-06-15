<?php
include "../connect.php";
$userid=filterRequest("id");
$state=$con->prepare("DELETE FROM cart WHERE cart_userid=?");
$state->execute(array($userid));
$count=$state->rowCount();
result($count);