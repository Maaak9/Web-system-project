<?php
require_once('db.php');
//checks if you're logged in or not

$message = ' ';
$on_off = 0;
// if no session exists user gets routed to login page
if(!isset($_SESSION['user_id']) ){
    header("Location: login.php");
}
// if id and room_id dosen't exist route to index.php
if(!isset($_GET['id']) && !isset($_GET['room_id'])){
    header("Location: index.php");
}


//check contet of form if frezzer/ refrigeragor / ac have been updated
// if true query the db with new values
 if(!empty($_POST['temprature'])):
    if(!empty($_POST['checkbox'])){
        $ONOFF = 1;
    }
    else{
        $ONOFF = 0;
    }
    $temp = $_POST['temprature'];
    $device_id = $_GET['id'];
    $created_at = date('Y-m-d H:i:s');
    $query = <<<END
    INSERT INTO device_status_proj(	device_id,on_off,temprature, time_stamp)
    VALUES('{$device_id}' , '{$ONOFF}' , '{$temp}' , '{$created_at}')
END;
    $result = $conn->prepare($query);
    if ( $result->execute() ):
        $message = 'Success! Updated';
    else:
        $message = 'Sorry there must have been an issue updating your device';
    endif;    
endif;

if(!empty($_GET['type'])){
    //check contet of form Lamp
    if($_GET['type'] == 1):
        if(!empty($_POST['checkbox'])){
            $ONOFF = 1;
        }
        else {
            $ONOFF = 0;
        }
        $device_id = $_GET['id'];
        $created_at = date('Y-m-d H:i:s');
        $query = <<<END
        INSERT INTO device_status_proj(	device_id, on_off, time_stamp)
        VALUES('{$device_id}' , '{$ONOFF}' , '{$created_at}')
END;
        $result = $conn->prepare($query);
        if ( $result->execute() ):
            $message = 'Success! Updated';
        else:
            $message = 'Sorry there must have been an issue updating your device';
        endif;    
    endif;

    //check contet of form TV
    if($_GET['type'] == 2):
        if(!empty($_POST['checkbox'])){
            $ONOFF = 1;
        }
        else {
            $ONOFF = 0;
        }
        $channel = $_POST['channel'];
        $volume = $_POST['volume'];
        $device_id = $_GET['id'];
        $created_at = date('Y-m-d H:i:s');
        $query = <<<END
        INSERT INTO device_status_proj(	device_id, precentage, channel, on_off, time_stamp)
        VALUES('{$device_id}' , '{$volume}' , '{$channel}' , '{$ONOFF}' , '{$created_at}')
END;
        $result = $conn->prepare($query);
        if ( $result->execute() ):
            $message = 'Success! Updated';
        else:
            $message = 'Sorry there must have been an issue updating your device';
        endif;    
    endif;

    
    //check contet of form
    if($_GET['type'] == 3):
        if(!empty($_POST['checkbox'])){
            $ONOFF = 1;
        }
        else {
            $ONOFF = 0;
        }
        $volume = $_POST['volume'];
        $device_id = $_GET['id'];
        $created_at = date('Y-m-d H:i:s');
        $query = <<<END
        INSERT INTO device_status_proj(	device_id, precentage, on_off, time_stamp)
        VALUES('{$device_id}' , '{$volume}' , '{$ONOFF}' , '{$created_at}')
END;
        $result = $conn->prepare($query);
        if ( $result->execute() ):
            $message = 'Success! Updated';
        else:
            $message = 'Sorry there must have been an issue updating your device';
        endif;    
    endif;
}

$query = <<<END
SELECT * FROM device_status_proj WHERE device_id = '{$_GET['id']}'
END;
//check on/off
$on_off = " ";
$res = $mysqli->query($query);
if ($res->num_rows > 0) {
 while ($row = $res->fetch_object()) {
    if($row->on_off == 1){
        $on_off = "checked";
    }
    else{
        $on_off = " ";
    }
 }
}

