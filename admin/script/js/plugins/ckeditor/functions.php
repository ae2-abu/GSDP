<?php 
// this file contains all the user defined functions used in this website
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

function get_sel_page($category,$pageId){
  //this query is use to fetch the correct row(page)	
   $query1=mysql_query("select*from allnews where category='$category' and pageId='$pageId'") or die(mysql_error());
   $get_page=mysql_fetch_array($query1)or die("nothin found");//if statement should be here to redirect prospects if there made mistake in the url i.e if page not found
   return $get_page;

}

function get_latest_news(){
     //the purpose of this query is for latest news
     $lat_news=mysql_query("select * from(select *, match(postTitle) against((select Education from keywords where id=1) in boolean mode) as relevant from allnews) as virtual where date between date_sub(now(), interval 23 day) and now() order by date desc limit 4;") or die(mysql_error());
     return $lat_news;
}

function get_related_news($get_postTitle){
     //the purpose of this query is for related news
     $rel_news=mysql_query("select *, match(postTitle) against( '{$get_postTitle}' in boolean mode) as relevant from allnews where date between date_sub(now(), interval 45 day) and now() order by relevant desc limit 3;") or die(mysql_error());
     return $rel_news;
}

function get_other_widget_content(){
     // this query is for other widgets beside "recent and related widget"
     $other_wid=mysql_query("select pageId,postTitle,category,date,postImage from allnews order by date desc");  
	 return $other_wid;
}

//this is my implode function
/*function comma_sep_optional_fields($optional_set_fields){
	for($i=0;$i<$num=count($optional_set_fields);$i++){
	 if($i==$num-1){
		 echo ",".$optional_set_fields[$num-1];
	 }else{
		",".echo $optional_set_fields[$i];
	 } 
	 }
			 
}*/

function comma_sep_optional_dollar($optional_set_fields){
  foreach($optional_set_fields as $global){       //this loop defines x no of global variables. where x is the values in the $optional_set_fields.
    global ${$global};       //this variable variable(using the value of a variable to make a variable)
  }
  $dis=array();
	for($i=0;$i<$num=count($optional_set_fields);$i++){
	  if($i==$num-1){
		 $dis[]= "'${$optional_set_fields[$num-1]}'";
	  }else{
		$dis[]= "'${$optional_set_fields[$i]}',";
	  } 
	}	 
	return $dis;		 
}

