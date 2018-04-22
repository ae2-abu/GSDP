<?php
    ///  This file contains all the javascript used inside index.php. Below we have imported(included) some external js(javascript)files. 
 ?>
<!-- //////////////////////////  jQuery  [ https://jquery.com ]////////////////////////////////// -->
<!-- jQuery -  a javascript library to make our DOM manipulation easier and faster and also makes it possible to use alot of plugins that depends on jQuery to function.  -->
<script type="text/javascript" src="/admin/script/js/jquery.js"></script>

<!-- /////////////////  CKEditor(jQuery plugin) [ http://owlcarousel2.github.io/OwlCarousel2/ ] /////////////////////// -->
<!-- This is the fancy Rich-Text-Editor(like mini MSWord) found in the News,New project,etc section. It can be used to manipulate(edit) the text   -->
<script type="text/javascript" src="/admin/script/js/plugins/ckeditor/ckeditor.js"></script>

<!-- /////////////////  dataTable(jQuery plugin) [ http://owlcarousel2.github.io/OwlCarousel2/ ] /////////////////////// -->
<!-- This is the plugin that makes our Tables sortable, paginated, filterable, searchable,etc. It is a very powerful and highly customizable jQuery plugin   (its associated stylesheet(css) is in the head section of the index.php ) -->
<script type="text/javascript" src="/admin/script/js/plugins/datatables/media/js/jquery.dataTables.min.js"></script>

<!-- /////////////////  Dropzone [ http://owlcarousel2.github.io/OwlCarousel2/ ] /////////////////////// -->
<!-- This is a jQuery independent plugin. This is the plugin that helps us with a fancy file upload. You also get to see the progress bar of the file being uploaded   -->
<script type="text/javascript" src="/admin/script/js/plugins/dropzone/dist/min/dropzone.min.js"></script>

<!-- /////////////////  csv-to-json(jQuery plugin) [ http://owlcarousel2.github.io/OwlCarousel2/ ] /////////////////////// -->
<!-- we have not used this plugin yet. But its gonna help the admin add multiple users from a CSV file instead of adding them one by one which would be tedious   -->
<!-- <script type="text/javascript" src="/admin/script/js/plugins/csv-to-json/papaparse.min.js"></script> -->

<!-- //////////////////////////  Bootstrap [ https://getbootstrap.com ] ////////////////////////////////// -->
<!-- This file activates some bootstrap inbuilt scripts and plugins like tooltip,modal,etc -->
<script type="text/javascript" src="/admin/style/bootstrap/js/bootstrap.min.js"></script>

<!-- //////////////////////////  bpopup(jQuery Plugin) [ http://dinbror.dk/bpopup ] ////////////////////////////////// -->
<!-- This file is responsible for the modals that popups up.E.g: when a banner is deleted successfully, that popup that displays the success message . -->
<script type="text/javascript" src="/admin/script/js/plugins/bpopup/bpopup.min.js"></script>

<!-- /////////////////////   form to json  [ https://github.com/jhanxtreme/form-to-json ]    ///////////////////////// -->
<!-- this plugin below serializes submitted form and converts the fields to json for easier access. -->
<script type="text/javascript" src="/admin/script/js/plugins/form-to-json/form-to-json.js"></script>

<!-- /////////////////////   spectrum  [ https://github.com/jhanxtreme/form-to-json ]    ///////////////////////// -->
<!-- this plugin below helps us to easily select color in the template page. Its that small box that when you click , you can select any color of you choice for a section of the template. -->
<script type="text/javascript" src="/admin/script/js/plugins/spectrum/spectrum.js"></script>

<!-- The two lines below are user defined scripts  -->
<script type="text/javascript" src="/admin/script/js/functions.js"></script>
<script type="text/javascript" src="/admin/script/js/custom.js"></script>

