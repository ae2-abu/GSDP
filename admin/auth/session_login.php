	<?php

	//This is the session checker included in the login page to check if a user is logged in or not . If yes, the user is directed back to the last page the user visited.
	   			require_once("../settings/connect.php");
				require_once("../settings/config.php");
				require_once("../settings/functions.php");
	if(isset($_SESSION['uname']) && isset($_SESSION['pwd'])){
				
				$username = $_SESSION['uname'];
				$password = $_SESSION['pwd'];
				$query = $con->prepare("SELECT user_id from user_auth where username = ? and password = ?") or die($con->error);
				$query->bind_param("ss",$username,$password)  or die($con->error);
				$query -> execute() or die($con->error);
				$query ->store_result();
				if($query ->num_rows == 1){
					// He is good , redirect the user
					header("location:".ROOT.$_COOKIE['last_page']);
				}else{
					//allow the page load;
				}
				$query -> close();
			}
	 ?>