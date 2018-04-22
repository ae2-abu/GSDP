        /////////////////////////////////////////////////////////////////////////////////////
		///////////////////     NEW POST SUBMISSION FORM HANDLER     ////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////

		(function($) { 
			$('#submit-btn').on('click',function(e){
				e.preventDefault();
				$('form#login').submit();
			})



			$('form#login').on('submit',function(e){
				e.preventDefault();

			var allFields = JSON.parse(formToJson(this)) ;
    	    var error = [];
			     if(typeof allFields.uname =='undefined'){
			     	error.push("Username field");
			     } if(typeof allFields.pwd =='undefined'){
			     	error.push("Password Field");
			     } 
    	if(error.length==0){
    			$.ajax({
			          url:'/cpu/login.php',
			          data:allFields,
			          type:'POST',
			          dataType:'json',
			 
			          success:function(data, status){
			          	if(data.success==1){
							window.open("index.php","_SELF");
			          		
			          	}else if(data.success==0){ //exist
			          		$('#status-box').appendTo('#input-cont').css({background:'#780023',fontSize:'16px',fontFamily:'calibri'}).html('<i class="ion ion-alert-circled" style="color:#FF9F2A;"></i> username or password incorrect !').fadeIn(1000,function(){$('#submitNew').html('submit').fadeIn(2000);});
				    			setTimeout(function(){
				    				$('#status-box').fadeOut(2000);
				    			},3000);
			          	}
			          	
			          },
			          error:function(xhr, status, error){alert(xhr.responseText + error)}
			   		 });
    		}else{
				    getError(error);
    		}
           

  });
		
	})(jQuery);



	/////////////////////////////////////////////////////////////////////////////////////
		///////////////////    Logout Handler     ////////////////////////
		/////////////////////////////////////////////////////////////////////////////////////
		(function($) { 
			$('#logout-btn').on('click',function(e){
				e.preventDefault();
    			$.ajax({
			          url:'/cpu/logout.php',
			          type:'POST',
			          dataType:'json',
			 
			          success:function(data, status){
			          	if(data.success==1){
							window.open('/',"_SELF");
			          		
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