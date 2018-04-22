<?php 
session_start();

include_once("../settings/connect.php");
require_once("../settings/config.php");
// include_once(AUTHROOTFULL."session_cpus.php");
include_once("../settings/functions.php");
// include_once("../settings/user_info.php");
 // $userid= ;
$currentTimeDBFormat = date("Y-m-d H:i:s");
$_SESSION['admin'] = 0;

// validation: we first check if the value submited to this page is empty or not. This is called validation
 if( (isset($_POST['amount']) && !empty($_POST['amount'])) &&
      (isset($_POST['project']) && !empty($_POST['project']))
      
 	){
		 $amount= mysql_prep($_POST['amount']); //this mysql_prep() is that user defined function that sanitizes user input against Injections like SQL injection.
		 $project= mysql_prep($_POST['project']);
		 // $email= mysql_prep($_POST['email']);
		 
		 
		 
		 if(strlen($amount)==0 || !is_numeric($amount)){
		 	$err = array('success' => 8 );
		 	echo json_encode($err); //The amount you provided is needed or is not a number
		 	die();
		 }
		 
		 // ////////////////////////////////////    insert the donations now   ///////////////////////////////////////////////

		 	//The statement below is SQL used to INSERT data into the database.
			 $donate=$con->prepare("INSERT into donations(user_id,amount,project_id) values(?,?,?)") or die($con->error);			  
			 $donate->bind_param("sss",$_SESSION['user_id'],$amount,$project);
			 $donate->execute() or die($con->error);

			 if($donate->insert_id > 0 ){ //every new record added to the database generates a new ID automatically(AUTO-INCREMENT) , so to check wether a record is inserted,we check the last insert id of the new inserted record if its greated than 0. 
			 	    
			 	 $err = array('success' => 1 );
		 		 echo json_encode($err); // successful
			 	   
			 }else{

				 $err = array('success' => 71 );
		 		 echo json_encode($err); // Insert failed
				
			 	
			 	
			 }
				 	
			 
			
	  
	}else{
				    $err = array('success' => 3 );
		 			echo json_encode($err); 
				 // echo "all requifred fields must be filled approprately";
	}


	     

?>