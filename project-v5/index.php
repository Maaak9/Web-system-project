<?php
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
<!-- <a href="#" class="w3-bar-item w3-button w3-padding"><i class="{$icon}"></i>  {$row->room_name}</a> -->
<?php
$indexContent = <<<END
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
  </header>
  <div class="w3-row w3-container">
END;
$query = <<<END
SELECT devices_proj.device_id, devices_proj.room_id, room_proj.room_name, devices_proj.type_id, devices_proj.description
FROM devices_proj INNER JOIN room_proj ON devices_proj.room_id=room_proj.room_id
INNER JOIN room_type_proj ON room_proj.type_id=room_type_proj.room_type_id;
END;
$res = $mysqli->query($query);
if ($res->num_rows > 0) {
 while ($row = $res->fetch_object()) {
  $icon = typeOfIcon($row->type_id);
  $indexContent .= <<<CONTENT
<div class="w3-third w3-container">
  <div class="w3-card-4" style="margin-top: 25px;">
    <img src="media/img/Lamp.jpg" style="width:100%">
    <div class="w3-container w3-center">
      <div class="w3-container w3-center row" style="height: 35px">
        <div class="row" style="height: inherit; margin-top: 6px;">
        <h4 style="">{$row->room_name}</h4>
        <h4 style="margin-left:10px;">|  {$row->description}  |</h4>
CONTENT;
        if(isset($_SESSION['super_user'])){
          $indexContent .= <<<CONTENT
          <a href="remove_device.php?id={$row->device_id}" onclick="return confirm('Are you sure you want to delete the device?')">
            <h4 style="color: black; margin-left:10px">X</h4>
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