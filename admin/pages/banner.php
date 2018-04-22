<?php 

////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////     BANNER Page       //////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

	$banner = $con->prepare("SELECT a.id,a.title,a.b_desc,a.file_name,a.date_added from banner a where a.biz_id = ? and a.visibility <> '0' order by a.date_added desc") or die($con->error);
    $banner->bind_param('i',$_SESSION['company_id']) or die($con->error);
    $banner->execute();
    $banner->bind_result($bannerID,$bannerTitle,$bannerDesc,$bannerFileName,$bannerDate);
    $banner->store_result() ;
    // echo `whoami`;
    // echo get_current_user();

?>
<div class="col-md-4">
	  <div class="col-insidd" style="margin-top: 20px;">
		  <form id="banner">
		  	 <input id="dz-title" type="text" name="title" placeholder="Banner Title">
		  	 <textarea id="dz-body" placeholder="Banner Description"></textarea>
		  	 <div id="dropzone-banner" class="dropzone">
		  	 	
		  	 </div>
		  	 <button type="submit" id="dz-banner-submit-btn">Save Banner</button>
		  </form>
	</div>
</div>
<div class="col-md-8">
	<div class="col-insisde" style="margin-top: 20px;">
		


		<?php if($banner->num_rows > 0){
				while($banner->fetch()){
			?>

			<div class="single-banner-cont">
				<div class="banner-img-cont">
					<img src="<?php echo BANNER_DIR.$bannerFileName; ?>">
					<a href="#" class="banner-remove-btn" data-id="<?php echo $bannerID; ?>"><i class="ion ion-ios-trash-outline" style="position: relative;top:1px;"></i> remove</a>
				</div>
				<div class="banner-text-cont">
					<span class="banner-title">
						<?php echo $bannerTitle; ?>
					</span>
					<span class="banner-desc">
						<?php echo html_entity_decode($bannerDesc); ?>
					</span>
					<div class="clearfix"></div>
				</div>
				<div class="clearfix"></div>
			</div>

      <?php 
		  	}
		  }else{
		  	  echo '<div class="default-message">No Banner has been uploaded</div>';
		  } 

	  ?>




		
	</div>
</div>

					 	
					 