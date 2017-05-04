<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <!-- <link rel="shortcut icon" href="assets/ico/favicon.png"> -->

    <title>Login</title>

    <!-- Icons -->
    <link href="media/css/font-awesome.min.css" rel="stylesheet">
    <link href="media/css/simple-line-icons.css" rel="stylesheet">

    <!-- Main styles for this application -->
    <link href="media/css/style.css" rel="stylesheet">

</head>
    
<?php
  $message = '';
 include('db.php');
 if (isset($_POST['username']) and isset($_POST['password'])) {
  $name = $mysqli->real_escape_string($_POST['username']);
  $pwd = $mysqli->real_escape_string($_POST['password']);

  $query = <<<END
  SELECT username, password, user_id, super_user FROM user_proj
  WHERE username = '{$name}'
  AND password = '{$pwd}'
END;
  $result = $mysqli->query($query);
  if ($result->num_rows > 0) {
    $row = $result->fetch_object();
    $_SESSION["username"] = $row->username;
    $_SESSION["user_id"] = $row->user_id;
    if($row->super_user == 1){
        $_SESSION['super_user'] = $row->super_user;
        echo "logged in as super user";
        header("Location:index.php");
    } 
    else{
        header("Location: index.php");
    }
  } else {
    $message = 'Sorry, those credentials do not match';
  }
}

?>

<body class="app flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card-group mb-0">
                    <div class="card p-3">
                        <div class="card-block">
                            <h1>Login</h1>
                            <?php if(!empty($message)): ?>
                                <p><?= $message ?></p>
                            <?php endif; ?>
                            <form action="login.php" method="post">
                                <p class="text-muted">Sign in to your account</p>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="icon-user"></i>
                                    </span>
                                    <input type="username" name="username" class="form-control" placeholder="Username">
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="icon-lock"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" value="login" class="btn btn-primary px-4">Login</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and necessary plugins -->
    <script src="bower_components/jquery/dist/jquery.min.js"></script>
    <script src="bower_components/tether/dist/js/tether.min.js"></script>
    <script src="bower_components/bootstrap/dist/js/bootstrap.min.js"></script>

</body>

</html>