function search_result_pagination($user_query,$per_page,$user_input){
        global $total_page;              //made global by this function
		global $page_id;                 //made global by this function
		
   //NOTE:change $per_page argument to the number of pages per page of ur choice you want to display.
	$row_count=mysql_num_rows($user_query);
	if($row_count==0){
	   echo "No result found try changing the words used";
	}else{
		if($row_count<=$per_page){    //if true, then no need for pagination i.e "pagination.php"
		// print the "per_page" number of items into the first page only.
		   while($recent=mysql_fetch_array($user_query)){
				echo "<div id=\"result_cont\">";
				echo  "<h2><a href=\"/news/{$recent['category']}/{$recent['pageId']}\">{$recent['postTitle']}</a></h2>";
				echo  "<div>".html_entity_decode($recent['postContent'])."</div>";
				echo  "<span>/news/{$recent['category']}/{$recent['pageId']}</span>";
				echo "</div>";
			}
		}else{                     //start pagination
	    //paged: is the other set of paginators selectors(numbered) beside the first page paginator selector
		//page: is the first page paginator selector
		//NOTICE: the difference in the address bar when NEXT button is clicked from the first result page
		if(isset($_GET['page'])){
		     $page_id=mysql_real_escape_string($_GET['page']);
		}elseif(isset($_GET['paged'])){
		     $page_id=mysql_real_escape_string($_GET['paged']);
		}
		$paginate=$row_count/$per_page;
		$ans=explode(".",$paginate);
				if(isset($ans[1])){
					$total_page=ceil($paginate);    //round up to the nearest whole number
				}else{
					$total_page=$ans[0];
				}
		   //if the input page number by the user is greater than the maximum page number, dont display anythin
				if($page_id>$total_page){
				   die("page not found");
				}
				
				//make the page navigation:TOP
			function page_navigator($row_count){
				 global $total_page;          //from search_result_pagination() function
			     global $page_id;             //from search_result_pagination() function
			     global $user_input;         //from global			
			     $no_per_page=5;
			$next_value=((($page_id*2)% $no_per_page)==2)?$page_id:'';
			$stat_of_last=$total_page - ($no_per_page - 1);	
			
if($page_id==$next_value){
$dd=$next_value+($no_per_page);
}else{$dd="";}			
		$end=$next_value+($no_per_page - 1);		
			    echo "<span class=\"page_navigator\">";
				         if((($row_count<=$no_per_page) and ($page_id==1)) || ($page_id>=$stat_of_last && $page_id<=$total_page)){   //NO NEXT HERE                             //condition for if no next button
						     if($page_id==1){       //
							      echo "<span id=\"prev\" style=\"display:none;\">prenxvious</span>";
							 }else{ echo "<span id=\"prev\">preggvious</span>";}    


 	                        if(($row_count<=$no_per_page) and ($page_id==1)) {
                             //no pagination
						    }elseif($page_id>=$stat_of_last && $page_id<=$total_page){
							    for($c=$stat_of_last;$c<=$total_page;$c++){
								 if($c==$page_id){                                             //checking currently selected button
									 echo  "<span class=\"page_nav_curr\">".$c."</span>";
								 }else{echo  "<a href=\"search_result.php?search=".$user_input."&page=".$c."\">".$c."</a>";}
							 }
							}
						 
						 
						 
						 }else{    //NEXT HERE				         

							 if($page_id>=1 && $page_id<=$no_per_page){       //if the no from database is <= no per page || if the user is  in the first page, check need for previous button
									  echo "<span id=\"prev\" style=\"display:none;\">prenxvious</span>";
								 }else{ echo "<span id=\"prev\">preggvious</span>";}
                                  
								  if($page_id>=1 && $page_id<=$no_per_page){
								   for($c=1;$c<=$no_per_page;$c++){
										 if($c==$page_id){
											 echo  "<span class=\"page_nav_curr\">".$c."</span>";
										 }else{echo  "<a href=\"search_result.php?search=".$user_input."&page=".$c."\">".$c."</a>";}
									 }
									 $d=$c;
									 echo  "<a href=\"search_result.php?search=".$user_input."&page=".$d."\">"."NeiDxt"."</a>";
								  }else{
								  
									   for($c=$next_value;$c<=$end;$c++){
											 if($c==$page_id){
												 echo  "<span class=\"page_nav_curr\">".$c."</span>";
											 }else{echo  "<a href=\"search_result.php?search=".$user_input."&page=".$c."\">".$c."</a>";}
										 }
										 echo  "<a href=\"search_result.php?search=".$user_input."&page=".$dd."\">"."NeDxt"."</a>";

									  
								  }
								 }
				echo "</span><br/>";
			}
				
				
				
				page_navigator($row_count); 
				}
				}
		//this "for" statement, dynamically generate ($total_page)th number of if statements 
		for($i=0;$i<=$total_page;$i++){
		   $no=$i+1;
			 if($no==$page_id){      //if the user input page number is = to the current loop,then thats what we are looking for so we process further.
					 if($page_id==1){  //first page doesnt require any mysql_data_seek, so this if statement handles it.
					   for($re=0;$recent=mysql_fetch_array($user_query) and $re<$per_page;$re++){
						echo "<div id=\"result_cont\">";
						echo  "<h2><a href=\"/news/{$recent['category']}/{$recent['pageId']}\">{$recent['postTitle']}</a></h2>";
						echo  "<div>".strip_tags(html_entity_decode($recent['postContent']))."</div>";
						echo  "<span>/news/{$recent['category']}/{$recent['pageId']}</span>";
						echo "</div>";
					}}else{
						   $point=$per_page*($page_id-1); //Good calculation. Checks for the exact place to set the $mysql_fetch_array inner pointer.
						   mysql_data_seek($user_query,$point);
							for($re=0;$recent=mysql_fetch_array($user_query) and $re<$per_page;$re++){
								echo "<div id=\"result_cont\">";
								echo  "<h2><a href=\"/news/{$recent['category']}/{$recent['pageId']}\">{$recent['postTitle']}</a></h2>";
								echo  "<div>".strip_tags(html_entity_decode($recent['postContent']))."</div>";
								echo  "<span>/news/{$recent['category']}/{$recent['pageId']}</span>";
								echo "</div>";				
					}
				 }	 
			 }
		}
		//make the page navigation:DOWN
				echo "<span class=\"page_navigator\">";
				for($c=0;$c<$total_page;$c++){
				  $num=$c+1;                                                   //generate the navigation numbers
					if($num==$page_id){                                           //this is our current page
						echo  "<span class=\"page_nav_curr\">".$num."</span>";
					}else{
						echo  "<a href=\"search_result.php?search=".$user_input."&page=".$num."\">".$num."</a>";
					}
				}
				echo "</span><br/>";
		}

