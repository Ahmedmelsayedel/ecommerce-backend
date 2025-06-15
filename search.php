<?php
include "../connect.php";
$search=filterRequest("search");
$stat=$con->prepare("SELECT * FROM itemview WHERE item_name_en LIKE '%$search%' OR item_name_ar LIKE '%$search%' ");
$stat->execute();
$data = $stat->fetchAll(PDO::FETCH_ASSOC);
$count  = $stat->rowCount();
if ($count > 0){
    echo json_encode(array("status" => "success", "data" => $data));
} else {
    echo json_encode(array("status" => "failure"));
}
