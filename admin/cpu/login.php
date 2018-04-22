<?php
        session_start(); // very important so we can access the session variables like $_SESSION['uname'],$_SESSION['pwd'],etc
		header("Content-Type:application/json"); // this line makes sure that this file output returned to the requesting client is a JSON file.


        //The if statment below checks if a user has submitted a username(uname) and password(pwd) and checks to make sure they are not empty.
		if((isset($_POST['uname']) && !empty($_POST['uname'])) && (isset($_POST['pwd']) && !empty($_POST['pwd']))){
				require_once("../settings/connect.php");   // connect to the database
				require_once("../settings/config.php");    // the configuration file
				require_once("../settings/functions.php"); // the user defined function

				//if the user has submitted username and password, we now sanctify it :). Because we dont really know the type of string they sent. wether they were trying something malicious. thats what the mysql_prep() function does for us.
				$username = mysql_prep($_POST['uname']);
				$password = md5(mysql_prep($_POST['pwd']));

				// we now query the "user_auth" table in the database for a match in the login details the user has provided.notcie we are only selecting three(3) coulmns(user_id,admin,biz_id)
				$query = $con->prepare("SELECT a.user_id,a.admin,b.biz_id from user_auth a left join user_profile b on a.user_id = b.user_id where a.username = ? and a.password = ?") or die($con->error);
				
				$query->bind_param("ss",$username,$password)  or die($con->error);
				$query -> execute() or die($con->error);
				$query -> bind_result($userID,$admin,$bizID) or die($con->error);
				$query -> store_result(); // this line is very important and necessary if you must check for the number of rows(num_rows) returned in the result
				$query -> fetch();

                
				if($query ->num_rows == 1){ // the "$query ->num_rows" gives the no of rows(result) the query statement above returns. NOTE: we are checking if it is == 1 and not > 1 because we want it to fail even if there are more than one person with the same login details. Though this is not possible as the username and password column in the database is of type UNIQUE. But its still good to be security conscious as possible. If it is == 0 , it simply means the login details does not match any record in the database(incorrect login details).
					

                  //once the user's login details(username and password) is correct, we set the following important SESSION variables so that the information will be available as we navigate through different pages of the website and can be used to authenticate the user further to access the page or not.
					$_SESSION['uname'] = $username;
					$_SESSION['pwd'] = $password;
					$_SESSION['user_id'] = $userID;
					$_SESSION['admin'] = $admin;
					$_SESSION['company_id'] = $bizID;
					 
					echo '{"success":"1"}';  //success 1 means successful. 
					
				}else{
					echo '{"success":"0"}';  // success 0 means failed
				}
			}
?>