function array_pagination($get_all_title,$per_page){
	   //NOTE:change $per_page argument to the number of pages per page of ur choice you want to display.
		$row_count=mysql_num_rows($get_all_title);
		if($row_count==0){
		   echo "No result found try changing the words used";
		}else{
			if($row_count<=$per_page){    //if true, then no need for pagination i.e "pagination.php"
			// print the "per_page" number of items into the first page only.
			   for($re=0;$all_title_value=mysql_fetch_array($get_all_title);$re++){
					echo "<div id=\"result_cont\">";
					echo  "<h2><a href=\"cp_edit.php?category={$all_title_value['category']}&pageId={$all_title_value['pageId']}\">{$all_title_value['postTitle']}</a></h2>";
					echo "</div>";
				}
		    }else{
			
			$page_id=mysql_real_escape_string($_GET['page']);
			$paginate=$row_count/$per_page;
			$ans=explode(".",$paginate);
			global $total_page;
					if(isset($ans[1])){
						$total_page=ceil($paginate);    //round up to the nearest whole number
					}else{
						$total_page=$ans[0];
					}
			   //if the input page number by the user is greater than the maximum page number, dont display anythin
					if($page_id>$total_page){
					   die("page not found");
					}
					
					//make the page navigation:TOP
				function page_navigator(){
				   global $total_page;          //from another function
				   global $page_id;             //from another function
				   global $user_input;         //from global
					echo "<span class=\"page_navigator\">";
					for($c=0;$c<$total_page;$c++){
					  $num=$c+1;                                                   //generate the navigation numbers
						if($num==$page_id){                                           //this is our current page
							echo  "<span class=\"page_nav_curr\">".$num."</span>";
						}else{
						   $vert_navbar=mysql_query("SELECT * FROM cms_vertnav_menu");
						   $result=mysql_fetch_array($vert_navbar);
							echo  "<a href=\"cp_edit.php?page=".$num."&menu_no={$result['id']}\">".$num."</a>";
						}
					}
					echo "</span><br/>";
					}
					page_navigator();   
					
			//this "for" statement, dynamically generate ($total_page)th number of if statements 
			for($i=0;$i<=$total_page;$i++){
			   $no=$i+1;
				 if($no==$page_id){      //if the user input page number is = to the current loop,then thats what we are looking for so we process further.
						 if($page_id==1){  //first page doesnt require any mysql_data_seek, so this if statement handles it.
						  echo "<ul id=\"result_cont\">";
						  $vert_navbar=mysql_query("SELECT * FROM cms_vertnav_menu");
						  $result=mysql_fetch_array($vert_navbar);
						  for($re=0;$recent=mysql_fetch_array($get_all_title) and $re<$per_page;$re++){
							echo  "<h2><li><a href=\"cp_edit.php?category={$recent['category']}&pageId={$recent['pageId']}&menu_no={$result['id']}\">{$recent['postTitle']}</a></li></h2>";	
						  }
						  echo "</ul>";
						}else{
						       $vert_navbar=mysql_query("SELECT * FROM cms_vertnav_menu");
						       $result=mysql_fetch_array($vert_navbar);
							   $point=$per_page*($page_id-1); //Good calculation. Checks for the exact place to set the $mysql_fetch_array inner pointer.
							   mysql_data_seek($get_all_title,$point);
							   echo "<ul id=\"result_cont\">";
								for($re=0;$recent=mysql_fetch_array($get_all_title) and $re<$per_page;$re++){									
									echo  "<h2><li><a href=\"cp_edit.php?category={$recent['category']}&pageId={$recent['pageId']}&menu_no={$result['id']}\">{$recent['postTitle']}</a></li></h2>";											
						}
							   echo "</ul>";	
					 }	 
				 }
			}
			//make the page navigation:DOWN
					echo "<span class=\"page_navigator\">";
					for($c=0;$c<$total_page;$c++){
					  $num=$c+1;                                                   //generate the navigation numbers
						if($num==$page_id){                                           //this is our current page
							echo  "<span class=\"page_nav_curr\">".$num."</span>";
						}else{
						   $vert_navbar=mysql_query("SELECT * FROM cms_vertnav_menu");
						   $result=mysql_fetch_array($vert_navbar);
							echo  "<a href=\"cp_edit.php?page=".$num."&menu_no={$result['id']}\">".$num."</a>";
						}
					}
					echo "</span><br/>";
						
			}
		}
}
function category_exist($cat){
     $get_nav=mysql_query("select*from category");
	 $categ=array();
	 while($navbar_gotten=mysql_fetch_array($get_nav)){
		 if(strtoupper($cat)==strtoupper($navbar_gotten['category'])){
			$categ[]=$cat;
		 } 
	 }
	 if(empty($categ)){
		 redirect_to("error.php?qn=".urlencode($cat));
	 }	  
}
function logout(){
     session_start();
	 $_SESSION=array();
	 if(isset($_COOKIE[session_name()])){
	     setcookie(session_name(),'',time()-4200,'/');
	 }
	 session_destroy();
	 redirect_to('http://localhost/news/cpanel/login.php?qn=logout');
}
?>