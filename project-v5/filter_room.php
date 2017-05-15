<?php

function typeOfImage($value){
  $returnValue = "";
  switch ($value){
    case 1:
       $returnValue = "media/img/monitor.png"; //TV
      break;
    case 2:
       $returnValue = "media/img/desk-lamp.png"; // Lamp
      break;
    case 3: 
       $returnValue = "media/img/freezer.png"; // Frezzer
      break;
    case 4:
       $returnValue = "media/img/refrigerator.png"; // Refrigerator
      break;
    case 5:
       $returnValue = "media/img/megaphone.png"; // Speaker
      break;
    case 6:
      $returnValue = "media/img/thermometer.png"; // Temp
      break;
    default:
       $returnValue = "media/img/monitor.png";
       break; 
  }
  return $returnValue;
 }

require_once('db.php');
//checks if you're logged in or not

 if(!isset($_SESSION['user_id']) ){
	header("Location: login.php");
 }

require_once('dashboard.php');

echo $head;
echo $body;
?>

<!-- conetent goes here-->
<!-- All of the devices are rendered below -->
<?php
$indexContent = <<<END
  <div class="w3-row w3-container">
END;
//query for information about the devices and rendered one by one.
$query = <<<END
SELECT devices_proj.device_id, devices_proj.room_id, room_proj.room_name, devices_proj.type_id, devices_proj.description
FROM devices_proj
INNER JOIN room_proj ON devices_proj.room_id=room_proj.room_id
INNER JOIN room_type_proj ON room_proj.type_id=room_type_proj.room_type_id
WHERE devices_proj.room_id = '{$_GET['id']}';
END;
$res = $mysqli->query($query);
if ($res->num_rows > 0) {
 while ($row = $res->fetch_object()) {
  $img = typeOfImage($row->type_id);
  $indexContent .= <<<CONTENT
<div class="w3-third w3-container">
  <div class="w3-card-4" style="margin-top: 25px; background: white;">
    <div style="text-align: center;"><h6 style="">{$row->room_name}</h6></div>
    <a href="device_details.php?id={$row->device_id}&room_id={$row->room_id}&des={$row->description}"><img src="{$img}" style="margin-left: 5%; width: 90%;"></a>
    <div class="w3-container w3-center">
      <div class="w3-container w3-center row" style="height: 35px">
        <div class="row" style="height: inherit; margin-top: 10px;">
        <h6 style="margin-left:10px;">|  {$row->description}  |</h6>
CONTENT;
        if(isset($_SESSION['super_user'])){
          $indexContent .= <<<CONTENT
          <a href="remove_device.php?id={$row->device_id}" onclick="return confirm('Are you sure you want to delete the device?')">
            <h6 style="color: black; margin-left:10px">X</h6>
          </a>
CONTENT;
        }
        $indexContent .= <<<CONTENT
        </div>
      </div>
    </div>
  </div>
</div>
CONTENT;
  }
}
$indexContent .= <<<END
	</div>
END;
echo $indexContent;
echo $end;
?>