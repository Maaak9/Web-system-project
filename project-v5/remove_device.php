<?php
include_once('db.php');

 if(isset($_SESSION['super_user']) ){
	
 } else {
     header("Location: index.php");
 }

if (isset($_GET['id'])) {
$query = <<<END
DELETE FROM devices_proj
WHERE device_id = '{$_GET['id']}'
END;
 $mysqli->query($query);

 header('Location:index.php');
}
echo $navigation;
?>
