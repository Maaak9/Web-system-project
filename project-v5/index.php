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
  <div class="w3-row w3-container" style="margin:50px 0">
END;
$query = <<<END
SELECT device_id, room_id, type_id FROM devices_proj
END;
$res = $mysqli->query($query);
if ($res->num_rows > 0) {
 while ($row = $res->fetch_object()) {
  $icon = typeOfIcon($row->type_id);
  $indexContent .= <<<CONTENT
<div class="w3-third w3-container">
  <div class="w3-topbar w3-border-amber">
    <img src="media/img/Lamp.jpg" style="width:100%">
    <h2>Lamps</h2>
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