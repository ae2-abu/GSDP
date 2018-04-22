<?php 

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
function get_url_title($raw_postTitle,$pageId){
     $raw_postTitle_pageId=array($raw_postTitle,$pageId);
     $raw_url_title=implode($raw_postTitle_pageId,' ');
     $pattern=array('/[^a-zA-Z0-9-]/','/-/');
	 $replace=array('-','-');
	 $not_pure=preg_replace($pattern,$replace,$raw_url_title);
	 $pure=preg_replace('/-+/','-',$not_pure);
	return $pure;
}
?>