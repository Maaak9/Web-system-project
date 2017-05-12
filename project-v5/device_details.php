<?php
require_once('db.php');
//checks if you're logged in or not

$message = '';
// if no session exists user gets routed to login page
if(!isset($_SESSION['user_id']) ){
    header("Location: login.php");
}
// if id and room_id dosen't exist route to index.php
if(!isset($_GET['id']) && !isset($_GET['room_id'])){
    header("Location: index.php");
}

function typeOfDevice($id){
    $returnValue = "";
    switch ($id){
        case 1:
            //on-off
            //channel
            //0-100
            $returnValue = "media/img/monitor.png"; //TV
            break;
        case 2:
            // on-off
            // maybe dim
            $returnValue = "media/img/desk-lamp.png"; // Lamp
            break;
        case 3:
            // on-off
            // temp
            $returnValue = tempType(); // Frezzer
            break;
        case 4:
            // on-off
            // temp
            $returnValue = tempType(); // Refrigerator
            break;
        case 5:
            //on-off
            //precentage
            $returnValue = "media/img/megaphone.png"; // Speaker
            break;
        case 6:
            //on-off
            //temp
            $returnValue = tempType(); // Temp
            break;
        default:
            $returnValue = "media/img/monitor.png";
            break;
}
return $returnValue;
}

// frezzer, refrigerator and temp
function tempType(){  
$tempContent = <<<CONTENT
<div class="w3-half w3-container">
  <div class="w3-card-4" style="margin-top: 25px; background: white; height: 500;">
    <hr>
    <div style="text-align: center;"><h3 style="">Insert data</h3></div>
    <hr>
    <div class="w3-container w3-center">
      <div class="w3-container w3-center row" style="height: 35px">
        <div class="row" style="height: inherit; margin-top: 10px;">
        <h6 style="margin-left:10px;">|  hejehej  |</h6>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="w3-half w3-container">
  <div class="w3-card-4" style="margin-top: 25px; background: white; height: 500;">
    <hr>
    <div style="text-align: center;"><h3 style="margin-t">Graphical history</h3></div>
    <hr>
    <div class="w3-container w3-center">
      <div class="w3-container w3-center row" style="height: 35px">
        <div class="row" style="height: inherit; margin-top: 10px;">
        <h6 style="margin-left:10px;">|  hejehej  |</h6>
        </div>
      </div>
    </div>
  </div>
</div>
CONTENT;
return $tempContent;
}

function lamp(){

}

function tv(){

}

function speaker(){

}


require_once('dashboard.php');


echo $head;
echo $body;

$query = <<<END
SELECT * FROM devices_proj
WHERE device_id = '{$_GET['id']}';
END;
$res = $mysqli->query($query);
if ($res->num_rows > 0) {
    $row = $res->fetch_object();
    $content = typeOfDevice($row->type_id);
}
echo $content;
?>

<?php

echo $end;
?>