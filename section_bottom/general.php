<?php
    ///  This file contains all the javascript used inside index.php. Below we have imported(included) some external js(javascript)files. 
 ?>
<!-- //////////////////////////  jQuery  [ https://jquery.com ]////////////////////////////////// -->
<!-- jQuery -  a javascript library to make our DOM manipulation easier and faster and also makes it possible to use alot of plugins that depends on jQuery to function.  -->
<script type="text/javascript" src="script/js/jquery.js"></script>

<!-- //////////////////////////  owlcarousel(jQuery plugin) [ http://owlcarousel2.github.io/OwlCarousel2/ ] ////////////////////////////////// -->
<!-- This file is responsible for the slide show in the homepage. It is what slides the banner uploaded by the admin  -->
<script type="text/javascript" src="script/js/plugins/owl-carousel/owl.carousel.js"></script>

<!-- //////////////////////////  bpopup(jQuery Plugin) [ http://dinbror.dk/bpopup ] ////////////////////////////////// -->
<!-- This file is responsible for the modals that popups up.E.g: clicking on the Donation button, the popup that comes up . -->
<script type="text/javascript" src="script/js/plugins/bpopup/bpopup.min.js"></script>


<!-- //////////////////////////  Bootstrap [ https://getbootstrap.com ] ////////////////////////////////// -->
<!-- This file activates some bootstrap inbuilt scripts and plugins like tooltip,modal,scrollspy,etc -->
<script type="text/javascript" src="style/bootstrap/js/bootstrap.min.js"></script>

<!-- /////////////////////   form to json  [ https://github.com/jhanxtreme/form-to-json ]    ///////////////////////// -->
<!-- this plugin below serializes submitted form and converts the fields to json for easier access. -->
<script type="text/javascript" src="script/js/plugins/form-to-json/form-to-json.js"></script>

<!-- The two lines below are user defined scripts  -->
<script type="text/javascript" src="script/js/functions.js"></script>
<script type="text/javascript" src="script/js/custom.js"></script>

<!-- //////////////////////////  Custom  ////////////////////////////////// -->
<script type="text/javascript">
	$(document).ready(function(){

     ////////////////////  Tooltip activator   ////////////////////////////////
     // Tooltip is the small black-background element(box) that popups up when one mouses over some items. It gives more info about an element being moused over on.,
		$(function () { $("[data-toggle='tooltip']").tooltip(); });
        
        ////////////////////  Owlcarousel activator   ////////////////////////////////
        // This is the code that initializes the slideshow(banner sliding) on the homepage. As you can see in the configuration, it has been set to display only two(2) banners(image) per view. also the autoplay is true meaning it slides automatically and so on.
		$('.owl-carousel').owlCarousel({
											items:2,
											autoPlay:true,
											// autoplayTimeout:200,
											merge:true
										});

		///////////      donation script   ///////////////////////
		// This is the script that runs when a user clicks on the donation button
		$('.donate-btn').on('click',function(e){
			e.preventDefault();
			var projectID = $(this).data('project-id');
			///// the AJAX call below is used to populate the Selection field in the Donation Modal
			$.ajax({
			          url:'/cpu/get_projects.php',
			          data:{'project_id':projectID},
			          type:'POST',
			          success:function(data, status){
			          	
							$('#donation-select').html(data); //populate the donation SELECT element

							//// the selection element has been initialized(populated) so we can now popup the modal
							window.donateModal = $('#donate-modal').bPopup({modalColor:'#000',opacity:0.9,closeClass:'close-donate'});
			          		
			          	
			          },
			          error:function(xhr, status, error){alert(xhr.responseText + error)}
			   		 }); 
			
			
		});


// When a user is done putting the details of his donation, and click on the final donate button, the code below runs.
		$('form#donate-form').on('submit',function(e){
							e.preventDefault(); //this prevents the default behaviour of the submit event because we are not making user of the "action" attribute in the form element instead we are using the "url" in the ajax call below.


						var allFields = JSON.parse(formToJson(this)) ;
			    	    var error = [];
						     if(typeof allFields.amount =='undefined'){
						     	error.push("amount field");
						     }if(typeof allFields.project =='undefined'){
						     	error.push("project field");
						     }  
			    	if(error.length==0){

			            // first alert the person to confirm he/she actually wants to execute this action and not by mistake.
			    		if(confirm('Please confirm you want to Donate to this project !')){
								$.ajax({
						          url:'/cpu/donation.php',
						          data:allFields,
						          type:'POST',
						          dataType:'json',
						          success:function(data, status){
						          	if(data.success==1){
										$('#status-box').css({'background':'#000'}).html('You have successfully dnated to this project ! Thank You').bPopup({modalColor:'#000',modalClose: false,autoClose:3000,opacity:0.9,onClose:function(){
											 // window.open("/manage/users","_SELF");
											 donateModal.close();
											 // alert('Thank You!')
										}});
						          		
						          	}else if(data.success==0){ //exist
						          		
						          	}
						          	
						          },
						          error:function(xhr, status, error){alert(xhr.responseText + error)}
						   		 });
							}
			    			
			    		}else{
							    getError(error);
			    		}
			           

			  });
		
	});
</script>
