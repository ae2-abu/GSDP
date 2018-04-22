	<?php
	// session_start();  already started in index.php
	// require_once("settings/config.php");
	
	//This is the session checker included in the every other page asides the login page or the CPU files, to check if a user is logged in or not . If yes, the user is allowed to view the page else the user is redirected back to the login page.				          
	if(isset($_SESSION['uname']) && isset($_SESSION['pwd'])){
				
				$username = $_SESSION['uname'];
				$password = $_SESSION['pwd'];
				$query = $con->prepare("SELECT user_id from user_auth where username = ? and password = ?") or die($con->error);
				$query->bind_param("ss",$username,$password)  or die($con->error);
				$query -> execute() or die($con->error);
				$query ->store_result();
				if($query ->num_rows == 1){
					
					
				}else{
					header("location:".AUTHROOT);
					exit();
					
				}
			}else{
					header("location:".AUTHROOT);
					exit();
					
			}
			?>