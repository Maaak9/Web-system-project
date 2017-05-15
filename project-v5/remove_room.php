<?php
include_once('db.php');

 if(isset($_SESSION['super_user']) ){
	
 } else {
     header("Location: index.php");
 }

if (isset($_GET['id'])) {

/* gets all devices linked to the room
   and deletes all the statuses linked to those devices */

$query = <<<END
SELECT device_id FROM devices_proj
WHERE room_id = '{$_GET['id']}'
END;
$res = $mysqli->query($query);
if ($res->num_rows > 0) {
 while ($row = $res->fetch_object()) {
    $delete_query = <<<END
    DELETE FROM device_status_proj
    WHERE device_id = {$row->device_id}
END;
    $mysqli->query($delete_query);
 }
}

/* Removes all the devices linked to the room_id */

 $query = <<<END
DELETE FROM devices_proj
 WHERE room_id = '{$_GET['id']}'
END;
 $mysqli->query($query);
¨
/* Removes the room*/
 $query = <<<END
DELETE FROM room_proj
 WHERE room_id = '{$_GET['id']}'
END;
 $mysqli->query($query);
 header('Location:index.php');
}

?>
