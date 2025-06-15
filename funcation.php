<?php

// ==========================================================
//  Copyright Reserved Wael Wael Abo Hamza (Course Ecommerce)
// ==========================================================

define("MB", 1048576);

function filterRequest($requestname)
{
  return  htmlspecialchars(strip_tags($_POST[$requestname]));
}

function getAllData($table, $where = null, $values = null,$json=true)
{
    global $con;
    $data = array();
    if($where==null){
    $stmt = $con->prepare("SELECT  * FROM $table  ");
    }else{
     $stmt = $con->prepare("SELECT  * FROM $table WHERE   $where ");
    }
    
    $stmt->execute($values);
    $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $count  = $stmt->rowCount();
    if($json==true){
        if ($count > 0){
            echo json_encode(array("status" => "success", "data" => $data));
        } else {
            echo json_encode(array("status" => "failure"));
        }
        return $count;
    }else{
        if($count>0){
            return $data;
        }else{
            return json_encode(array("status" => "failure"));
        }
    }
    
    }
  


function insertData($table, $data, $json = true)
{
    global $con;
    foreach ($data as $field => $v)
        $ins[] = ':' . $field;
    $ins = implode(',', $ins);
    $fields = implode(',', array_keys($data));
    $sql = "INSERT INTO $table ($fields) VALUES ($ins)";

    $stmt = $con->prepare($sql);
    foreach ($data as $f => $v) {
        $stmt->bindValue(':' . $f, $v);
    }
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
  }
    return $count;
}


function updateData($table, $data, $where, $json = true)
{
    global $con;
    $cols = array();
    $vals = array();

    foreach ($data as $key => $val) {
        $vals[] = "$val";
        $cols[] = "`$key` =  ? ";
    }
    $sql = "UPDATE $table SET " . implode(', ', $cols) . " WHERE $where";

    $stmt = $con->prepare($sql);
    $stmt->execute($vals);
    $count = $stmt->rowCount();
    if ($json == true) {
    if ($count > 0) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "failure"));
    }
    }
    return $count;
}

function deleteData($table, $where, $json = true)
{
    global $con;
    $stmt = $con->prepare("DELETE FROM $table WHERE $where");
    $stmt->execute();
    $count = $stmt->rowCount();
    if ($json == true) {
        if ($count > 0) {
            echo json_encode(array("status" => "success"));
        } else {
            echo json_encode(array("status" => "failure"));
        }
    }
    return $count;
}

function imageUpload($imageRequest,$uel)
{
    if(isset($_FILES[$imageRequest])){
        global $msgError;
        $imagename  = rand(1000, 10000) . $_FILES[$imageRequest]['name'];
        $imagetmp   = $_FILES[$imageRequest]['tmp_name'];
        $imagesize  = $_FILES[$imageRequest]['size'];
        $allowExt   = array("jpg", "png", "gif", "mp3", "pdf","svg");
        $strToArray = explode(".", $imagename);
        $ext        = end($strToArray);
        $ext        = strtolower($ext);
      
        if (!empty($imagename) && !in_array($ext, $allowExt)) {
          $msgError = "EXT";
        }
        if ($imagesize > 2 * MB) {
          $msgError = "size";
        }
        if (empty($msgError)) {
          move_uploaded_file($imagetmp,  $uel."/" . $imagename);
          return $imagename;
        } else {
          return "fail";
        }
   }else{
        return "empty";
    }
 
}



function deleteFile($dir, $imagename)
{
    if (file_exists($dir . "/" . $imagename)) {
        unlink($dir . "/" . $imagename);
    }
}

function checkAuthenticate()
{
    if (isset($_SERVER['PHP_AUTH_USER'])  && isset($_SERVER['PHP_AUTH_PW'])) {
        if ($_SERVER['PHP_AUTH_USER'] != "wael" ||  $_SERVER['PHP_AUTH_PW'] != "wael12345") {
            header('WWW-Authenticate: Basic realm="My Realm"');
            header('HTTP/1.0 401 Unauthorized');
            echo 'Page Not Found';
            exit;
        }
    } else {
        exit;
    }

    // End 
}
function printfailur(){
    echo json_encode(array("status"=>"failur"));
}
function printsuccess(){
    echo json_encode(array("status"=>"success"));
}
function sendemail($to , $title, $body){
$header ="From:support@ahmedmohamed.com"."\n"."CC:ahmed1212@gmail.com";
mail($to,$title,$body,$header);

}
function result($count){
if($count>0){
    printsuccess();
}else{
    printfailur();
}

}
function getcoupon($josn=true,$couponname){
    global $con;
    $couponname=filterRequest("name");
    $data=date("Y-m-d H:i:s" );
    $stat=$con->prepare("SELECT * FROM `coupon` WHERE `coupon_name`=? AND `coupon_time`>? AND `coupon_ended`=0");
    $stat->execute(array($couponname,$data));
    $data=$stat->fetchAll(PDO::FETCH_ASSOC);
    $count=$stat->rowCount();
    if($josn==true){
        if($count>0){
            echo json_encode(array("status" => "success", "data" => $data));
        }else{
            printfailur();
        }
    }else{
        return$count;
    }
}

