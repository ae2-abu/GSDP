<?php
    //- is the php inbuilt function that activates session (keeping track of users status across  different pages) in the script. Note: This particular line 2, must be placed in ALL the pages that wants to keep track of users authentication/login status. And also Note that for it to work , it must come before any output is made. So that’s why its at line 2 of the page.
	session_start(); 
	///each is an external script included in the index.php for modularity and reusability. The reason those scripts are separated from index.php is because they will be needed in some other pages and to avoid repeating the same code in those pages which not only consume space , but will also make the work tedious as any future changes simply means we have to go through all thise pages and modify them individually . both require_once() and include_once() are php inbuilt functions for including external files to a file(index.php).

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//includes the connection.php that enables PHP to connect and communicate to the database. To connect to a database , you have to provide four(4) basic details : the Host(localhost), the user(root), the password(blank), the database(charity) you want to connect to.
    require_once("settings/connect.php");

    //the configuration file which we use to resolve file paths
	require_once("/admin/settings/config.php");

	//includes the function.php file which contains all the user defined php functions used in the app(site) like the formatted date functions,.
	require_once("settings/functions.php");

	// include_once ("auth/session_others.php");

	//includes the user_info.php  file which is a script that gets the logged in user’s infos from the database and makes it readily available so we can use it anytime we wish. 
	include_once ("settings/user_info.php");
	
	$bizID = 1; // this should be comming from a request



// The following script below is the one responsible for querying the database to get the theme(colors) set by the admin. The following statement 
// SELECT id, biz_id, prime_color, second_color, color_3, color_4, color_5, color_6, color_7, color_8 from templates where biz_id = ‘1’ and is_default = '1'
// in line 30 is known as SQL. It is the language of the database ( MySQL,Oracle,etc). The language is very straight forward and pretty much like English language :) . it simply says : Goto the mysql program , goto the charity database (we have already set this in the connection.php you remember?), from there, goto the  template table(schema) and SELECT all the rows with column “biz_id” = 1 and column  “is_default” = 1 and I only want the following columns “id, biz_id, prime_color, second_color, color_3, color_4, color_5, color_6, color_7, color_8”  


    $theme = $con->prepare("SELECT id,biz_id,prime_color,second_color,color_3,color_4,color_5,color_6,color_7,color_8,color_9 from templates where biz_id = ? and is_default = '1' ") or die($con->error);
   
   // its a way of binding data to the SQL statement we are sending to the database. It replaces the question mark(?)  in the previous line 32 above
    $theme->bind_param('i',$bizID) or die($con->error);
    $theme->execute();

    //This is a way of storing the returned result (rows) into a variables so we can access it. Notice that the order of the variables is the same as the corresponding columns in the query statement
    $theme->bind_result($themeID,$bizID,$primeColor,$secondColor,$color3,$color4,$color5,$color6,$color7,$color8,$color9);
   
   // we first store the result so you can make use of the "$theme->num_rows" below.
    $theme->store_result() ;

    if($theme->num_rows > 0){
    	// this as the name implies, fetches the result from the query above and activates the bind_result() above so the any of the variables($themeID,$bizID,$primeColor,$secondColor,$color3,$color4,$color5,$color6,$color7,$color8) can be accessed 
    	$theme->fetch() ;
    }

?>
<!DOCTYPE html>
<html>
<head>
	<title>QCF - Charity</title>
	<?php 
	     // This section of index.php is used to import external style sheets(CSS) into the file. This section handles the aesthetics(beauty) of the site
	 ?>
	<!-- ///////////////////////////////  ionicons   ///////////////////////////////////// -->
	<link rel="stylesheet" type="text/css" href="style/ionicons/css/ionicons.min.css">
	<!-- ///////////////////////////////  bootstrap   ///////////////////////////////////// -->
	<link rel="stylesheet" type="text/css" href="style/bootstrap/css/bootstrap.min.css">
	<!-- ///////////////////////////////  google font   ///////////////////////////////////// -->
	<link rel="stylesheet" type="text/css" href="style/google-fonts/google-fonts.css">
	<!-- ///////////////////////////////  owl carousel   ///////////////////////////////////// -->
	<link rel="stylesheet" type="text/css" href="script/js/plugins/owl-carousel/owl.carousel.css">
	<link rel="stylesheet" type="text/css" href="script/js/plugins/owl-carousel/owl.theme.css">
	<!-- ///////////////////////////////  general css   ///////////////////////////////////// -->
	<link rel="stylesheet" type="text/css" href="style/general.css">

	<!-- ///////////////////////////////  This page only (css)   ///////////////////////////////////// -->
	<?php include "style/style.php"; ?>

	
