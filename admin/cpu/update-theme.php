<?php 
// This is the script that updates the theme(colors) of the site as the admin changes and clicks on submit.
session_start();
// header("Content-Type:application/json");
require_once("../settings/config.php");
include_once("../settings/connect.php");
include_once("../settings/functions.php");
// require_once("../../auth/session_cpus.php");

// These are all the new colors the admin have set in the TEMPLATE page. 
 $primary = isset($_POST['primary']) ? mysql_prep($_POST['primary']):"";
 $second =  isset($_POST['second']) ? mysql_prep($_POST['second']):"";
 $color3 =  isset($_POST['color-3']) ? mysql_prep($_POST['color-3']):"";
 $color4 =  isset($_POST['color-4']) ? mysql_prep($_POST['color-4']):"";
 $color5 =  isset($_POST['color-5']) ? mysql_prep($_POST['color-5']):"";
 $color6 =  isset($_POST['color-6']) ? mysql_prep($_POST['color-6']):"";
 $color7 =  isset($_POST['color-7']) ? mysql_prep($_POST['color-7']):"";
 // $bizID = 1;
     // The statement below updates the color of the web app
		 $stmt=$con->prepare("UPDATE templates set prime_color = ?,second_color = ?, color_3 = ? , color_4 = ?, color_5 = ?,color_6 = ?,color_7 = ? where biz_id = ?") or die($con->error);
		 $stmt->bind_param("ssssssss",$primary,$second,$color3,$color4,$color5,$color6,$color7,$_SESSION['company_id']) or die($con->error);
		 $stmt->execute() or die($con->error);



		if($stmt->affected_rows>0){ 
			echo '{"success":"1"}';
		}else{
			echo '{"success":"2"}';
		}



		$stmt->close();
		$con->close();

?>