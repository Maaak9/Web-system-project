<?php

function typeOfIcon($value){
  $returnValue = "";
  switch ($value){
    case 1:
       $returnValue = "fa fa-coffee fa-fw"; // Kitchen
      break;
    case 2:
       $returnValue = "fa fa-users fa-fw"; // living room
      break;
    case 3: 
       $returnValue = "fa fa-bed fa-fw"; // bedroom
      break;
    case 4:
       $returnValue = "fa fa-briefcase fa-fw"; // hall
      break;
    case 5:
       $returnValue = "fa fa fa-bath fa-fw"; // bathroom
      break;  
    default:
       $returnValue = "fa-fw";
       break; 
  }
  return $returnValue;
 }

require_once('db.php');
$head = <<<END
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width; initial-scale=1.0; maximum-scale=1.0;">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="media/css/styles.css">
<!-- Icons -->
<link href="media/css/font-awesome.min.css" rel="stylesheet">
<link href="media/css/simple-line-icons.css" rel="stylesheet">

<!-- Main styles for this application -->
<link href="media/css/style.css" rel="stylesheet">
</head>
END;

$body = <<<END
<body>
<body class="w3-light-grey">

<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4; height: 40px;">
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <div id="test" class="col-md-6 col-md-offset-4" style="height: inherit;">
    <div id="menubar" class="col-md-3">Kitchen</div>
    <div id="menubar" class="col-md-3">Living room</div>
    <div id="menubar" class="col-md-3">Toilet</div>
    <div id="menubar" class="col-md-3">Hall</div>
  </div>
  <span class="w3-bar-item w3-right">Logo</span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse  w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
    </div>
  </div>
  <div class="w3-container">
    <h5>Dashboard</h5>
  </div>
  <div class="w3-bar-block">
      <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
      <a href="index.php" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-users fa-fw"></i>  All rooms</a>
      <a href="logout.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-sign-out fa-fw"></i>  Logout</a>
END;
$query = <<<END
SELECT room_name, room_id, type_id FROM room_proj
END;
$res = $mysqli->query($query);
if ($res->num_rows > 0) {
 while ($row = $res->fetch_object()) {
  $icon = typeOfIcon($row->type_id);
  $body .= <<<SIDEBAR
    <div class="w3-bar-item w3-button w3-padding">
     <a href="#" style="color: black;"><i class="{$icon}"></i>  {$row->room_name}</a>
SIDEBAR;
  if(isset($_SESSION['super_user'])){
    $body .=<<<SIDEBAR
     <a href="remove_room.php?id={$row->room_id}" style="color: black; float: right;" onclick="return confirm('Are you sure? All devices linked to that room will be removed aswell')">X</a>
     </div>
SIDEBAR;
  }
  else{
    $body .=<<<SIDEBAR
     </div>
SIDEBAR;
  }
  }
}
if(isset($_SESSION['super_user'])){
$body .= <<<SIDEBAR
  <br>
  <h5 class="w3-bar-item">Admin options</h5>
  <a href="register.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cog fa-fw"></i>  Register new account</a>
  <a href="newroom.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cog fa-fw"></i>  Add new room</a>
  <a href="add_device.php" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cog fa-fw"></i>  Add new device</a>

SIDEBAR;
}

$body .= <<<BODY
</div>
</nav>
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">
BODY;

$end = <<<END
  <!-- End page content -->
</div>

<script src="./media/js/sidebar.js"></script>
</body>
</html>
END;
?>
