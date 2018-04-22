<?php 
// This particular script queries the database and gets the current logged in users details(all) so it can be available anytime
    $my_details=$con->prepare("SELECT a.surname,a.firstname,a.middlename,a.phoneNo,a.email,b.username,b.admin,c.name from user_profile a left join user_auth b on a.user_id = b.user_id left join biz_dept c on (a.biz_id = c.biz_id and a.unit = c.unit_id) where a.user_id=?") or die($con->error);
	$my_details->bind_param("s",$_SESSION['user_id']) or die($con->error);
	$my_details->execute() or die($con->error);
	$my_details->bind_result($my_surname,$my_firstname,$my_othernames,$my_phone,$my_email,$my_username,$my_status,$my_dept) or die($con->error);
	$my_details->fetch();
	$my_details->close();
?>