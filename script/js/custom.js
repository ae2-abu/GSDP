        ///////////////////////////////////////////////////////////////////////////////////////////////////////
		////////////////     This is the script that handles both login and logout     ////////////////////////
		///////////////////////////////////////////////////////////////////////////////////////////////////////
        
		(function($) { 

			// this script attaches click event listener to the login submit buton 
			$('#submit-btn').on('click',function(e){
				e.preventDefault();
				$('form#login').submit(); // this submits the login form once the user clicks on the "LOGIN" button
			})


           // this is the code that runs as a result of the click event ($('form#login').submit()) in the code above
			$('form#login').on('submit',function(e){
				e.preventDefault();

			var allFields = JSON.parse(formToJson(this)) ; // this is where we made use of the form-to-json plugin to convert the
			                                               // form fields to JSON for easy transmission to the server.
    	    

    	    var error = []; // this empty array is used to store any error detected in the submitted data. (validation)
			     if(typeof allFields.uname =='undefined'){
			     	error.push("Username field"); // if there is error, we push the type of error to the error array we declared above
			     } if(typeof allFields.pwd =='undefined'){
			     	error.push("Password Field"); // if there is error, we push the type of error to the error array we declared above
			     } 
    	if(error.length==0){ // if no error in the array 
    		 // the script below is what we call the AJAX request. It asynchronously makes request to the 
    		 // server without refreshing/reloading the whole page
    			$.ajax({
			          url:'./cpu/login.php',
			          data:allFields,
			          type:'POST',
			          dataType:'json',
			 
			          success:function(data, status){
			          	if(data.success==1){ // remember in the "/cpu/login.php" file we outputed(echoed) either "{"success":"1"}"
			          		                 // or "{"success":"0"}" depending on wether the user authentication is successful or not
			          		                 // This now is what this code is checking "data.success==1". 

							window.open("index.php","_SELF"); // if "data.success==1" ,  open index.php again(this the same thing as refreshing the page)
			          		
			          	}else if(data.success==0){ // Else the script within here pops/ fades in the status-box with the message "username or password incorrect"
			          		$('#status-box').appendTo('#input-cont').css({background:'#780023',fontSize:'16px',fontFamily:'calibri'}).html('<i class="ion ion-alert-circled" style="color:#FF9F2A;"></i> username or password incorrect !').fadeIn(1000,function(){$('#submitNew').html('submit').fadeIn(2000);});
				    			setTimeout(function(){
				    				$('#status-box').fadeOut(2000); // this fades the status bar out after 2seconds
				    			},3000);
			          	}
			          	
			          },
			          error:function(xhr, status, error){alert(xhr.responseText + error)}
			   		 });
    		}else{
				    getError(error); // this is a javascript user defined function that is called to handle error message. 
				                     // It is the red background error message that pops up when one makes mistake trying to login. 
    		}
           

  });
		
	})(jQuery);



	/////////////////////////////////////////////////////////////////////////////////////
		///////////////////    Logout Handler     ////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////

		// EVERYTHING HERE HAVE BEEN EXPLAINED IN THE LOGIN SCRIPT ABOVE

		(function($) { 
			$('#logout-btn').on('click',function(e){
				e.preventDefault();
    			$.ajax({
			          url:'./cpu/logout.php',
			          type:'POST',
			          dataType:'json',
			 
			          success:function(data, status){
			          	if(data.success==1){
							window.open('index.php',"_SELF");
			          		
			          	}else{ //exist
			          		$('#status-box').css({background:'#FA0614',fontSize:'16px'}).html("cant logout").fadeIn(1000,function(){$('#submitNew').html('submit').fadeIn(2000);});
				    			setTimeout(function(){
				    				$('#status-box').fadeOut(2000);
				    			},3000);
			          	}
			          	
			          },
			          error:function(xhr, status, error){alert(xhr.responseText + error)}
			   		 });
    		
  				});
		
	})(jQuery);