<?php 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////     MY DONATION Page       /////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$donation = $con->prepare("SELECT a.id,a.amount,a.date_created,a.canceled,b.username,c.name from donations a left join user_auth b on a.user_id = b.user_id left join projects c on a.project_id = c.id where a.user_id = ? order by a.date_created desc") or die($con->error);
    $donation->bind_param('i',$_SESSION['user_id']) or die($con->error);
    $donation->execute();
    $donation->bind_result($donationID,$amount,$dateDonated,$is_canceled,$donorUsername,$causeName);
    $donation->store_result() ;

?>
<div class="col-insidde">
	<a href="/manage/donations" class="btn btn-default" style="margin-bottom: 10px;"><i class="ion ion-arrow-left-a"></i> Back to users donations</a>
	<table class="table table-striped">
		<thead style="background: -webkit-linear-gradient(top,#ccc,#fff)">
			<tr><th>donationID</th><th>username[userid]</th><th>amount donated</th><th>date donated</th><th>project donated[project id]</th><th></th></tr>
		</thead>
		<tbody>
			<?php 
			      if($donation->num_rows > 0){
			      	     while($donation->fetch()){
			      	   printf('<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>--</td></tr>',$donationID,$donorUsername,$amount,$dateDonated,$causeName);
			      	     }
			      }
				?>
			<!-- <tr><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td></tr> -->
			
		</tbody>
	</table>
</div>
					 	
					 