<link rel="stylesheet" type="text/css" href="../css/form.css">
<?php session_start(); ?>
	<header>
	  <h1 id="legolas">Legolas</h1>
	  <script src="../js/jquery-3.3.1.min.js"></script>
	  <script src="../js/effect.js"></script>
	</header>
<div class="body content">
	<a id="log-out" href="login.php">Logout</a>
	<div class="welcome">
	
        <div id="mydiv" class="alert alert-success"><?= $_SESSION['message'] ?></div>
        <!-- <span class="user"><img src='<?= $_SESSION['avatar'] ?>'></span><br/>
        Welcome, <span class="user"><?= $_SESSION['username'] ?></span> -->
		
		<?php
			$username = $_SESSION['username'];
			
            $mysqli = new mysqli('localhost', 'root', 'snippetcode', 'accounts');
			$sql = "SELECT username, avatar FROM users WHERE username='$username'";
			$result = $mysqli->query($sql); //$result = mysqli_result object
				
			while($row = $result->fetch_assoc()) {
				
				echo "<div><img src='$row[avatar]'><br/>";
				echo "Welcome, <span class='user'>$row[username]</div></span>";
				$_SESSION['avatar'] = $row['avatar'];
			}
        ?>
		
        <?php
            $mysqli = new mysqli('localhost', 'root', 'snippetcode', 'accounts');
            $sql = 'SELECT username, avatar FROM users';
            $result = $mysqli->query($sql); //$result = mysqli_result object
        ?>
            
        <div id="registered">
            <span>All registered users</span>
            <?php
                while($row = $result->fetch_assoc()) {
                    echo "<div class='userlist'><span>$row[username]</span><br/>";
                    echo "<img src='$row[avatar]'></div>";
                }
            ?>
        </div>
    </div>
</div>

<div class="body-content">
	<footer>
	  <p class="copyright">&copy; Legolas.com</p>
    </footer>
</div>
    