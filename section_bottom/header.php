<div style="padding-left: 20px"><img src="resources/viper.png"></div>
		<header>
			<ul style="float:left;margin:0px;">
			   	<li><a href="/">Home Page</a></li>
			   	<li><a href="donationpage.php">Donation Page</a></li>
			   	<li><a href="eventspage.php">Event Page</a></li>
			   	<li><a href="faqpage.php">FAQ Page</a></li>
			   	<li><a href="profilepage.php">Profile Page</a></li>
			   	<div class="clearfix"></div>
			</ul>
			
			   


     <?php 
	     // This section has an if-else statement that checks if a user is logged in (checks if the users username session variable is set) if yes it displays line 92 – 107 else (if not logged in ) , it then outputs line 112 – 124 (the login form)
	 ?>
           <?php if(isset($_SESSION['uname'])){ ?>


			   <div id="user-info-cont" class="dropdown">
                    <div  data-toggle="dropdown" >
				   	  <img src="resources/users/kobo.jpg" class="ppix">
				   	  <div class="udetail" >
				   	  	 <span class="uname"><?php echo $my_username; ?></span><br>
				   	  	 <span class="uunit"><?php echo $my_dept; ?></span>
				   	  </div>
				   </div>
                    <ul class="dropdown-menu" role="menu"> 
                        <li role="presentation"> <a href="#">Profile</a> </li>
                        <?php if($my_status == 1){ ?> 
                        <li role="presentation"> <a href="manage">Manage</a> </li>
                        <?php } ?> 
                        <li role="presentation"> <a href="#" id="logout-btn">Logout</a> </li>
                    </ul> 
               </div> 

			<?php }else{ ?>


			   <div style="float:right;position:relative;left:-20px;">
			   	   <form id="login" action="#" method="POST">
			   	   	   <div class="nav-form-field-cont">
					   	   <input type="text" name="uname" placeholder="username">
					   </div>
					   <div class="nav-form-field-cont">
					   	   <input type="password" name="pwd" placeholder="password">
					   </div>
					   <div class="nav-form-field-cont">
					   	   <a href="#" id="submit-btn">login</a>
					   </div>
			   	   </form>
			   </div>
			   



           <?php } ?>

			   <div class="clearfix"></div>


		</header>