<?php
	header("Content-Type:application/json");
		// in this logout script, the only thing we are doing is just terminating/destroying the session.
		
		session_start(); // though we are trying to destroy the session, we still need to start it first so the various session functions that will help us destroy it will be available
		 
		 $_SESSION=array();  // this line sets the session global variable $_SESSION array to empty array i.e unsetting all the session variables like $_SESSION['uname'],$_SESSION['pwd'],etc
		
		 if(isset($_COOKIE[session_name()])){ // session actually creates a cookie identifier. So this line checks if the session cookie with the identifier exists if yes the following code runs
		     

		     setcookie(session_name(),'',time()-4200,'/'); //Best way to terminate a cookie is to make the cookie expire by setting the cookie time back. here we chose 4200 seconds ago. 
		 }

		 session_destroy(); //after we are done removing the session deposits above, we now call the session destroy function to terminate the session.
		$g=array('success'=>1);
		echo json_encode($g);
?>