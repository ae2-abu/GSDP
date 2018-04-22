<?php 

//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////     DONATION Page       //////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$donation = $con->prepare("SELECT a.id,a.amount,a.date_created,a.canceled,b.username,c.title from donations a left join user_auth b on a.user_id = b.user_id left join events c on a.project_id = c.id order by a.date_created desc") or die($con->error);
    // $donation->bind_param('i',$bizID) or die($con->error);
    $donation->execute();
    $donation->bind_result($donationID,$amount,$dateDonated,$is_canceled,$donorUsername,$causeName);
    $donation->store_result() ;

?>
<div class="col-insidde">
	<a href="/manage/my_donations" class="btn btn-default" style="margin-bottom: 10px;"><i class="ion ion-funnel"></i> My Donations</a>
	<table class="table table-striped">
		<thead style="background: -webkit-linear-gradient(top,#ccc,#fff)">
			<tr><th>donationID</th><th>username[userid]</th><th>amount donated</th><th>date donated</th><th>project donated[project id]</th><th></th></tr>
		</thead>
		<tbody>
			<?php 
			      if($donation->num_rows > 0){
			      	     while($donation->fetch()){
			      	   printf('<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td><a href="#" class="del-donation-btn btn btn-default btn-xs" data-id="%s">Remove</a></td></tr>',$donationID,$donorUsername,$amount,$dateDonated,$causeName,$donationID);
			      	     }
			      }
				?>
			<!-- <tr><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td></tr> -->
			
		</tbody>
	</table>
</div>
					 	
					 