<!-- //////////////////////////  Custom  ////////////////////////////////// -->
<script type="text/javascript">
	$(document).ready(function(){
        $('table').dataTable({order:[[0,'desc']],});
     ////////////////////  Tooltip activator   ////////////////////////////////
		// $(function () { $("[data-toggle='tooltip']").tooltip(); });

	
	////////////////////  dropzone activator   ////////////////////////////////
if($('#dropzone-banner').length){   ////// check if the element exist
	var dzBanner = new Dropzone('#dropzone-banner',
		{url: "/admin/script/php/plugins/upload/banner_upload.php",
		 method:'post',
		 autoProcessQueue:false,
		 parallelUploads:1,
		 dictRemoveFile:''
		 ,dictCancelUpload:'',
		 dictDefaultMessage:'<span>Please drag and drop the file here</span><br><span style="font-size:15px"> or click to browse for it</span><br><span style="font-size:15px;color:#888;font-weight:normal;">NOTE : ( Only image files are allowed and maximum file size is 2MB )</span>',
		 uploadMultiple:false,
		 init:function(){
                                      ////////////////////////////////////////////
                                      ////////////////////////////////////////////
                                        var _this = this;    //closure
                                        // set event listeners
                                        this.on('addedfile',function(file){
                                                  // Remove the previous image if user selects another. Since we only want one file at a time
                                                    if(_this.files.length>1){
                                                        _this.removeFile(_this.files[0]);
                                                    }
                                                    // get a copy of the original file(image) for preview on the chat pane
                                                     var reader = new FileReader();
                                                     reader.onload = function(e){
                                                          var newSrc = reader.result;
                                                          // $('#pp-chat-template-file .pp-chat-content-file .chat-file').attr('src',newSrc);
                                                          // $('#pp-chat-template-file .pp-chat-content-file .chat-file').closest('a').attr('href',newSrc);
                                                     }
                                                     reader.readAsDataURL(file);
                                        });
                                        this.on('reset',function(){
                                          // $('#magic-btn').fadeOut(1000);
                                        });
                                        this.on('sending',function(file,xhr,formData){
                                          
                                             // window.bPopupLoading = $("#loading").bPopup({modalColor:'#002E56',modalClose: false});
                                             var bannerTitle = $('#dz-title').val();
                                             var bannerDesc = $('#dz-body').val();
                                             formData.append('title',bannerTitle);
                                             formData.append('desc',bannerDesc);
                                             
                                        });
                                        this.on('success',function(file,data){
                                        });
                                       } // close dropzone init function
                            } //close dropzone options
	);
}
	///dropzone end

	 $('#dz-banner-submit-btn').on('click',function(e){

                  e.preventDefault();
                  // check if the TITLE and DESCRIPTION is empty. If yes Throw error
                 if($.trim( $('#dz-title').val()).length > 0 || $.trim( $('#dz-body').val()).length > 0){
                 		//there is value check the dropzone for file now
                 		if(dzBanner.files.length > 0 ){ // there is a file so process 
                       		 dzBanner.processQueue();
                  		}else{
                  			alert('you havent selected a file yet');
                  		}
                 }else{
                 	alert('the title of the banner and the Description is required')
                 }
                  

      });

	 //////////////////////////////////////////////////////////////////////////////////////////////////



//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////  NEWS   ///////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
if($('#ck-news').length){   ////// check if the element exist 
window.ckNews = CKEDITOR.replace('ck-news',{	toolbar:'Basic',
                                            // uiColor: '#222222' ,
                                            width:'100%',
                                            toolbarGroups: [
												{ name: 'document',	   groups: [ 'mode', 'document' ] },			// Displays document group with its two subgroups.
										 		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },    // Group's name will be used to create voice label.
										 		{ name: 'links' },			
										 		// '/',																// Line break - next group will be placed in new line.
										 		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] }
										 		
											],
                                            filebrowserBrowseUrl:'/plugins/ckeditor/ckfinderNew/ckfinder.html',
                                            filebrowserUploadUrl:'/plugins/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'})
}
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////  dropzone NEWS   //////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
if($('#dropzone-news').length){   ////// check if the element exist   
	var dzNews = new Dropzone('#dropzone-news',
								{
								 url: "/admin/script/php/plugins/upload/news_upload.php",
								 method:'post',
								 autoProcessQueue:false,
								 parallelUploads:1,
								 dictRemoveFile:''
								 ,dictCancelUpload:'',
								 dictDefaultMessage:'<span>Please drag and drop the file here</span><br><span style="font-size:15px"> or click to browse for it</span><br><span style="font-size:15px;color:#888;font-weight:normal;">NOTE : ( Only image files are allowed and maximum file size is 2MB )</span>',
								 uploadMultiple:false,
								 init:function(){
                                      ////////////////////////////////////////////
                                      ////////////////////////////////////////////
                                        var _this = this;    //closure
                                        // set event listeners
                                        this.on('addedfile',function(file){
                                                  // Remove the previous image if user selects another. Since we only want one file at a time
                                                    if(_this.files.length>1){
                                                        _this.removeFile(_this.files[0]);
                                                    }
                                                    // get a copy of the original file(image) for preview on the chat pane
                                                     var reader = new FileReader();
                                                     reader.onload = function(e){
                                                          var newSrc = reader.result;
                                                          // $('#pp-chat-template-file .pp-chat-content-file .chat-file').attr('src',newSrc);
                                                          // $('#pp-chat-template-file .pp-chat-content-file .chat-file').closest('a').attr('href',newSrc);
                                                     }
                                                     reader.readAsDataURL(file);
                                        });
                                        this.on('reset',function(){
                                          // $('#magic-btn').fadeOut(1000);
                                        });
                                        this.on('sending',function(file,xhr,formData){
                                          
                                             // window.bPopupLoading = $("#loading").bPopup({modalColor:'#002E56',modalClose: false});
                                             var bannerTitle = $('#dz-title').val();
                                             var bannerDesc = ckNews.getData();
                                             formData.append('title',bannerTitle);
                                             formData.append('desc',bannerDesc);
                                             
                                        });
                                        this.on('success',function(file,data){
                                        });
                                       } // close dropzone init function
                            } //close dropzone options
	);
}
	///dropzone end

	 $('#dz-news-submit-btn').on('click',function(e){

                  e.preventDefault();
                  // check if the TITLE and DESCRIPTION is empty. If yes Throw error
                 if($.trim( $('#dz-title').val()).length > 0 || $.trim( ckNews.getData()).length > 0){
                 		//there is value check the dropzone for file now
                 		if(dzNews.files.length > 0 ){ // there is a file so process 
                       		 dzNews.processQueue();
                  		}else{
                  			alert('you havent selected a file yet');
                  		}
                 }else{
                 	alert('the title of the banner and the Description is required')
                 }
                  

      });


