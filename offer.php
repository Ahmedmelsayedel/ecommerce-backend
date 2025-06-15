<?php
include "../connect.php";

$stat=$con->prepare("SELECT itemview.*, 1 AS favourite ,(item_price-(item_price * item_discount/100)) AS pricediscount  FROM itemview
INNER JOIN favourite WHERE favourite.favourite_itemid=itemview.item_id AND itemview.item_discount!=0

UNION ALL 
SELECT itemview.*, 0 AS favourite ,(item_price-(item_price * item_discount/100)) AS pricediscount FROM itemview
WHERE  itemview.item_discount!=0 AND itemview.item_id  NOT IN (SELECT itemview.item_id FROM itemview
INNER JOIN favourite WHERE favourite.favourite_itemid=itemview.item_id  AND itemview.item_discount!=0 ) ");

$stat ->execute();
$data=$stat->fetchAll(PDO::FETCH_ASSOC);
$count=$stat->rowCount();
if($count>0){

    echo json_encode(array("status" => "success",  "data" => $data));
}else{
    echo json_encode(array("status" => "failure"));

}