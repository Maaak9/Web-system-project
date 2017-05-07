<?php
require_once('db.php');
//checks if you're logged in or not

$message = '';

 if(isset($_SESSION['super_user']) ){
	
 } else {
     header("Location: index.php");
 }

//Userregistration
 if(!empty($_POST['username']) && !empty($_POST['password'])):
	
	//Check if username is already in use
	$records = $conn->prepare('SELECT user_id,username,password FROM user_proj WHERE username = :username');
	$records->bindParam(':username', $_POST['username']);
	$records->execute();
	$results = $records->fetch(PDO::FETCH_ASSOC);
	$message = '';
	if($results > 0) {
		$message = 'That username is already in use!';
	} else {
		
		//Checks if the passwords you entered match
		if($_POST['password'] == $_POST['confirm_password']) {
			
			//Makes sure your password isn't the same as your username
			if($_POST['password'] == $_POST['username']) {
				
				 $message = 'Your password cannot be the same as your username!';
	 
			} else {
				
				$pwd = $_POST['password'];
				
				if(strlen ($pwd) < 4 ) {
				
					 $message = 'Your password must be atleast 5 characters!';
					 
				} else {
					
					 //Creates the account
					 $sql = "INSERT INTO user_proj (username, password, email, name, super_user) VALUES (:username, :password, :email, :name, :super_user)";
					 $stmt = $conn->prepare($sql);
					 
					 $stmt->bindParam(':username', $_POST['username']);
					 $stmt->bindParam(':password', $_POST['password']);
                     $stmt->bindParam(':email', $_POST['email']);
					 $stmt->bindParam(':name', $_POST['name']);
					 $stmt->bindParam(':super_user', $_POST['super_user']);
					 if( $stmt->execute() ):
						 $message = 'Success! You can now login with your username and password!';
					 else:
						 $message = 'Sorry there must have been an issue creating your account';
					 endif;
					
				}
				
			}
			
		} else {
			 $message = 'The passwords you entered dont match!';
		}
	}
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
                            <h1>Register</h1>
                            <?php if(!empty($message)): ?>
                                <p><?= $message ?></p>
                            <?php endif; ?>
                            <form action="register.php" method="post">
                                <p class="text-muted">Register a account</p>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="icon-user"></i>
                                    </span>
                                    <input type="text" name="username" class="form-control" placeholder="Username" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="icon-lock"></i>
                                    </span>
                                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="icon-lock"></i>
                                    </span>
                                    <input type="password" name="confirm_password" class="form-control" placeholder="Passwords must match" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="fa fa-envelope-o"></i>
                                    </span>
                                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="icon-user"></i>
                                    </span>
                                    <input type="text" name="name" class="form-control" placeholder="First and last name" required>
                                </div>
                                <div class="input-group mb-3">
                                    <span class="input-group-addon"><i class="fa fa-user-plus"></i>
                                    </span>
                                    <select class="form-control" name="super_user" placeholder="Superuser?" required>
                                    <option value="" selected disabled>Superuser?</option>
                                    <option value="1">Yes</option>
                                    <option value="0">No</option>
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