<?php
require_once('db.php');
//checks if you're logged in or not

$message = '';

 if(isset($_SESSION['super_user']) ){
	
 } else {
     header("Location: index.php");
 }


//check contet of form
 if(!empty($_POST['device_typ']) && !empty($_POST['room_id']) && !empty($_POST['description'])):

    //Add new room
    $sql = "INSERT INTO devices_proj (user_id, room_id, description, type_id) VALUES (:user_id, :room_id, :description, :type_id)";
    $stmt = $conn->prepare($sql);
    
    $stmt->bindParam(':user_id', $_SESSION["user_id"]);
    $stmt->bindParam(':room_id', $_POST['room_id']);
    $stmt->bindParam(':description', $_POST['description']);
    $stmt->bindParam(':type_id', $_POST['device_typ']);
    if( $stmt->execute() ):
        $message = 'Success! Room was added';
    else:
        $message = 'Sorry there must have been an issue adding your room';
    endif;

 endif;

require_once('dashboard.php');

echo $head;
echo $body;
?>

<!-- conetent goes here-->
<body class="app flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card-group mb-0">
                    <div class="card p-3">
                        <div class="card-block">
                            <h1>Add new device</h1>
                            <?php if(!empty($message)): ?>
                                <p><?= $message ?></p>
                            <?php endif; ?>
                            <form action="add_device.php" method="post">
                                <p class="text-muted"></p>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="fa fa-life-ring"></i>
                                    </span>
                                    <select class="form-control" name="device_typ" placeholder="Device type" required>
                                    <option value="1" selected disabled>Type of device</option>
                                    <option value="1">Tv</option>
                                    <option value="2">Lamp</option>
                                    <option value="3">Frezzer</option>
                                    <option value="4">Refrigerator</option>
                                    <option value="5">Speaker</option>
                                    <option value="6">Temperatur sensor</option>
                                    </select>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="fa fa-trello"></i>
                                    </span>
                                    <select class="form-control" name="room_id" placeholder="Select room" required>
                                    <option value="0" selected disabled>Choose a room</option>
<?php
$query = <<<END
SELECT room_name, room_id, type_id FROM room_proj
END;
$res = $mysqli->query($query);
if ($res->num_rows > 0) {
while ($row = $res->fetch_object()) {
$options .= <<<OPTIONS
<option value="{$row->room_id}">{$row->room_name}</option>
OPTIONS;
}
}
echo $options
?>
                                    </select>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="fa fa-comment-o"></i>
                                    </span>
                                    <input type="text" name="description" class="form-control" placeholder="Description" required>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <button name="back" onclick="location.href='index.php';" class="btn btn-danger px-4">Go back</button>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="submit" name="register" value="register" class="btn btn-primary px-4">Add device</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php

echo $end;
?>