//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////  PROJECT   ///////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
if($('#ck-project').length){   ////// check if the element exist 
window.ckProject = CKEDITOR.replace('ck-project',{	toolbar:'Basic',
                                            // uiColor: '#222222' ,
                                            width:'100%',
                                            toolbarGroups: [
												{ name: 'document',	   groups: [ 'mode', 'document' ] },			// Displays document group with its two subgroups.
										 		{ name: 'clipboard',   groups: [ 'clipboard', 'undo' ] },    // Group's name will be used to create voice label.
										 		{ name: 'links' },			
										 		// '/',																// Line break - next group will be placed in new line.
										 		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] }
										 		
											],
                                            filebrowserBrowseUrl:'/plugins/ckeditor/ckfinderNew/ckfinder.html',
                                            filebrowserUploadUrl:'/plugins/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files'})
}
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////  dropzone PROJECT   //////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
if($('#dropzone-project').length){   ////// check if the element exist   
	var dzProject = new Dropzone('#dropzone-project',
								{
								 url: "/admin/script/php/plugins/upload/project_upload.php",
								 method:'post',
								 autoProcessQueue:false,
								 parallelUploads:1,
								 dictRemoveFile:''
								 ,dictCancelUpload:'',
								 dictDefaultMessage:'<span>Please drag and drop the file here</span><br><span style="font-size:15px"> or click to browse for it</span><br><span style="font-size:15px;color:#888;font-weight:normal;">NOTE : ( Only image files are allowed and maximum file size is 2MB )</span>',
								 uploadMultiple:false,
								 init:function(){
                                      ////////////////////////////////////////////
                                      ////////////////////////////////////////////
                                        var _this = this;    //closure
                                        // set event listeners
                                        this.on('addedfile',function(file){
                                                  // Remove the previous image if user selects another. Since we only want one file at a time
                                                    if(_this.files.length>1){
                                                        _this.removeFile(_this.files[0]);
                                                    }
                                                    // get a copy of the original file(image) for preview on the chat pane
                                                     var reader = new FileReader();
                                                     reader.onload = function(e){
                                                          var newSrc = reader.result;
                                                         
                                                     }
                                                     reader.readAsDataURL(file);
                                        });
                                        this.on('reset',function(){
                                          // $('#magic-btn').fadeOut(1000);
                                        });
                                        this.on('sending',function(file,xhr,formData){
                                          
                                             // window.bPopupLoading = $("#loading").bPopup({modalColor:'#002E56',modalClose: false});
                                             var projectTitle = $('#dz-title').val();
                                             var projectCat = $('#dz-cat').val();
                                             var projectDesc = ckProject.getData();
                                             formData.append('title',projectTitle);
                                             formData.append('category',projectCat);
                                             formData.append('desc',projectDesc);
                                             
                                        });
                                        this.on('success',function(file,data){
                                        });
                                       } // close dropzone init function
                            } //close dropzone options
	);
}
	///dropzone end

	 $('#dz-project-submit-btn').on('click',function(e){

                  e.preventDefault();
                  // check if the TITLE and DESCRIPTION is empty. If yes Throw error
                 if($.trim( $('#dz-title').val()).length > 0 || $.trim( ckProject.getData()).length > 0){
                 		//there is value check the dropzone for file now
                 		if(dzProject.files.length > 0 ){ // there is a file so process 
                       		 dzProject.processQueue();
                  		}else{
                  			alert('you havent selected a file yet');
                  		}
                 }else{
                 	alert('the title of the banner and the Description is required')
                 }
                  

      });
