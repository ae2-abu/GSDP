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
    <h1 style="font-family: Verdana; color:navy;">FAQ</h1>
    

<button onclick="myFunction()" class="accordion"> 1 What is QCF?</button>
<div  class="panel">
  <p>Our main focus at Quartet Community Foundation is to change people’s lives for the better across the West of England,
     giving as many people as possible the chance to fulfil their potential. We do this by working closely with a wide 
     variety of donors to harness their passion for helping others and match it to vital projects that meet community aspirations
      and make a profound difference to people’s lives.

For more information vist our Page : http://quartetcf.org.uk/about-us/</p>
</div>

<button class="accordion">2 How can i Donate?</button>
<div  class="panel">
  <p>You can donate money or your time for the local charities that our company is supporting via the Donation Page.</p>
</div>

<button class="accordion">3 What is an Event?</button>
<div  class="panel">
  <p>An Event is a fundraiser organised by one your colleagues in order to raise money for our chosen cause. You can create and join
    an event on the Events page.
  </p>

<script>
var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        /* Toggle between adding and removing the "active" class,
        to highlight the button that controls the panel */
        this.classList.toggle("active");

        /* Toggle between hiding and showing the active panel */
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
            panel.style.display = "none";
        } else {
            panel.style.display = "block";
        }
    });
}
</script>
</div>

<style>
    
 /* Style the buttons that are used to open and close the accordion panel */
.accordion {
    background-color: #eee;
    color: #444;
    cursor: pointer;
    padding: 18px;
    width: 100%;
    text-align: left;
    border: none;
    outline: none;
    transition: 0.4s;
}

/* Add a background color to the button if it is clicked on (add the .active class with JS), and when you move the mouse over it (hover) */
.active, .accordion:hover {
    background-color: #ccc;
}

/* Style the accordion panel. Note: hidden by default */
.panel {
    padding: 0 18px;
    background-color: white;
    display: none;
    overflow: hidden;
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
</body>
</html> 