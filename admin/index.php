<?php
	 //- is the php inbuilt function that activates session (keeping track of users status across  different pages) in the script. Note: This particular line 2, must be placed in ALL the pages that wants to keep track of users authentication/login status. And also Note that for it to work , it must come before any output is made. So that’s why its at line 2 of the page.
	session_start(); 
	///each is an external script included in the index.php for modularity and reusability. The reason those scripts are separated from index.php is because they will be needed in some other pages and to avoid repeating the same code in those pages which not only consume space , but will also make the work tedious as any future changes simply means we have to go through all thise pages and modify them individually . both require_once() and include_once() are php inbuilt functions for including external files to a file(index.php).

	///////////////////////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////////////////////

	//includes the connection.php that enables PHP to connect and communicate to the database. To connect to a database , you have to provide four(4) basic details : the Host(localhost), the user(root), the password(blank), the database(charity) you want to connect to.
    require_once("settings/connect.php");

    //the configuration file which we use to resolve file paths
	require_once("settings/config.php");

	//includes the function.php file which contains all the user defined php functions used in the app(site) like the formatted date functions,.
	require_once("settings/functions.php");
    
    // This includes the script that checks wether a user is allowed to view this page or not. In short it is the padlock of this page and only a user that is logged in can view this page else the user will be sent to the login page. Remove this page, and you dont need to login to access the page.
	include_once ("auth/session_others.php");

	//includes the user_info.php  file which is a script that gets the logged in user’s infos from the database and makes it readily available so we can use it anytime we wish. 
	include_once ("settings/user_info.php");
	
	$bizID = 1; // this should be comming from a request

// The following script below is the one responsible for querying the database to get the theme(colors) set by the admin.Just like we described in the root index.php file.
    $theme = $con->prepare("SELECT id,biz_id,prime_color,second_color,color_3,color_4,color_5,color_6,color_7,color_8 from templates where biz_id = ? and is_default = '1' ") or die($con->error);
    $theme->bind_param('i',$bizID) or die($con->error);
    $theme->execute();
    $theme->bind_result($themeID,$bizID,$primeColor,$secondColor,$color3,$color4,$color5,$color6,$color7,$color8);
    $theme->store_result() ;

    if($theme->num_rows > 0){
    	$theme->fetch() ;
    }

   // $root = '/myprojects/charity/';
   $root = '/';    //when in virtual host
   

?>
<!DOCTYPE html>
<html>
<head>
	<title>snatch</title>
	<!-- ///////////////////////////////  ionicons   ///////////////////////////////////// -->
	<link rel="stylesheet" type="text/css" href="<?php echo $root; ?>admin/style/ionicons/css/ionicons.min.css">
	<!-- ///////////////////////////////  bootstrap   ///////////////////////////////////// -->
	<link rel="stylesheet" type="text/css" href="<?php echo $root; ?>admin/style/bootstrap/css/bootstrap.min.css">
	<!-- ///////////////////////////////  datatables plugin css  ///////////////////////////////////// -->
	<link rel="stylesheet" type="text/css" href="<?php echo $root; ?>admin/script/js/plugins/datatables/media/css/jquery.dataTables.min.css">
	<!-- ///////////////////////////////  dropzone plugin css  ///////////////////////////////////// -->
	<link rel="stylesheet" type="text/css" href="<?php echo $root; ?>admin/script/js/plugins/dropzone/dist/min/dropzone.min.css">
	<!-- ///////////////////////////////  owl carousel plugin css  ///////////////////////////////////// -->
	<link rel="stylesheet" type="text/css" href="<?php echo $root; ?>admin/script/js/plugins/owl-carousel/owl.carousel.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $root; ?>admin/script/js/plugins/owl-carousel/owl.theme.css">
	<!-- ///////////////////////////////  spectrum picker plugin css   ///////////////////////////////////// -->
	<link rel="stylesheet" type="text/css" href="<?php echo $root; ?>admin/script/js/plugins/spectrum/spectrum.css">
	<!-- ///////////////////////////////  general css   ///////////////////////////////////// -->
	<link rel="stylesheet" type="text/css" href="<?php echo $root; ?>admin/style/general.css">

	<!-- ///////////////////////////////  This page only (css)   ///////////////////////////////////// -->
	<link rel="stylesheet" type="text/css" href="<?php echo $root; ?>admin/style/style.css">
