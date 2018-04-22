<?php 
// this file contains all the user defined functions used in this website

// This function formats the unreadable timestamp to something human readable and with small intelligence.
	function get_post_formated_time($dbTime){
	  $totalTime=(time()+3600-strtotime($dbTime));
	  $processHour=$totalTime/3600;
	  $hArray=explode('.', $processHour);
    if($hArray[0]>=1){ 
    	if($hArray[0]>=24 && $hArray[0]<=48){
    		$time = "yestarday by ".date('g:i a',strtotime($dbTime));
    	}else if($hArray[0]>48){
    		$time = "on ".date('l, j M Y',strtotime($dbTime));
    	}else{
    		$time=$hArray[0]." hours ago";
    	}    
	}else{
		$processMin=$totalTime/60;
		$mArray=explode('.', $processMin);
		if($mArray[0]>=1){  //
	      $time=$mArray[0]." min ago";
	     }else{
	     	$time=$totalTime." sec ago";
	     }
	}
	return $time;
}

// This function preps the input and sanitizes it against injections like SQL injection and likes.
function mysql_prep($input){
   $magic_quotes_active=get_magic_quotes_gpc();
   $new_enough_php=function_exists("mysql_real_escape_string");
   if($new_enough_php){
      if($magic_quotes_active){
	     $input=stripslashes($input);          //remove any effects made by get_magic_quotes_gpc and let mysql_real_escape_string do the work
	     $input=mysql_real_escape_string($input);}
	  }else{                                   //if not new php then check if get_magic_quotes_gpc is active. if not, add slashes manually.
	     if(!$magic_quotes_active){
		     $input=addslashes($input);
		 }
	  }
	  return htmlentities($input,ENT_QUOTES);
}

function redirect_to($location=NULL){
    if($location != NULL){
     header("Location:{$location}");
	 exit;
	}
}


function logout(){
     session_start();
	 $_SESSION=array();
	 if(isset($_COOKIE[session_name()])){
	     setcookie(session_name(),'',time()-4200,'/');
	 }
	 session_destroy();
	 redirect_to('login.php');
}

?>