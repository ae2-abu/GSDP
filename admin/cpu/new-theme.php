<?php 
session_start();
// header("Content-Type:application/json");
// require_once("../../../settings/global_config.php");
include_once("../settings/connect.php");
require_once("../settings/config.php");
// include_once(AUTHROOTFULL."session_cpus.php");
include_once("../settings/functions.php");
// include_once("../settings/user_info.php");
 
$currentTimeDBFormat = date("Y-m-d H:i:s");

 if( isset($_POST['new_theme']) && !empty($_POST['new_theme'])){
		 $newTheme= mysql_prep($_POST['new_theme']);
		 
		
			 $stmt22=$con->prepare("INSERT into themes(name) values(?)") or die($con->error);			  
			 $stmt22->bind_param("s",$newTheme);
			 $stmt22->execute() or die($con->error);

			 if($stmt22->insert_id <=0){
			 	    
			 	    $err = array('success' => 71 );
		 			echo json_encode($err); // Insert failed
			 	   
			 }else{

				
				$err = array('success' => 1 );
		 			echo json_encode($err); // successful
			 	
			 }	
	  
	}else{
				    $err = array('success' => 3 );
		 			echo json_encode($err); 
				 // echo "all requifred fields must be filled approprately";
	}     

?>