<?php 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////     VIEW ALL USERS Page       //////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////


	$users = $con->prepare("SELECT a.user_id,a.surname,a.firstname,a.phoneNo,a.email,a.biz_id,a.unit,b.username,b.default_password from user_profile a left join user_auth b on a.user_id = b.user_id order by a.date_joined desc") or die($con->error);
    // $users->bind_param('i',$bizID) or die($con->error);
    $users->execute();
    $users->bind_result($userID,$surname,$firstname,$phone,$email,$bizID,$unit,$username,$password);
    $users->store_result() ;

?>
<div class="col-insidde">
	<a href="/manage/add_user" class="btn btn-default" style="margin-bottom: 10px;"><i class="ion ion-person-add" style="font-size: 20px;position: relative;top: 2px;"></i> Add New User</a>
	<table class="table table-striped">
		<thead style="background: -webkit-linear-gradient(top,#ccc,#fff)">
			<tr><th>userID</th><th>surname</th><th>firstname</th><th>username</th><th>default password</th><th>unit</th><th>phone</th><th>email</th><th></th></tr>
		</thead>
		<tbody>
			<?php 
			      if($users->num_rows > 0){
			      	     while($users->fetch()){
			      	   printf('<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td><a href="#" class="del-user-btn btn btn-default btn-xs" data-id="%s">Remove</a></td></tr>',$userID,$surname,$firstname,$username,$password,$unit,$phone,$email,$userID);
			      	     }
			      }
				?>
			
			<!-- <tr><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td></tr> -->
		</tbody>
	</table>
</div>
					 	
					 