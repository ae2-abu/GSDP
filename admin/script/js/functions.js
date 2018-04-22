function getError(errArray){
    			var cont = '<h4 class="error-head">Please check the following fields:</h4><ul class="error-body">';
    			for (var i = 0; i < errArray.length; i++) {
    				cont += "<li>"+errArray[i]+"</li>";
    			}
    			    cont += "</ul>";
		

						$('#status-box').appendTo('body').css({background:'#FA0614',fontSize:'16px'}).html(cont).fadeIn(1000,function(){});
		    			setTimeout(function(){
		    				$('#status-box').fadeOut(2000);
		    			},8000);
		    }