function typeOfDevice($id){
    $returnValue = "";
    switch ($id){
        case 1:
            //on-off
            //channel
            //0-100
            $returnValue = tv(); //TV
            break;
        case 2:
            // on-off
            // maybe dim
            $returnValue = lamp(); // Lamp
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
            $returnValue = speaker(); // Speaker
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


// add 2 cards for frezzer, refrigerator and temp with input and graphical representation
function tempType(){  

global $on_off;
global $message;
$tempContent = <<<CONTENT
<div class="w3-rest w3-container" style="">
    <h3 style="font-size=30; margin-top: 15px; text-align: center;">{$_GET['des']}</h3> 
</div>
<!-- INSERT CARD -->
<div class="w3-half w3-container">
  <div class="w3-card-4" style="margin-top: 25px; background: white;">
    <hr>
    <div style="text-align: center;"><h3 style="">Insert data</h3></div>
    <hr>
    <div class="w3-container w3-center">
        <form action="device_details.php?id={$_GET['id']}&room_id={$_GET['room_id']}&des={$_GET['des']}" method="post">
            <p class="text-muted">Update information</p>
            <p>{$message}</p>
            <div class="input-group mb-3">
                <span class="input-group-addon"><i class="fa fa-thermometer-empty"></i>
                </span>
                <input type="number" name="temprature" class="form-control" placeholder="Current temprature" required>
            </div>
            <p class="text-muted">Switch off/on</p>
            <!-- Rounded switch -->
            <label class="switch">
            <input type="checkbox" name="checkbox" {$on_off}>
            <div class="slider round"></div>
            </label>
            <div class="row">
                <div class="col-6">
                    <button name="back" onclick="location.href='index.php';" class="btn btn-danger px-4">Go back</button>
                </div>
                <div class="col-6">
                    <button type="submit" name="update" value="update" class="btn btn-primary px-4">Update</button>
                </div>
            </div>
        </form>  
      <div class="w3-container w3-center row" style="height: 35px">
        <div class="row" style="height: inherit; margin-top: 10px;">
        </div>
      </div>
    </div>
  </div>
</div>
CONTENT;

$tempContent .= <<<CONTENT
<!-- HISTORY GRAPH CARD -->
<div class="w3-half w3-container">
  <div class="w3-card-4" style="margin-top: 25px; background: white; height: 400;">
    <hr>
    <div style="text-align: center;"><h3 style="margin-t">Graphical history</h3></div>
    <hr>
    <div class="w3-container w3-center" >
    </div>
    <div id="curve_chart" style="width: inherit; height: 300"></div>
  </div>
</div>
CONTENT;
return $tempContent;
}

function lamp(){
global $mysqli;
global $on_off;

global $message;

$tempContent = <<<CONTENT
<div class="w3-rest w3-container" style="">
    <h3 style="font-size=30; margin-top: 15px; text-align: center;">{$_GET['des']}</h3> 
</div>
<div class="w3-half w3-container">
  <div class="w3-card-4" style="margin-top: 25px; background: white;">
    <hr>
    <div style="text-align: center;"><h3 style="">Insert data</h3></div>
    <hr>
    <div class="w3-container w3-center">
        <form action="device_details.php?id={$_GET['id']}&room_id={$_GET['room_id']}&type=1&des={$_GET['des']}" method="post">
            <p class="text-muted">Update information</p>
            <p>{$message}</p>
            <p class="text-muted">Switch off/on</p>
            <!-- Rounded switch -->
            <label class="switch">
            <input type="checkbox" name="checkbox" {$on_off}>
            <div class="slider round"></div>
            </label>
            <div class="row">
                <div class="col-6">
                    <button name="test" onclick="location.href=index.php;" class="btn btn-danger px-4">Go back</button>
                </div>
                <div class="col-6">
                    <button type="submit" name="update" value="update" class="btn btn-primary px-4">Update</button>
                </div>
            </div>
        </form>  
      <div class="w3-container w3-center row" style="height: 35px">
        <div class="row" style="height: inherit; margin-top: 10px;">
        </div>
      </div>
    </div>
  </div>
</div>
CONTENT;

$tempContent .= <<<CONTENT
<div class="w3-half w3-container">
  <div class="w3-card-4" style="margin-top: 25px; background: white; height: 500;">
    <hr>
    <div style="text-align: center;"><h3 style="">History</h3></div>
    <hr>
    <div class="w3-container w3-center">
      <div class="w3-container w3-center" style="height: 35px; text-align: center;">
CONTENT;
        $query = <<<END
        SELECT * FROM device_status_proj
        WHERE device_id IN ('{$_GET['id']}')
        ORDER BY device_status_id DESC;
END;
        // get history of the last 10 toggles of the lamp
        $counter = 0;
        $res = $mysqli->query($query);
        if ($res->num_rows > 0) {
        while ($row = $res->fetch_object()) {
            $counter = $counter+1;
            if($counter > 10){
                break;
            }
            if($row->on_off == 1){
                $onoff = "ON";
            }
            else{
                $onoff = "OFF";
            }
        $tempContent .= <<<CONTENT
        <h6 style="margin-left:10px; font-family: 'Raleway', sans-serif;">Status : {$onoff} | {$row->time_stamp}</h6>
        <br>
CONTENT;
            }
        }
        $tempContent .= <<<CONTENT
      </div>
    </div>
  </div>
</div>
CONTENT;
return $tempContent;
}

function tv(){
global $on_off;
global $mysqli;

//on-off
//channel
//0-100

$tempContent = <<<CONTENT
<div class="w3-rest w3-container" style="">
    <h3 style="font-size=30; margin-top: 15px; text-align: center;">{$_GET['des']}</h3> 
</div>
<div class="w3-half w3-container">
  <div class="w3-card-4" style="margin-top: 25px; background: white;">
    <hr>
    <div style="text-align: center;"><h3 style="">Insert data</h3></div>
    <hr>
    <div class="w3-container w3-center">
    <form action="device_details.php?id={$_GET['id']}&room_id={$_GET['room_id']}&type=2&des={$_GET['des']}" method="post">
        <p class="text-muted">Update Tv</p>
        <div class="input-group mb-3">
            <span class="input-group-addon"><i class="fa fa-television"></i>
            </span>
            <select class="form-control" name="channel" placeholder="Room type" required>
            <option value="1" selected>Svt 1</option>
            <option value="2">Svt 2</option>
            <option value="3">Tv3</option>
            <option value="4">Tv4</option>
            <option value="5">Kanal 5</option>
            <option value="6">6</option>
            </select>
        </div>
        <p class="text-muted">Switch off/on</p>
        <!-- Rounded switch -->
        <label class="switch">
        <input type="checkbox" name="checkbox" {$on_off}>
        <div class="slider round"></div>
        </label>
        <br>
        <label for="fader">Volume</label>
        <input name="volume" type="range" min="0" max="100" value="50" id="fader" required>
        <br>
        <div class="row">
            <div class="col-6">
                <button name="back" onclick="location.href='index.php';" class="btn btn-danger px-4">Go back</button>
            </div>
            <div class="col-6">
                <button type="submit" name="update" value="update" class="btn btn-primary px-4">Update</button>
            </div>
        </div>
      </form>  
      <div class="w3-container w3-center row" style="height: 35px">
        <div class="row" style="height: inherit; margin-top: 10px;">
        <h6 style="margin-left:10px; font-family: 'Raleway', sans-serif;">|  Tv  |</h6>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="w3-half w3-container">
  <div class="w3-card-4" style="margin-top: 25px; background: white; height: 500;">
    <hr>
    <div style="text-align: center;"><h3 style="">History</h3></div>
    <hr>
    <div class="w3-container w3-center">
      <div class="w3-container w3-center" style="height: 35px; text-align: center;">
CONTENT;
        $query = <<<END
        SELECT * FROM device_status_proj
        WHERE device_id IN ('{$_GET['id']}')
        ORDER BY device_status_id DESC;
END;
        // get history of the last 10 toggles of the lamp
        $counter = 0;
        $res = $mysqli->query($query);
        if ($res->num_rows > 0) {
        while ($row = $res->fetch_object()) {
            $counter = $counter+1;
            if($counter > 10){
                break;
            }
            if($row->on_off == 1){
                $onoff = "ON";
            }
            else{
                $onoff = "OFF";
            }
        $tempContent .= <<<CONTENT
        <h6 style="margin-left:10px; font-family: 'Raleway', sans-serif;">Status : {$onoff} | Volume : {$row->precentage}% | Channel : {$row->channel} | {$row->time_stamp}</h6>
        <br>
CONTENT;
            }
        }
        $tempContent .= <<<CONTENT
      </div>
    </div>
  </div>
</div>
CONTENT;
return $tempContent;
CONTENT;
return $tempContent;
}

function speaker(){
global $on_off;
global $mysqli;
$tempContent = <<<CONTENT
<div class="w3-rest w3-container" style="">
    <h3 style="font-size=30; margin-top: 15px; text-align: center;">{$_GET['des']}</h3> 
</div>
<div class="w3-half w3-container">
  <div class="w3-card-4" style="margin-top: 25px; background: white;">
    <hr>
    <div style="text-align: center;"><h3 style="">Insert data</h3></div>
    <hr>
    <div class="w3-container w3-center">
    <form action="device_details.php?id={$_GET['id']}&room_id={$_GET['room_id']}&type=3&des={$_GET['des']}" method="post">
        <p class="text-muted">Update Speaker</p>
        <br>
        <p class="text-muted">Switch off/on</p>
        <!-- Rounded switch -->
        <label class="switch">
        <input type="checkbox" name="checkbox" {$on_off}>
        <div class="slider round"></div>
        </label>
        <br>
        <label for="fader">Volume</label>
        <input name="volume" type="range" min="0" max="100" value="50" id="fader" required>
        <br>
        <div class="row">
            <div class="col-6">
                <button name="back" onclick="location.href='index.php';" class="btn btn-danger px-4">Go back</button>
            </div>
            <div class="col-6">
                <button type="submit" name="update" value="update" class="btn btn-primary px-4">Update</button>
            </div>
        </div>
      </form>  
      <div class="w3-container w3-center row" style="height: 35px">
        <div class="row" style="height: inherit; margin-top: 10px;">
        </div>
      </div>
    </div>
  </div>
</div>

<div class="w3-half w3-container">
  <div class="w3-card-4" style="margin-top: 25px; background: white; height: 500;">
    <hr>
    <div style="text-align: center;"><h3 style="">History</h3></div>
    <hr>
    <div class="w3-container w3-center">
      <div class="w3-container w3-center" style="height: 35px; text-align: center;">
CONTENT;
        $query = <<<END
        SELECT * FROM device_status_proj
        WHERE device_id IN ('{$_GET['id']}')
        ORDER BY device_status_id DESC;
END;
        // get history of the last 10 toggles of the lamp
        $counter = 0;
        $res = $mysqli->query($query);
        if ($res->num_rows > 0) {
        while ($row = $res->fetch_object()) {
            $counter = $counter+1;
            if($counter > 10){
                break;
            }
            if($row->on_off == 1){
                $onoff = "ON";
            }
            else{
                $onoff = "OFF";
            }
        $tempContent .= <<<CONTENT
        <h6 style="margin-left:10px; font-family: 'Raleway', sans-serif;">Status : {$onoff} | Volume : {$row->precentage}% | {$row->time_stamp}</h6>
        <br>
CONTENT;
            }
        }
        $tempContent .= <<<CONTENT
      </div>
    </div>
  </div>
</div>
CONTENT;
return $tempContent;
}


require_once('dashboard.php');


echo $head;
echo $body;

// Get info about selected device
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

// Get history about selected device
$query = <<<END
SELECT * FROM device_status_proj
WHERE device_id = '{$_GET['id']}';
END;
$res = $mysqli->query($query);
$json = mysqli_fetch_all ($res, MYSQLI_ASSOC);
?>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
    //echo data and store in var
    var data = <?php echo json_encode($json);?>;
    //checks if data exists and if it's a device with temp values, then plot temp history of device
    if(data.length > 0 && data[0].temprature != null){
        if(data.length > 10 ){
            data = data.slice(-10);
            console.log(data);
        }
        var dataForChart = [];
        dataForChart.push( ['Date', 'Temp']);
        for(var i=0; i<data.length; i++){
            var d = [data[i].time_stamp.substring(5,10), parseInt(data[i].temprature)];
            dataForChart.push(d);
        }
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var data = google.visualization.arrayToDataTable(dataForChart);

            var options = {
            title: 'Temperature',
            curveType: 'function',
            legend: { position: 'bottom' }
            };

            var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

            chart.draw(data, options);
        }
    }
</script>

<?php
echo $end;
?>