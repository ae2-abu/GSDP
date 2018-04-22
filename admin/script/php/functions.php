<?php 
// this file contains all the user defined functions used in this website
function getWall($userWall){
	$f=trim($userWall);
	 if(empty($f)){
	 	echo '<span style="font-size:10px;color:#ccc;font-weight:bold;line-height:1.2em;">';
	  	echo '	Hey they am on this group...';
	    echo '</span>';
	 }else{
	 	echo '<span style="font-size:10px;color:#fff;font-weight:bold;line-height:1.2em;">';
	 		echo $userWall;
	 	echo '</span>';
	 }
}
function getUserPix($gender,$userId,$surname,$image){
	global $sysPix;
	global $users_dir;
	global $img_dir;
	 $file=$img_dir."/".$surname."_".$userId."/signature/profile_pix.jpg";
								     		  
	if(!file_exists( $file)){
		if(strtoupper($gender) == 'M'){
			echo '<img src="'.$sysPix.'/default_img_m.jpg" class="trigger-user-info-ajax celeb-thumbs" data-user-id="'.$userId.'" data-user-cat="3"/>'; 
		}elseif(strtoupper($gender) == 'F'){
			echo '<img src="'.$sysPix.'/default_img_f.jpg" class="trigger-user-info-ajax celeb-thumbs" data-user-id="'.$userId.'" data-user-cat="3"/>'; 
		}  
	}else{
	  printf('<img src="%s/%s_%s/signature/profile_pix.jpg" class="trigger-user-info-ajax celeb-thumbs" data-user-id="%s" data-user-cat="3"/>',$users_dir,$surname,$userId,$userId); 
	 
	}
									
												
}
function getUserProfilePix($gender,$userId,$surname,$image){
	global $sysPix;
	global $users_dir;
	global $img_dir;
	 $file=$img_dir."/".$surname."_".$userId."/signature/profile_pix.jpg";
								     		  
	if(!file_exists( $file)){
		if(strtoupper($gender) == 'M'){
			echo '<img src="'.$sysPix.'/default_img_m.jpg" style="width:100%;height:190px;border-radius:50%;border:5px solid #fff;"/>'; 
		}elseif(strtoupper($gender) == 'F'){
			echo '<img src="'.$sysPix.'/default_img_f.jpg" style="width:100%;height:190px;border-radius:50%;border:5px solid #fff;"/>'; 
		}  
	}else{
	  printf('<img src="%s/%s_%s/signature/profile_pix.jpg" class="profile_pix"/>',$users_dir,$surname,$userId); 
	}
									
												
}
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
function get_file_icon($fileName){
	  $fileNameExt=explode('.', $fileName);
	  $iconDir="images/icons";
	  if(isset($fileNameExt[1])){
	  switch($fileNameExt[1]){
	  	case "pdf":
		  	return $iconDir.'/pdf_2.png';
		  	break;
		case "doc":
		  	return $iconDir.'/docx_win.ico';
		  	break;
		case "docx":
		  	return $iconDir.'/docx_win.ico';
		  	break;
		case "mp3":
		  	return $iconDir.'/audio.png';
		  	break;
		case "jpeg":
		  	return $iconDir.'/gallery.png';
		  	break;
		case "jpg":
		  	return $iconDir.'/gallery.png';
		  	break;
		case "png":
		  	return $iconDir.'/gallery.png';
		  	break;
		case "mp4":
		  	return $iconDir.'/video.png';
		  	break;
		case "flv":
		  	return $iconDir.'/video.png';
		  	break;
		case "zip":
		  	return $iconDir.'/archive.png';
		  	break;
		default:
		  	return $iconDir.'/default.png';
		  	break;
	  }
	}else{
			return $iconDir.'/default.png';
	}
}
function get_curr_url(){
    $pageUrl="0";
  if($_SERVER['SERVER_PORT']!=80){
     $pageUrl=$_SERVER['SERVER_NAME'].":".$_SERVER['SERVER_PORT'].$_SERVER['REQUEST_URL'];
  }else{
     $pageUrl=$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
  }

  return $pageUrl;
}
function get_categories(){
     $get_navbar=mysql_query("select*from category");
	 return $get_navbar;
}
function upper_case($input){
     $output=ucfirst($input);
	 echo $output;
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