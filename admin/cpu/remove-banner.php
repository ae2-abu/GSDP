<?php 
session_start();
// header("Content-Type:application/json");
require_once("../settings/config.php");
include_once("../settings/connect.php");
include_once("../settings/functions.php");
// require_once("../../auth/session_cpus.php");
 $bannerID =  isset($_POST['banner_id']) ? mysql_prep($_POST['banner_id']):"";
        

        //This statement DELETES a particular Banner with the Banner id. Though we are not actually DELETING the banner, we are actually making it invisble. So we actually hides the banner from view and not like we are deleting the file 
		 $stmt=$con->prepare("UPDATE banner set visibility = '0' where id = ? and biz_id = ?") or die($con->error);
		 $stmt->bind_param("ii",$bannerID,$_SESSION['company_id']) or die($con->error);
		 $stmt->execute() or die($con->error);



		if($stmt->affected_rows>0){ 
			echo '{"success":"1"}';
		}else{
			echo '{"success":"2"}';
		}



		$stmt->close();
		$con->close();

?>