</head>
<body>
		<header>
			   <ul style="float:left;margin:0px;">
			   	<li><a href="/">Back to site</a></li>
			   	<!-- <li><a href="#">Dashboard</a></li> -->
			   	<div class="clearfix"></div>
			   </ul>

			   <div id="user-info-cont" class="dropdown">
                    <div  data-toggle="dropdown" >
				   	  <img src="/resources/users/kobo.jpg" class="ppix">
				   	  <div class="udetail" >
				   	  	 <span class="uname"><?php echo $my_username; ?></span><br>
				   	  	 <span class="uunit"><?php echo $my_dept; ?></span>
				   	  </div>
				   </div>
                    <ul class="dropdown-menu" role="menu"> 
                        <li role="presentation"> <a href="#">Profile</a> </li>
                        <?php if($my_status == 1){ ?> 
                        <li role="presentation"> <a href="#">Manage</a> </li>
                        <?php } ?> 
                        <li role="presentation"> <a href="#" id="logout-btn">Logout</a> </li>
                    </ul> 
               </div> 

			   <div class="clearfix"></div>


		</header>
		<main class="container-fluid">
			<section class="row">
				 <div class="col-md-2 sidebar" style="padding:0px;">
				 	 <?php 
				 	 	// The code snippet below is the sidebar. We set the active link background color by first checking the page we are in. Any page we visit we simple compare and add the css class "active" to the appropriate link.
				 	 ?>
				 	 <ul>
				 	 	<li><a href="<?php echo $root; ?>manage/news" class="<?php if(strtoupper($_GET['page']) == 'NEWS'){ echo 'active'; } ?>"><i class="ion ion-ios-compose-outline" style="position: relative;top: ;"></i> News</a></li>

				 	 	<li><a href="/manage/projects" class="<?php if(strtoupper($_GET['page']) == 'PROJECTS'){ echo 'active'; } ?>"><i class="ion ion-ios-bookmarks-outline" style="position: relative;top: ;"></i> Events</a></li>

				 	 	<li><a href="/manage/users" class="<?php if(strtoupper($_GET['page']) == 'USERS'){ echo 'active'; } ?>"><i class="ion ion-ios-people" style="position: relative;top: ;"></i> Users</a></li>

				 	 	<li><a href="/manage/banner" class="<?php if(strtoupper($_GET['page']) == 'BANNER'){ echo 'active'; } ?>"><i class="ion ion-ios-albums-outline" style="position: relative;top: ;"></i> Banner</a></li>

				 	 	<li><a href="/manage/theme" class="<?php if(strtoupper($_GET['page']) == 'THEME'){ echo 'active'; } ?>"><i class="ion ion-ios-medkit-outline" style="position: relative;top: ;"></i> Theme</a></li>

				 	 	<li><a href="/manage/template" class="<?php if(strtoupper($_GET['page']) == 'TEMPLATE'){ echo 'active'; } ?>"><i class="ion ion-ios-list-outline" style="position: relative;top: ;"></i> Template</a></li>

				 	 	<li><a href="/manage/donations" class="<?php if(strtoupper($_GET['page']) == 'DONATIONS' || strtoupper($_GET['page']) == 'MY_DONATIONS'){ echo 'active'; } ?>"><i class="ion ion-medkit" style="position: relative;top: ;"></i> Donations</a></li>
				 	 </ul>
				 </div>
				  <div class="col-md-10">
				 	   <?php
				 	   // This is the switch statement that does the routing. As you can see, it checks for the value of $_GET['page'] which it gets from the URL and routes the user to the aprropriate page(includes the appropriate page) . Notice the "default" is "template.php", that is the page a logged in user( admin ) sees first. you can change it to any other page just choice.
				 	   		switch ($_GET['page']) {
				 	   			case 'users':
				 	   				include "pages/users.php";
				 	   				break;
				 	   			case 'add_user':
				 	   				include "pages/user-new.php";
				 	   				break;

				 	   			case 'banner':
				 	   				include "pages/banner.php";
				 	   				break;

				 	   			case 'news':
				 	   				include "pages/news.php";
				 	   				break;

				 	   			case 'add_news':
				 	   				include "pages/news-new.php";
				 	   				break;

				 	   			case 'projects':
				 	   				include "pages/projects.php";
				 	   				break;

				 	   			case 'add_project':
				 	   				include "pages/project-new.php";
				 	   				break;

				 	   			case 'donations':
				 	   				include "pages/donations.php";
				 	   				break;

				 	   			case 'my_donations':
				 	   				include "pages/my-donations.php";
				 	   				break;


				 	   			case 'template':
				 	   				include "pages/template.php";
				 	   				break;

				 	   			case 'theme':
				 	   				include "pages/themes.php";
				 	   				break;
				 	   			
				 	   			default:
				 	   				include "pages/template.php";
				 	   				break;
				 	   		}

				 	   ?>
				 </div>
			</section>
		</main>
		<footer>
			
		</footer>















		<?php 
		  //////////////////////////////////////////////////////////////////////////////////////////////////////////////
		  /////////////////////   General(in all pages) external scripts and activators    /////////////////////////////
		  //////////////////////////////////////////////////////////////////////////////////////////////////////////////
		  
		  //The line is the status box that notifies the user of the status of an action. like "Banner removed successful !."
		   include_once "popups/notifiers/general.php"; 

		   // the line below is the javascript that controls this page. This is also where plugins like dataTables,dropzone,etc are initialized.
		   include_once "section_bottom/general.php"; 



		?>
		
	

</body>
</html>