function sendGCM($title, $message, $topic, $pageid, $pagename)
{


    $url = "https://fcm.googleapis.com/v1/projects/myproject-b5ae1/messages:send";

    $fields = array(
        "to" => '/topics/' . $topic,
        'priority' => 'high',
        'content_available' => true,

        'notification' => array(
            "body" =>  $message,
            "title" =>  $title,
            "click_action" => "FLUTTER_NOTIFICATION_CLICK",
            "sound" => "default"

        ),
        'data' => array(
            "pageid" => $pageid,
            "pagename" => $pagename
        )

    );


    $fields = json_encode($fields);
    $headers = array(
        'Authorization:Bearer' . 'ya29MIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQC8Qgss5gdnBdIA\nKbwU09AyuRlF7iCjd3XPWxyQ6t39S/jx35ZlUExh6uBkixXyYfAkrFr2J6JGEsXd\nqoU5Cokb2HoJk0+0pyWNdlbU/fEYdsLrN8DRkSbfepUD+hawd6zLZfZvyUkfT7uc\nJ3/YyqfLndivgv/IMvrJqQfCg2Bf1K3BxfkfHkpuI2aIG6YGzx6bYocVvZ75NXjJ\n9EqgosuNMS6OaF222+s+k/ohvpH0xlFF4pGBe2QsVgR94Ga3+ikEr+1T514uJqVk\npSE85bjbWlARpYFkqB1Xob4DCCQFCKnEhsgL1xymjx67cftqcpWWgW1iuGK74zJW\npAJYp3MBAgMBAAECggEAPy87aPpbiaxea0eWpLbireOKI/pkYfj6RXojAFCT6SvS\nhfuxEpf8yvB2F8jGuO8+FlDyxqNOx44NcvSEejybAAmMDCKxIcTnya7qPdptTPSv\nPxsbUDsTfPY7hXYun1PLXwj9yU8Zh7TPFv363txFrQVxcJbbGmph2cUtoY9OjVrU\nEr7+t/4heyFEfzf6hK8p+j+Gduil9rK+dZ+Dgrz0+gSpayKar0quY2mylaXMMyzg\nEHx+aa75aw0XMzDKgEQuxU+YKyDIIH0XrRVAIls2EDE+hUCgAZIm72flVy5i+7cf\nK8VmTIMipQgy97Pniu/rnXfNqWf7pDM+3dWQhEe7cQKBgQD2H1ldQ56PHmbppUs7\nw/LIY+aRrN0bCUd37JAxZ/PE0OFbtRRY9qpzIjiCOmGYfbpakCfw0AacfJ5bvTxi\nBj0jZ5iIYuKwJUBs3NS8+DQ5z4r4/nldzKpoKP8ZZ7eVPhLZ4DmbTPg7PDGc3pnu\njbTojNc/PFw6r7BlAiLKhWa6GwKBgQDD0DKV6QlIB3/JLqUZh2o/qw9i+CI9RqbD\nLTVAiISqYnGU70E8dCegctp9ozQr9vbiNdbCU4pwJDZyJDg58I4Pa0w3PYq3nC6E\nY1n9qwbHNi6avDg6eQHwMcSeYRQy2vQyFj9HEqanOJzSE4Lpcr5wCTS8IA5aRvZi\nzVqNC0EZEwKBgA1PNK3uciybIEWSQrdAqWhcvqMyDeLgZZT+ne2OCYijIwyqhicp\nb546Q4QHVC/C3Mj48q/7D+B2fLnJSfKjE7tOZtk5P7j2yr0YVAjEA079Ai7k0/tW\njgCD9weQrETNzocpsPPM/b92SdiJ0RktYJMSyrEIupQR3CAaNXduL1fxAoGAVYL6\nVFUsZHRB7c2c9AUa9Sry0TmjWjccZGe9tazooq/TAkNprcjb9Umy+OLoybpUHn18\nh+iLsGVgEYCXvVW79CfbZNRPW9esyMvKZOjnUN/sgk5oD8EAg7B4OOIUPBE6SxVE\nFPmkJaqncWZr6R7e43ZhvTYSjoIm3wbm4GllyFkCgYB7bkVAi90Qu0B9o4VlhDvU\n9qBr5/H7Ybdp6/VILKd2D1B6w4lM7ieZxNxcfwpp0ReOnabZ+4l4f+uRdSXbhLEL\nDKUJvSpHj3fikbJQQiO2shNi2SWr8OVSo5TD/pwBorHGOqzxM4YCDZG5gKv2DNyy\n4eFW08AxLd1HqpYf/Gm9JA',
        'Content-Type: application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);

    $result = curl_exec($ch);
    return $result;
    curl_close($ch);
}