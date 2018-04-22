<?php
    //- is the php inbuilt function that activates session (keeping track of users status across  different pages) in the script. Note: This particular line 2, must be placed in ALL the pages that wants to keep track of users authentication/login status. And also Note that for it to work , it must come before any output is made. So that’s why its at line 2 of the page.
  session_start(); 
  ///each is an external script included in the index.php for modularity and reusability. The reason those scripts are separated from index.php is because they will be needed in some other pages and to avoid repeating the same code in those pages which not only consume space , but will also make the work tedious as any future changes simply means we have to go through all thise pages and modify them individually . both require_once() and include_once() are php inbuilt functions for including external files to a file(index.php).

  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////
  ///////////////////////////////////////////////////////////////////////////////////////////////////////////////

  //includes the connection.php that enables PHP to connect and communicate to the database. To connect to a database , you have to provide four(4) basic details : the Host(localhost), the user(root), the password(blank), the database(charity) you want to connect to.
    require_once("settings/connect.php");

    //the configuration file which we use to resolve file paths
  require_once("/admin/settings/config.php");

  //includes the function.php file which contains all the user defined php functions used in the app(site) like the formatted date functions,.
  require_once("settings/functions.php");

  // include_once ("auth/session_others.php");

  //includes the user_info.php  file which is a script that gets the logged in user’s infos from the database and makes it readily available so we can use it anytime we wish. 
  include_once ("settings/user_info.php");
  
  $bizID = 1; // this should be comming from a request



// The following script below is the one responsible for querying the database to get the theme(colors) set by the admin. The following statement 
// SELECT id, biz_id, prime_color, second_color, color_3, color_4, color_5, color_6, color_7, color_8 from templates where biz_id = ‘1’ and is_default = '1'
// in line 30 is known as SQL. It is the language of the database ( MySQL,Oracle,etc). The language is very straight forward and pretty much like English language :) . it simply says : Goto the mysql program , goto the charity database (we have already set this in the connection.php you remember?), from there, goto the  template table(schema) and SELECT all the rows with column “biz_id” = 1 and column  “is_default” = 1 and I only want the following columns “id, biz_id, prime_color, second_color, color_3, color_4, color_5, color_6, color_7, color_8”  


    $theme = $con->prepare("SELECT id,biz_id,prime_color,second_color,color_3,color_4,color_5,color_6,color_7,color_8 from templates where biz_id = ? and is_default = '1' ") or die($con->error);
   
   // its a way of binding data to the SQL statement we are sending to the database. It replaces the question mark(?)  in the previous line 32 above
    $theme->bind_param('i',$bizID) or die($con->error);
    $theme->execute();

    //This is a way of storing the returned result (rows) into a variables so we can access it. Notice that the order of the variables is the same as the corresponding columns in the query statement
    $theme->bind_result($themeID,$bizID,$primeColor,$secondColor,$color3,$color4,$color5,$color6,$color7,$color8);
   
   // we first store the result so you can make use of the "$theme->num_rows" below.
    $theme->store_result() ;

    if($theme->num_rows > 0){
      // this as the name implies, fetches the result from the query above and activates the bind_result() above so the any of the variables($themeID,$bizID,$primeColor,$secondColor,$color3,$color4,$color5,$color6,$color7,$color8) can be accessed 
      $theme->fetch() ;
    }

?>
<!DOCTYPE html>
<html>
<head>
  <title>QCF - Charity</title>
  <?php 
       // This section of index.php is used to import external style sheets(CSS) into the file. This section handles the aesthetics(beauty) of the site
   ?>
  <!-- ///////////////////////////////  ionicons   ///////////////////////////////////// -->
  <link rel="stylesheet" type="text/css" href="style/ionicons/css/ionicons.min.css">
  <!-- ///////////////////////////////  bootstrap   ///////////////////////////////////// -->
  <link rel="stylesheet" type="text/css" href="style/bootstrap/css/bootstrap.min.css">
  <!-- ///////////////////////////////  google font   ///////////////////////////////////// -->
  <link rel="stylesheet" type="text/css" href="style/google-fonts/google-fonts.css">
  <!-- ///////////////////////////////  owl carousel   ///////////////////////////////////// -->
  <link rel="stylesheet" type="text/css" href="script/js/plugins/owl-carousel/owl.carousel.css">
  <link rel="stylesheet" type="text/css" href="script/js/plugins/owl-carousel/owl.theme.css">
  <!-- ///////////////////////////////  general css   ///////////////////////////////////// -->
  <link rel="stylesheet" type="text/css" href="style/general.css">

  <!-- ///////////////////////////////  This page only (css)   ///////////////////////////////////// -->
  <?php include "style/style.php"; ?>

  
