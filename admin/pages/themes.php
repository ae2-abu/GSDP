<?php 
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////     THEME Page       //////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	$theme = $con->prepare("SELECT id,name from themes order by date_created desc");
    // $news->bind_param('i',$_SESSION['company_id']) or die($con->error);
    $theme->execute();
    $theme->bind_result($themeID,$themeName);
    $theme->store_result() ;

?>
<div class="col-md-6">
	<div class="col-insidde">
		<table class="table table-striped">
			<thead style="background: -webkit-linear-gradient(top,#ccc,#fff)">
				<tr><th>Theme ID</th><th>Theme Name</th><th></th></tr>
			</thead>
			<tbody>
				<?php 
				      if($theme->num_rows > 0){
				      	     while($theme->fetch()){
				      	   printf('<tr><td>%s</td><td>%s</td><td><a href="#" class="del-theme-btn btn btn-default btn-xs" data-id="%s">Remove</a></td></tr>',$themeID,$themeName,$themeID);
				      	     }
				      }
					?>
				<!-- <tr><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td></tr>
				<tr><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td></tr>
				<tr><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td><td>dd</td></tr> -->
			</tbody>
		</table>
	</div>
</div>
<div class="col-md-6">
	<div class="col-insidde" style="margin-top:28px;padding:0px 20px 40px;background: -webkit-linear-gradient(top,#eee,#efefef);border:1px solid #eee;">
			<h4>Add New:</h4>
			<input type="text" name="new-theme" style="padding:10px 20px;width:80%;height:45px;position:relative;top:2px;border:1px solid #ccc;font-weight:bold;">
			<a href="#" id="new-theme-submit-btn" class="btn btn-default btn-lg" style="margin:0px !important;">Add</a>
	</div>
</div>
					 	
					 