////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////  PROJECT END  ///////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////





	 /////banner remove 
	 $('.banner-remove-btn').on('click',function(e){

                  e.preventDefault();
                  
                 var bannerID = $(this).data('id');
              if(confirm('Please confirm you want to remove this Banner.')){ // confirm first this is not by mistake
                     $.ajax({
            				          url:'/admin/cpu/remove-banner.php',
            				          data:{'banner_id':bannerID},
            				          type:'POST',
            				          dataType:'json',
            				          success:function(data, status){
            				          	if(data.success==1){
            								$('#status-box').css({'background':'#000'}).html('Banner removed successfully').bPopup({modalColor:'#000',modalClose: false,autoClose:3000,opacity:0.9,onClose:function(){
            									 window.open("/manage/banner","_SELF");
            								}});
            				          		
            				          	}else if(data.success==0){ //exist
            				          		
            				          	}
            				          	
            				          },
            				          error:function(xhr, status, error){alert(xhr.responseText + error)}
    				   		    });
                  
               }
      });



/////theme remove 
   $('.del-theme-btn').on('click',function(e){

                  e.preventDefault();
                  
                 var itemID = $(this).data('id');
                 
                 if(confirm('Please confirm you want to delete this Theme.')){
                      $.ajax({
                          url:'/admin/cpu/remove-theme.php',
                          data:{'item_id':itemID},
                          type:'POST',
                          dataType:'json',
                          success:function(data, status){
                            if(data.success==1){
                        $('#status-box').css({'background':'#000'}).html('Theme removed successfully').bPopup({modalColor:'#000',modalClose: false,autoClose:3000,opacity:0.9,onClose:function(){
                           window.open("/manage/theme","_SELF");
                        }});
                              
                            }else if(data.success==0){ //exist
                              
                            }
                            
                          },
                          error:function(xhr, status, error){alert(xhr.responseText + error)}
                      });
                 }
                 
                  

      });



   /////theme remove 
   $('.del-user-btn').on('click',function(e){

                  e.preventDefault();
                  
                 var itemID = $(this).data('id');
                 
                 if(confirm('Please confirm you want to delete this User.')){
                      $.ajax({
                          url:'/admin/cpu/remove-user.php',
                          data:{'item_id':itemID},
                          type:'POST',
                          dataType:'json',
                          success:function(data, status){
                            if(data.success==1){
                                $('#status-box').css({'background':'#000'}).html('User removed successfully').bPopup({modalColor:'#000',modalClose: false,autoClose:3000,opacity:0.9,onClose:function(){
                                   window.open("/manage/users","_SELF");
                                }});
                              
                            }else if(data.success==45){ //exist
                              $('#status-box').css({'background':'#f00'}).html('Sorry You cant remove this user.').bPopup({modalColor:'#000',modalClose: false,autoClose:3000,opacity:0.9,onClose:function(){
                                   // window.open("/manage/users","_SELF");
                                }});
                            }
                            
                          },
                          error:function(xhr, status, error){alert(xhr.responseText + error)}
                      });
                 }
                 
                  

      });


   /////news remove 
   $('.del-news-btn').on('click',function(e){

                  e.preventDefault();
                  
                 var itemID = $(this).data('id');
                 
                 if(confirm('Please confirm you want to delete this news.')){
                      $.ajax({
                          url:'/admin/cpu/remove-news.php',
                          data:{'item_id':itemID},
                          type:'POST',
                          dataType:'json',
                          success:function(data, status){
                            if(data.success==1){
                                $('#status-box').css({'background':'#000'}).html('News removed successfully').bPopup({modalColor:'#000',modalClose: false,autoClose:3000,opacity:0.9,onClose:function(){
                                   window.open("/manage/news","_SELF");
                                }});
                              
                            }else if(data.success==45){ //exist
                              
                            }
                            
                          },
                          error:function(xhr, status, error){alert(xhr.responseText + error)}
                      });
                 }
                 
                  

      });


   /////project remove 
   $('.del-project-btn').on('click',function(e){

                  e.preventDefault();
                  
                 var itemID = $(this).data('id');
                 
                 if(confirm('Please confirm you want to delete this project.')){
                      $.ajax({
                          url:'/admin/cpu/remove-project.php',
                          data:{'item_id':itemID},
                          type:'POST',
                          dataType:'json',
                          success:function(data, status){
                            if(data.success==1){
                                $('#status-box').css({'background':'#000'}).html('Project removed successfully').bPopup({modalColor:'#000',modalClose: false,autoClose:3000,opacity:0.9,onClose:function(){
                                   window.open("/manage/projects","_SELF");
                                }});
                              
                            }else if(data.success==45){ //exist
                              
                            }
                            
                          },
                          error:function(xhr, status, error){alert(xhr.responseText + error)}
                      });
                 }
                 
                  

      });


   /////donation remove 
   $('.del-donation-btn').on('click',function(e){

                  e.preventDefault();
                  
                 var itemID = $(this).data('id');
                 
                 if(confirm('Please confirm you want to delete this donation.')){
                      $.ajax({
                          url:'/admin/cpu/remove-donation.php',
                          data:{'item_id':itemID},
                          type:'POST',
                          dataType:'json',
                          success:function(data, status){
                            if(data.success==1){
                                $('#status-box').css({'background':'#000'}).html('Donation removed successfully').bPopup({modalColor:'#000',modalClose: false,autoClose:3000,opacity:0.9,onClose:function(){
                                   window.open("/manage/donations","_SELF");
                                }});
                              
                            }else if(data.success==45){ //exist
                              
                            }
                            
                          },
                          error:function(xhr, status, error){alert(xhr.responseText + error)}
                      });
                 }
                 
                  

      });




    if($('input[name=new-theme]').length){  //checks if we are in the "theme" page
            $('#new-theme-submit-btn').on('click',function(e){

                  e.preventDefault();
                  
                 var newValue = $('input[name=new-theme]').val();
                 $.ajax({
                  url:'/admin/cpu/new-theme.php',
                  data:{'new_theme':newValue},
                  type:'POST',
                  dataType:'json',
                  success:function(data, status){
                    if(data.success==1){
                $('#status-box').css({'background':'#000'}).html('Theme added successfully').bPopup({modalColor:'#000',modalClose: false,autoClose:3000,opacity:0.9,onClose:function(){
                   window.open("/manage/theme","_SELF");
                }});
                      
                    }else if(data.success==0){ //exist
                      
                    }
                    
                  },
                  error:function(xhr, status, error){alert(xhr.responseText + error)}
              });
                  

           });
    }



	 if($('input[name=newuser]').length){ //checks if we are in the "user" page
	 	console.log('evist')
		 	$('input[name=newuser]').on('change',function(e){ 
		 		console.log('changed')
		 		var csv = $('input[name=newuser]').parse({
		 												config:{
		 													complete:function(r){
		 														console.log(r)
		 													},
		 													header: true,
		 													skipEmptyLines: true,
		 												},
		 												before:function(f,e){
		 													console.log(e);
		 													
		 													console.log(f);
		 												},
		 												complete:function(r){
		 													// console.log(e)
		 													console.log(r)

		 												},
		 												error:function(err,file){
		 													console.log(err +" and "+file);
		 												}
		 												
		 											});
		 		// console.log(csv)
		 	})
	 	
	 
	 }



 // initalizing( gets the color we got from database in the index.php and store it in javascript variable so js can use it)
         var primary = <?php echo '"'.$primeColor.'"'; ?> ;
         var second =  <?php echo '"'.$secondColor.'"'; ?> ;
         var color_3 = <?php echo '"'.$color3.'"'; ?>;
         var color_4 = <?php echo '"'.$color4.'"'; ?>;
         var color_5 = <?php echo '"'.$color5.'"'; ?>;
         var color_6 = <?php echo '"'.$color6.'"'; ?>;
         var color_7 = <?php echo '"'.$color7.'"'; ?>;

        // here Javascript is changing(updating) the color/background color of the different sections of the template preview.
         document.body.style.setProperty('--prev-primary',primary);
         document.body.style.setProperty('--prev-second',second);
         document.body.style.setProperty('--prev-col-3',color_3);
         document.body.style.setProperty('--prev-col-4',color_4);
         document.body.style.setProperty('--prev-col-5',color_5);
         document.body.style.setProperty('--prev-col-6',color_6);
         document.body.style.setProperty('--prev-col-7',color_7);




      $('.str-component,.str-component-2').on('click',function(e){
        e.preventDefault();

        var compTheme = $(this).data('theme'); //we ask the clicked element for which of the spectrum color picker to toggle

        var elem = 'input[name='+compTheme+']'; // we now use the info we got above to make the complete input type to toggle

        $(elem).spectrum('toggle'); //this where we toggles(opens/closes) the correct color picker.
        
        return false; // spectrum toggle option requires this line.
      })


     // the set of configuration below is what replaces the html INPUT element (in the template page) to a spectrum picker and individually configures them with their default colors.
      $('input[name=primary]').spectrum({
        replacerClassName: 'pickers-cont',
        color:primary,
        preferredFormat: "hex",
        move:function(color){
          // console.log(color.toHexString())
          document.body.style.setProperty('--prev-primary',color.toHexString())
        }
      });

      $('input[name=second]').spectrum({
        replacerClassName: 'pickers-cont',
        color:second,
        preferredFormat: "hex",
        move:function(color){
          // console.log(color.toHexString())
          document.body.style.setProperty('--prev-second',color.toHexString())
        }
      });

      $('input[name=color-3]').spectrum({
        replacerClassName: 'pickers-cont',
        color:color_3,
        preferredFormat: "hex",
        move:function(color){
          // console.log(color.toHexString())
          document.body.style.setProperty('--prev-col-3',color.toHexString())
        }
      });

      $('input[name=color-4]').spectrum({
        replacerClassName: 'pickers-cont',
        color:color_4,
        preferredFormat: "hex",
        move:function(color){
          // console.log(color.toHexString())
          document.body.style.setProperty('--prev-col-4',color.toHexString())
        }
      });

      $('input[name=color-5]').spectrum({
        replacerClassName: 'pickers-cont',
        color:color_5,
        preferredFormat: "hex",
        move:function(color){
          // console.log(color.toHexString())
          document.body.style.setProperty('--prev-col-5',color.toHexString())
        }
      });


      $('input[name=color-6]').spectrum({
        replacerClassName: 'pickers-cont',
        color:color_6,
        preferredFormat: "hex",
        move:function(color){
          // console.log(color.toHexString())
          document.body.style.setProperty('--prev-col-6',color.toHexString())
        }
      });

      $('input[name=color-7]').spectrum({
        replacerClassName: 'pickers-cont',
        color:color_7,
        preferredFormat: "hex",
        move:function(color){
          // console.log(color.toHexString())
          document.body.style.setProperty('--prev-col-7',color.toHexString()); // this is the script that changes the color of the element on mouse move, so i can live preview how it will look like in the element.
        }
      });
      
      //this also part of the initialization but at a different position.This sets the initial color of the spectrum element
      $('input[name=primary]').spectrum('set',primary);
      $('input[name=second]').spectrum('set',second);
      $('input[name=color-3]').spectrum('set',color_3);
      $('input[name=color-4]').spectrum('set',color_4);
      $('input[name=color-5]').spectrum('set',color_5);
      $('input[name=color-6]').spectrum('set',color_6);
      $('input[name=color-7]').spectrum('set',color_7);


      ////save theme
