<?php 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////     VIEW PROJECTS Page       //////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$news = $con->prepare("SELECT a.id,a.title,a.body,a.main_image,a.date_created,b.username,c.name from events a left join user_auth b on a.author = b.user_id left join themes c on a.theme_id = c.id where a.biz_id = ? order by a.date_created desc") or die($con->error);
    $news->bind_param('i',$_SESSION['company_id']) or die($con->error);
    $news->execute();
    $news->bind_result($projectID,$projectTitle,$projectBody,$projectImage,$projectDate,$author,$themeName);
    $news->store_result() ;

?>
<div class="col-insidde">
	<a href="/manage/add_project" class="btn btn-default" style="margin-bottom: 10px;"><i class="ion ion-ios-compose-outline"></i> Add New Event</a>
	<table class="table table-striped">
		<thead style="background: -webkit-linear-gradient(top,#ccc,#fff)">
			<tr><th>projectID</th><th>title</th><th>author</th><th>date created</th><th>image</th><th>theme</th><th></th></tr>
		</thead>
		<tbody>
			<?php 
			      if($news->num_rows > 0){
			      	     while($news->fetch()){
			      	   printf('<tr><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td>%s</td><td style="font-size:10px;">%s</td><td><a href="#" class="del-project-btn btn btn-default btn-xs" data-id="%s">Remove</a></td></tr>',$projectID,$projectTitle,$author,$projectDate,$projectImage,$themeName,$projectID);
			      	     }
			      }
				?>
			<!-- <tr><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td></tr>
			<tr><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td></tr>
			<tr><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td></tr> -->
		</tbody>
	</table>
</div>
					 	
					 