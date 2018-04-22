<?php 
session_start();
// header("Content-Type:application/json");
// require_once("../../../settings/global_config.php");
include_once("../settings/connect.php");
require_once("../settings/config.php");
// include_once(AUTHROOTFULL."session_cpus.php");
include_once("../settings/functions.php");
// include_once("../settings/user_info.php");
 // $userid= ;
$currentTimeDBFormat = date("Y-m-d H:i:s");
$_SESSION['admin'] = 0;

// Checking if the following important fields are set. If no , we let the user know that some fields are needed/required
 if( (isset($_POST['surname']) && !empty($_POST['surname'])) &&
      (isset($_POST['firstname']) && !empty($_POST['firstname']))&&
      (isset($_POST['email']) && !empty($_POST['email']))&&
      (isset($_POST['phone']) && !empty($_POST['phone']))&&
      (isset($_POST['username']) && !empty($_POST['username']))&&
      (isset($_POST['unit']) && !empty($_POST['unit']))
 	){

 	  // we now apply the snaitizing function(mysql_prep) to deal with possible injections
		 $surname= mysql_prep($_POST['surname']);
		 $firstname= mysql_prep($_POST['firstname']);
		 $email= mysql_prep($_POST['email']);
		 $phone= mysql_prep($_POST['phone']);
		 $username= mysql_prep($_POST['username']);
		 $password= mysql_prep($_POST['password']);
		 $unit= mysql_prep($_POST['unit']);
		 $company= mysql_prep($_POST['company']);
		 
		 
      // Here we test to check wether the user(username) already exist
		$test = $con->prepare("SELECT user_id FROM user_auth WHERE username = ? UNION ALL SELECT user_id from user_profile where email=?") or die($con->error); 
		$test->bind_param("ss",$username,$email)  or die($con->error);
		$test->execute()  or die($con->error);
		$test->bind_result($user_id)  or die($con->error);
		$test->store_result()  or die($con->error);
		
		//check if query returns any result
		if($test->num_rows == 0) {
		     $test -> close();
			//value is unique, let's insert it. I.e the two values checked above are uniqu username and email

		     $con->begin_transaction();   // we used mysql transaction here because we want to run more than one query simultenously that MUST either succeed together or FAIL together. If there is any error(failure) in any of the queries(INSERT) below,you can ROLL it BACK because the queries are in a TRANSACTION, else if success, you can then go ahead and COMMIT.

			 $cryptoPwd = md5($password); // this line encrypts the user password using MD5 hash algorith so that even if hackers enters the database

			 //NOTE: There are two(2) tables in the database that are used for user details(the USER_AUTH and USER_PROFILE). So the INSERT statement below adds information to the "user_auth" table
			 $stmt33=$con->prepare(" INSERT into user_auth(username,password,default_password) values(?,?,?)") or die($con->error);			  
			 $stmt33->bind_param("sss",$username,$cryptoPwd,$password);
			 $stmt33->execute() or die($con->error);
			 $userAuthID = $stmt33->insert_id;

             // while this statement below adds information to the "user_profile" table.
			 $stmt22=$con->prepare("INSERT into user_profile(user_id,surname,firstname,phoneNo,email,biz_id,unit) values(?,?,?,?,?,?,?)") or die($con->error);			  
			 $stmt22->bind_param("sssssss",$userAuthID,$surname,$firstname,$phone,$email,$company,$unit);
			 $stmt22->execute() or die($con->error);

			 if($stmt33->insert_id <=0 || $stmt22->insert_id <=0){ // Here we check the two(2) statments . If any fails, we ROLLBACK,else we COMMIT.
			 	    
			 	    $err = array('success' => 71 );
		 			echo json_encode($err); // Insert failed
			 	    $con->rollback();
			 }else{

				$con->commit();
				$err = array('success' => 1 );
		 			echo json_encode($err); // successful
			 // 	///////////////////////////
			 	///////////////////////////
			 	///////////////////////////
			 	
			 	
			 }
				 	
			 
			
	   }else{
	   	            $err = array('success' => 2 );
		 			echo json_encode($err); 
	   			// echo "some information submitted already exist";
	   }
	}else{
				    $err = array('success' => 3 );
		 			echo json_encode($err); 
				 // echo "all required fields must be filled approprately";
	}


	     

?>