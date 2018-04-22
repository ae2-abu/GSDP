<?php 
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////     NEW PROJECT Page       ///////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
?>
<form action="#">
	<div class="col-md-8">
		<div class="col-insdide">
			 <div class="row">
				 <div class="col-md-9">
				 	<input type="text" name="title" id="dz-title" placeholder="Event Title">
				 </div>
				 <div class="col-md-3" style="padding-left:0px;">
				 	<select name="theme" id="dz-cat">


				 		<?php

				 			 $theme=$con->prepare("SELECT id,name from themes");			  
							 // $proj->bind_param("s",$projectID) or die($con->error);
							 $theme->execute() or die($con->error);
							 $theme->bind_result($themeID,$themeName) or die($con->error);
							 $theme->store_result() or die($con->error);

							 if($theme->num_rows > 0 ){
							 	  
							 	  while($theme->fetch()){
							 	  	   
							 	  	   		printf('<option value="%s">%s</option>',$themeID,$themeName);
							 	  
							 	  		
							 	  }
							 	   
							 }
				 		?>
				 	
				 	</select>
				 </div>
			</div>
				
				<textarea id="ck-project" name="body" placeholder="News"></textarea>
		</div>
	</div>			 	
	<div class="col-md-4">
		<div class="col-insdide">
				<div id="dropzone-project" class="dropzone"></div>
				<button id="dz-project-submit-btn" type="submit" id="nuser-submit-btn">Add Project</button>
		</div>
	</div>
</form>			 	
					 