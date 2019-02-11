<?php
	session_start();
	$_SESSION['message'] = '';
	require('db.php');
	
	// Check connection
	if (mysqli_connect_errno()) {
		$_SESSION['message'] = 'Failed to connect to MySQL' . mysqli_connect_error();
	}
	
// If form submitted, insert values into the database.
	if (isset($_POST['username'])){
        // removes backslashes
	$username = stripslashes($_REQUEST['username']);
        //escapes special characters in a string
	$username = mysqli_real_escape_string($con,$username);
	$password = stripslashes($_REQUEST['password']);
	$password = mysqli_real_escape_string($con,$password);
	//Checking is user existing in the database or not
        $query = "SELECT * FROM `users` WHERE username='$username'
				  and password='".md5($password)."'";
		
	$result = mysqli_query($con,$query) or die(mysql_error());

	$rows = mysqli_num_rows($result);
        if($rows==1){
	    $_SESSION['username'] = $username;
            // Redirect user to index.php
	    header("Location: welcome.php");
         }else{
			$_SESSION['message'] = 'Username or Password is incorrect!';
			
		}	
    }
?>


<link href="//db.onlinewebfonts.com/c/a4e256ed67403c6ad5d43937ed48a77b?family=Core+Sans+N+W01+35+Light" rel="stylesheet" type="text/css"/>
<link rel="stylesheet" href="../css/form.css" type="text/css">
	<header>
	  <h1 id="legolas">Legolas</h1>
	</header>
	<div class="body-content">
	  <div class="module">
		<h1>Welcome to Legolas</h1>
		<h2>Sign in with your Legolas account</h2>
		<form class="form" action="login.php" method="post" enctype="multipart/form-data" autocomplete="off">
		  <div class="alert alert-error"><?= $_SESSION['message'] ?></div>
		  <input type="text" placeholder="Username" name="username" required /> 
		  <input type="password" placeholder="Password" name="password" required />
		  <input type="submit" value="Login" name="register" class="btn btn-block btn-primary" />
		</form>
		<p>Not registered yet? <a href='form.php'>Register Here</a></p>
	  </div>
	  <footer>
		<p class="copyright">&copy; Legolas.com</p>
	  </footer>
	</div>