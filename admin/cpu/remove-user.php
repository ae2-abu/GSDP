<?php 
session_start();
// header("Content-Type:application/json");
require_once("../settings/config.php");
include_once("../settings/connect.php");
include_once("../settings/functions.php");
// require_once("../../auth/session_cpus.php");
 $itemID =  isset($_POST['item_id']) ? mysql_prep($_POST['item_id']):"";
 		 $check=$con->prepare("SELECT removable from user_auth where user_id = ? ");
		 $check->bind_param("i",$itemID) or die($con->error);
		 $check->execute() or die($con->error);
		 $check->bind_result($removable) or die($con->error);
		 $check->store_result();
		 $check->fetch();
		 $check->close();

         if($removable == '1'){
         		 $stmt=$con->prepare("DELETE from user_auth where user_id = ? and removable = '1'") or die($con->error);
				 $stmt->bind_param("i",$itemID) or die($con->error);
				 $stmt->execute() or die($con->error);
				if($stmt->affected_rows>0){ 
					echo '{"success":"1"}';
				}else{
					echo '{"success":"2"}';
				}
				$stmt->close();
         }else{
         		echo '{"success":"45"}';  //you cannot remove this. Its locked/default
         }
		 



		
		$con->close();

?>