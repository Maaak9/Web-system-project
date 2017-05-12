<?php
require_once('db.php');
//checks if you're logged in or not

$message = '';

 if(isset($_SESSION['super_user']) ){
	
 } else {
     header("Location: index.php");
 }


//check contet of form
/*
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
 */

require_once('dashboard.php');

echo $head;
echo $body;
?>

<?php
echo $end;
?>