<?php
require_once('db.php');
//checks if you're logged in or not

$message = '';

 if(isset($_SESSION['super_user']) ){
	
 } else {
     header("Location: index.php");
 }
//check contet of form
 if(!empty($_POST['room_name']) && !empty($_POST['room_id'])):

    //Add new room
    $sql = "INSERT INTO room_proj (type_id, room_name) VALUES (:room_id, :room_name)";
    $stmt = $conn->prepare($sql);
    
    $stmt->bindParam(':room_id', $_POST['room_id']);
    $stmt->bindParam(':room_name', $_POST['room_name']);
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
                            <h1>Add new room</h1>
                            <?php if(!empty($message)): ?>
                                <p><?= $message ?></p>
                            <?php endif; ?>
                            <form action="newroom.php" method="post">
                                <p class="text-muted"></p>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="icon-user"></i>
                                    </span>
                                    <input type="text" name="room_name" class="form-control" placeholder="Room name" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="fa fa-user-plus"></i>
                                    </span>
                                    <select class="form-control" name="room_id" placeholder="Room type" required>
                                    <option value="1" selected disabled>Kitchen</option>
                                    <option value="1">Kitchen</option>
                                    <option value="2">Living room</option>
                                    <option value="3">Bedroom</option>
                                    <option value="4">Hall</option>
                                    <option value="5">Bathroom</option>
                                    </select>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <button name="back" onclick="location.href='index.php';" class="btn btn-danger px-4">Go back</button>
                                    </div>
                                    <div class="col-6 text-right">
                                        <button type="submit" name="register" value="register" class="btn btn-primary px-4">Register</button>
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