<?php 
session_start();

include_once("../settings/connect.php");
require_once("../settings/config.php");
// include_once(AUTHROOTFULL."session_cpus.php");
include_once("../settings/functions.php");
// include_once("../settings/user_info.php");
 
$currentTimeDBFormat = date("Y-m-d H:i:s");

 if( isset($_POST['project_id']) && !empty($_POST['project_id'])){
		 $projectID= mysql_prep($_POST['project_id']);

		 
		
		 // This is the script that populates the select element in the donation modal
		 // The below statement queries the database and gets the result of all the "project" with a specific id.


			 $proj=$con->prepare("SELECT id,title from projects where biz_id = '1' and theme_id = (SELECT theme_id from projects where id = ?) ") or die($con->error);			  
			 $proj->bind_param("s",$projectID) or die($con->error);
			 $proj->execute() or die($con->error);
			 $proj->bind_result($projectIDD,$projectTitle) or die($con->error);
			 $proj->store_result() or die($con->error);

			 if($proj->num_rows > 0 ){
			 	  
			 	  while($proj->fetch()){

			 	  	   //the if statment below is responsible for selecting correctly the default option. when one click on the donate button for any project, one may change ones mind to donate for another project instead, by making another selection from the SELECT dropdown element. Its now the function of the if statment below to auto select the current clicked project as the selected once the modal pops up.
			 	  	   if($projectID == $projectIDD){
			 	  	   		printf('<option value="%s" selected="selected">%s</option>',$projectIDD,$projectTitle);
			 	  	   }else{
			 	  	   	    printf('<option value="%s">%s</option>',$projectIDD,$projectTitle);
			 	  	   }
			 	  		
			 	  }
			 	   
			 }else{
			 		echo "No option found";
				 // $err = array('success' => 71 );
		 		//  echo json_encode($err); // Insert failed
				
			 	
			 	
			 }
				 	
			 
			
	  
	}else{
				    
				echo "all field needed";
				  //   $err = array('success' => 3 );
		 			// echo json_encode($err); 
				 // echo "all requifred fields must be filled approprately";
	}


	     

?>