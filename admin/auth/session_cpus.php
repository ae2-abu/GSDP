	<?php
	//This is the session checker included in the cpu files (AJAX processors) to check if a user is logged in or not . If yes, the user is allowed to perform the action, else the user is sent back to the loggin page.
	if(isset($_SESSION['uname']) && isset($_SESSION['pwd'])){
				$username = $_SESSION['uname'];
				$password = $_SESSION['pwd'];
				$query = $con->prepare("SELECT user_id from user_auth where username = ? and password = ?") or die($con->error);
				$query->bind_param("ss",$username,$password)  or die($con->error);
				$query -> execute() or die($con->error);
				$query ->store_result();
				if($query ->num_rows == 1){
					
					//NOTHING HERE : Just allow the person continue
					
				}else{
					header("Content-Type:application/json");
					echo '{"success":"7"}';  //where 7 = user not logged so should not be allowed to perform this 
					                         // operation(any operation this page is included in)
					exit();	
				}
			}else{	
					header("Content-Type:application/json");
					echo '{"success":"7"}';
					exit();
					
			}
			?>