</head>
<body>

<?php 
          //This includes the heading section (Logo, Navigation, Login form)  
        include_once "section_bottom/header.php"    
    ?>
    <h1 style="font-family: Verdana; color:navy;">Events Page</h1>

<div class="main">

<p>View Upcoming Events</p>

<!-- Portfolio Gallery Grid -->
<div class="row">
  <?php 
                  $companyID = 1; //this can be in a cookie

                  // The Statement below gets all the uploaded news by the admin from the "news" table in the "charity" database.
                $news = $con->prepare("SELECT a.id,a.title,a.body,a.main_image,a.date_created,b.username from news a left join user_auth b on a.author = b.user_id where a.biz_id = ? order by a.date_created desc") or die($con->error);
                  $news->bind_param('i',$companyID) or die($con->error);
                  $news->execute();
                  $news->bind_result($newsID,$newsTitle,$newsBody,$newsImage,$newsDate,$author);
                  $news->store_result() ;
                  if($news->num_rows > 0){
                         while($news->fetch()){
                       
              ?>

             
              <div class="column">
                  <div class="content">
                    <img src="<?php echo POST_IMG_DIR.$newsImage ?>" class="news-img" alt="<?php echo $newsTitle ?>" style="width:100%">
                    <h3><?php echo $newsTitle ?></h3>
                    <p><?php echo strip_tags(html_entity_decode($newsBody)) ?></p>
                  </div>
              </div>

              <?php } }else{ echo '<div class="default-message"> No Event posted Yet</div>'; } ?>

</div>


<!-- END MAIN -->
</body>
<style>
    * {
    box-sizing: border-box;
}

body {
    background-color: #f1f1f1;
    font-family: Arial;
}

/* Center website */
.main {
    max-width: 90%;
    margin: auto;
}

h1 {
    font-size: 80px;
    word-break: break-all;


}

.row {
    margin: 8px -16px;
}

/* Add padding BETWEEN each column (if you want) */
.row,
.row > .column {
    padding: 8px;
}

/* Create four equal columns that floats next to each other */
.column {
    float: left;
    width: 25%;
}

/* Clear floats after rows */ 
.row:after {
    content: "";
    display: table;
    clear: both;
}

/* Content */
.content {
    background-color: white;
    padding: 10px;
    border: 10px  solid yellow;
    border-radius: 20px;
}

/* Responsive layout - makes a two column-layout instead of four columns */
@media screen and (max-width: 900px) {
    .column {
        width: 50%;
    }
}

/* Responsive layout - makes the two columns stack on top of each other instead of next to each other */
@media screen and (max-width: 600px) {
    .column {
        width: 100%;
    }
}

    </style>



    <?php 
           // the two lines below are for the popups. The first one is the donation box that popups up when a user clicks on the donate button. While the second line is the status box that notifies the user of the status of an action. like "Donation successful !. Thank You"
       include_once "popups/modals/donate.php"; 
       include_once "popups/notifiers/general.php"; 
      //////////////////////////////////////////////////////////////////////////////////////////////////////////////
      /////////////////////   General(in all pages) external scripts and activators    /////////////////////////////
      //////////////////////////////////////////////////////////////////////////////////////////////////////////////
       // the line below is the javascript that controls this page. This is also where plugins like Owl-Carousel are initialized.
       include_once "section_bottom/general.php"; 





    ?>
</html> 