</head>
<body>
	   <?php 
			    //This includes the heading section (Logo, Navigation, Login form)  
				include_once "section_bottom/header.php"		
		?>
	    
		<main class="container-fluid" style="margin-bottom: 40px;min-height: 600px">
			<?php 
			     // This section is the homepage banner slider.
			 ?>
			<section class="row" id="banner-cont">
				<div class="owl-carousel"> <?php // owl-carousel is a highly customizable javascript(jquery) plugin for slide show. we used it here to achieve the slide show in the homepage. This is the "class(owl-carousel)" we used to initialize it in the JS script ?>
					

					<?php 
					    $companyID = 1;
					    // This SQL statement queries the database and returns all the banners(with their details) uploaded by the admin for display. NOTE: "<>" simply means "NOT EQUAL TO" in SQL. Those with visibility = 0 , are those that were deleted by the admin. Though what the admin sees in the UI is DELETE this Banner , but we the programmers dont execute the SQL delete statement instead we have a column called "visibility" that flags for delete. This just to keep record of activities.
						$banner = $con->prepare("SELECT a.id,a.title,a.b_desc,a.file_name,a.date_added from banner a where a.biz_id = ? and a.visibility <> '0' order by a.date_added desc") or die($con->error);

					    $banner->bind_param('i',$companyID) or die($con->error);
					    $banner->execute();
					    $banner->bind_result($bannerID,$bannerTitle,$bannerDesc,$bannerFileName,$bannerDate);
					    $banner->store_result() ;
                      
                      if($banner->num_rows > 0){

                      	// we already know that a while statement is used to make a loop. So the same here, this while statement goes through the returned(fetched) result and for each result it founds, it prints(printf) the banner HTML snippet within it.
						while($banner->fetch()){
							printf('<div style="position:relative;background: url(\'%s%s\') no-repeat 0px/cover;" class="banner-item">
										<div class="banner-overlay">
												<div style="position:absolute;bottom:20px;left:30px;">
													<h4 style="font-size:40px;">%s</h4>
													<div style="margin-left:40px;">
															%s
													</div>
												</div>
										</div>
										<div class="overlay-divider-left"></div>
										<div class="overlay-divider-right"></div>
								    </div>',BANNER_DIR,$bannerFileName,$bannerTitle,$bannerDesc);
						}
					  }else{
					  	  echo "empty";
					  } 
		
					?>
					
				</div>
			</section>
			<section>
				<h1 style="text-align: center;margin-bottom: 50px"><span style="border-bottom:6px solid #616161;font-family:verdana;padding-bottom:16px;font-size: 24px;">What's New</span></h1>
			</section>
			<section class="row" id="causes">
				<?php 
			     // This is the News section.
			     ?>
				 <div class="col-md-3 no-pad">
				 	 <div class="col-inside">
				 	 	<div class="col-head">
				 	 		<h4 style="color: #222">News</h4>
				 	 	</div>
				 	 	<div class="col-body">
				 	 		

				 	 		<?php 
				 	 		    $companyID = 1; //this can be in a cookie

				 	 		    // The Statement below gets all the uploaded news by the admin from the "news" table in the "charity" database.
								$news = $con->prepare("SELECT a.id,a.title,a.body,a.main_image,a.date_created,b.username from news a left join user_auth b on a.author = b.user_id where a.biz_id = ? order by a.date_created desc") or die($con->error);
							    $news->bind_param('i',$companyID) or die($con->error);
							    $news->execute();
							    $news->bind_result($newsID,$newsTitle,$newsBody,$newsImage,$newsDate,$author);
							    $news->store_result() ;
							    if($news->num_rows > 0){
						      	     while($news->fetch()){
						      	   
							?>

				 	 		<div class="single-news-cont">
					 	 		<img src="<?php echo POST_IMG_DIR.$newsImage ?>" class="news-img">
					 	 		<div class="news-text">
					 	 			<h5 class="news-head"><a href="eventspage.php"><?php echo $newsTitle ?> </a></h5>
					 	 			<span class="news-caption">
					 	 				<?php echo strip_tags(html_entity_decode($newsBody)) ?>
					 	 			</span>
					 	 		</div>
					 	 		<div class="clearfix"></div>
					 	 	</div>

					 	 	<?php } }else{ echo '<div class="default-message"> No News Yet</div>'; } ?>

				 	 	</div>	
				 	 </div>
				 </div>
				 <div class="col-md-9" style="padding-left:0px;">
				 	<div class="col-md-4" style="margin-top:10px;padding:0px;">
				 		<div style="padding:20px;height:360px;background:#9e9e9e;">
				 			<h4 style="color:#000;">Latest Events</h4>
				 			<img style="width:100%;" src="resources/reports.png">
				 			<div>Find out which are the latest events and join! Collect money and donate to your favorite theme!</div>
				 			<div><a href="eventspage.php">Click Here!</a></div>
				 		</div>
				 	</div>
				 	<div class="col-md-4" style="margin-top:10px;padding:0px;">
				 		<div style="padding:20px;height:360px;background:#000;">
				 			<h4 style="color:#fff;">Questions?</h4>
				 			<img style="width:100%;margin:20px 0px;" src="resources/doubts.jpg">
				 			<div style="color:#999;">Any doubts about how QCF works? Don´t worry. We can Help you. Just Click Here for more information!</div>
				 			<div><a href="faqpage.php">Click Here!</a></div>
				 		</div>
				 	</div>
				 	<div class="col-md-4" style="margin-top:10px;padding:0px;">
				 		<div style="padding:20px;height:360px;background:rgb(216, 220, 221);">
				 			<h4 style="color:#000;">About QFC</h4>
				 			<img style="width:100%;margin:20px 0px;" src="resources/qfc.png">
				 			<div>Find out how Quartet Community Foundation works.You can be an ambassador and be part of the philatropy team!</div>
				 			<div><a href="#">Click Here!</a></div>
				 		</div>
				 	</div>
				 	
				 	
				 </div>	 
			</section>
		</main>
		<footer>
			
		</footer>















		<?php 
           // the two lines below are for the popups. The first one is the donation box that popups up when a user clicks on the donate button. While the second line is the status box that notifies the user of the status of an action. like "Donation successful !. Thank You"
		   include_once "popups/modals/donate.php"; 
		   include_once "popups/notifiers/general.php"; 
		  //////////////////////////////////////////////////////////////////////////////////////////////////////////////
		  /////////////////////   General(in all pages) external scripts and activators    /////////////////////////////
		  //////////////////////////////////////////////////////////////////////////////////////////////////////////////
		   // the line below is the javascript that controls this page. This is also where plugins like Owl-Carousel are initialized.
		   include_once "section_bottom/general.php"; 





		?>

</body>
</html>