<?php
    session_start();
    $_SESSION['message'] = '';
    require('db.php');
    
// If form submitted, insert values into the database.
	if (isset($_POST['email'])){
        // removes backslashes
		$email = stripslashes($_REQUEST['email']);
			//escapes special characters in a string
		$email = mysqli_real_escape_string($con,$email);
		//Checking is user existing in the database or not
		$query = "SELECT * FROM `users` WHERE email='$email'";
		$result = mysqli_query($con,$query) or die(mysql_error());
		$rows = mysqli_num_rows($result);
        
		if($rows==1){ 
	    $_SESSION['email'] = $email;
            // Checks if email already exists
			$_SESSION['message'] = 'User with that email account already exists!';
         }else if(isset($_POST['username'])) {
				 $username = stripslashes($_REQUEST['username']);
				 $username = mysqli_real_escape_string($con,$username);
				 // Checks if user already exists
				 $query = "SELECT * FROM `users` WHERE username='$username'";
				 $result = mysqli_query($con,$query) or die(mysql_error());
				 $rows = mysqli_num_rows($result);
				 
				 if($rows == 1) {
					 $_SESSION['username'] = $username;
					 $_SESSION['message'] = 'Username already exists!';
				 }else if($_SERVER['REQUEST_METHOD'] == 'POST') {
						 if($_POST['password'] == $_POST['confirmpassword']) {
							$username = $con->real_escape_string($_POST['username']);
							$email = $con->real_escape_string($_POST['email']);
							$password = md5($_POST['password']); //md5 hash password security
							$avatar_path = $con->real_escape_string('../images/' . $_FILES['avatar']['name']);
								
							//make sure file type is image
							if(preg_match("!image!", $_FILES['avatar']['type'])) {
								//copy image to images/ folder
								if(copy($_FILES['avatar']['tmp_name'], $avatar_path)) {
									$_SESSION['username'] = $username;
									$_SESSION['avatar'] = $avatar_path; 
										
									$sql = "INSERT INTO users (username, email, password, avatar)"
									. "VALUES ('$username', '$email', '$password', '$avatar_path')";
										
									//if the query is successful, redirect to welcome.php page, done!
									if($con->query($sql) == true) {
										$_SESSION['message'] = "Registration successful! Added $username to the database!";
										header("location: welcome.php");
								}else {
									$_SESSION['message'] = "User could not be added to the database!";
								}
							}else {
								$_SESSION['message'] = "File upload failed!";
							}
						}else {
							$_SESSION['message'] = "Please only upload GIF, JPG, or PNG images!";
						}
					}else {
						$_SESSION['message'] = "Two passwords do not match!";
				}
			}
		}
	}	

?>

<!DOCTYPE html>
<html>
	<head>
		<title>Register</title>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
		<link rel="stylesheet" href="../css/form.css" type="text/css">
	</head>
	<body>
		<header>
		  <h1 id="legolas">Legolas</h1>
		</header>
		<div class="body-content">
		  <div class="module">
			<h1>Welcome to Legolas</h1>
			<h2>Create an account</h2>
			<form class="form" action="form.php" method="post" enctype="multipart/form-data" autocomplete="off">
			  <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
			  <input type="text" placeholder="Username" name="username" required />
			  <input type="email" placeholder="Email" name="email" required />
			  <input type="password" placeholder="Password" name="password" autocomplete="new-password" required />
			  <input type="password" placeholder="Confirm Password" name="confirmpassword" autocomplete="new-password" required />
			  <div class="avatar"><label>Select your avatar: </label><input type="file" name="avatar" accept="image/*" required /></div>
			  <input type="submit" value="Register" name="register" class="btn btn-block btn-primary" />
			</form>
				<p>Has an account already? <a href='login.php'>Login here</a></p>
		  </div>
		  <footer>
			<p class="copyright">&copy; Legolas.com</p>
		  </footer>
		</div>
	</body>
</html>
