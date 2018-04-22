<?php 
session_start();
// header("Content-Type:application/json");
require_once("../settings/config.php");
include_once("../settings/connect.php");
include_once("../settings/functions.php");
// require_once("../../auth/session_cpus.php");
 $itemID =  isset($_POST['item_id']) ? mysql_prep($_POST['item_id']):"";
 		 

                 //This statement DELETES a particular News with the news id
         		 $stmt=$con->prepare("DELETE from news where id = ? ") or die($con->error);
				 $stmt->bind_param("i",$itemID) or die($con->error);
				 $stmt->execute() or die($con->error);
				if($stmt->affected_rows>0){ 
					echo '{"success":"1"}';
				}else{
					echo '{"success":"2"}';
				}
				$stmt->close();
        

		
		$con->close();

?>