(function($) { 
      $('#save-theme-btn').on('click',function(e){
        e.preventDefault();
        $('form#theme').submit();
      })



      $('form#theme').on('submit',function(e){
        e.preventDefault();

      var allFields = JSON.parse(formToJson(this)) ;
          var error = [];
          console.log(allFields)
           if(typeof allFields.primary =='undefined'){
            error.push("Username field");
           } 
      if(error.length==0){
          $.ajax({
                url:'/admin/cpu/update-theme.php',
                data:allFields,
                type:'POST',
                dataType:'json',
                success:function(data, status){
                  if(data.success==1){
              $('#status-box').css({backgroundColor:'#000'}).html('Theme saved successfully !').bPopup({modalColor:'#000',modalClose: false,autoClose:3000,opacity:0.9});
                    
                  }else if(data.success==0){ //exist
                    
                  }
                  
                },
                error:function(xhr, status, error){alert(xhr.responseText + error)}
             });
        }else{
            getError(error);
        }
           

  });



    
  })(jQuery);





                 
 ////////////////////////////////////////////////////////////////////////////////////////////////////////////
 ////////////////////////////////////              new user form              ///////////////////////////////
 ////////////////////////////////////////////////////////////////////////////////////////////////////////////


                 $('form#new-user-form').on('submit',function(e){
              e.preventDefault();


            var allFields = JSON.parse(formToJson(this)) ;
                var error = [];
                 if(typeof allFields.username =='undefined'){
                  error.push("username field");
                 } 
            if(error.length==0){
                $.ajax({
                      url:'/admin/cpu/new-user.php',
                      data:allFields,
                      type:'POST',
                      dataType:'json',
                      success:function(data, status){
                        if(data.success==1){
                    $('#status-box').css({'background':'blue'}).html('user added successfully !').bPopup({modalColor:'#000',modalClose: false,autoClose:3000,opacity:0.9,onClose:function(){
                       window.open("/manage/users","_SELF");
                    }});
                          
                        }else if(data.success==0){ //exist
                          
                        }
                        
                      },
                      error:function(xhr, status, error){alert(xhr.responseText + error)}
                   });
              }else{
                  getError(error);
              }
                 

        });












	}); ///document.ready
                                
</script>
