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
    $theme->close() ;

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
    <main style="padding:0px 50px;">
      <?php
           // this is the PHP script that processes the donation submitted form and displays a status message depending on the status. NOTE: that the form submits to the same page.
           // validation: we first check if the value submited to this page is empty or not. This is called validation
          
           if( (isset($_POST['submit']) && !empty($_POST['submit']))){ //if a form is submitted

             if( (isset($_POST['resource_type']) && !empty($_POST['resource_type'])) && (isset($_POST['amount']) && !empty($_POST['amount'])) &&
                  (isset($_POST['project']) && !empty($_POST['project']))
                  
              ){
                 $amount= mysql_prep($_POST['amount']); //this mysql_prep() is that user defined function that sanitizes user input against Injections like SQL injection.
                 $project= mysql_prep($_POST['project']);
                 $donationType= mysql_prep($_POST['resource_type']);
                 // $email= mysql_prep($_POST['email']);
                 
                 
                 
                 
                 
                 // ////////////////////////////////////    insert the donations now   ///////////////////////////////////////////////

                  //The statement below is SQL used to INSERT data into the database.
                   $donate=$con->prepare("INSERT into donations(user_id,amount,project_id,donation_type) values(?,?,?,?)") or die($con->error);       
                   $donate->bind_param("ssss",$_SESSION['user_id'],$amount,$project,$donationType);
                   $donate->execute() or die($con->error);

                   if($donate->insert_id > 0 ){ //every new record added to the database generates a new ID automatically(AUTO-INCREMENT) , so to check wether a record is inserted,we check the last insert id of the new inserted record if its greated than 0. 
                        
                    echo '<div  class="status-success">Donation successful !!!</div>';
                       
                   }else{

                    echo '<div  class="status-danger">Donation failed !!!</div>';
                    
                    
                    
                   }
                      $donate->close();
                   
                  
                
              }else{
                        echo '<div  class="status-danger"> All fields are required !!!</div>';
                     // echo "all requifred fields must be filled approprately";
              }
          }
      ?>

      

        <h1 style="font-family: Verdana; color:navy;">Donation Page</h1>
    
        <div style="width:400px;">
            <form action="" method="post">
              <label>Please select the theme you want to donate to?</label>
              <select name="project" class="form-control">
                <?php
                     $proj=$con->prepare("SELECT id,title from events where biz_id = '1' ") or die($con->error);       
                     $proj->execute() or die($con->error);
                     $proj->bind_result($projectIDD,$projectTitle) or die($con->error);
                     $proj->store_result() or die($con->error);

                     if($proj->num_rows > 0 ){
                        
                        while($proj->fetch()){

                             //the if statment below is responsible for selecting correctly the default option. when one click on the donate button for any project, one may change ones mind to donate for another project instead, by making another selection from the SELECT dropdown element. Its now the function of the if statment below to auto select the current clicked project as the selected once the modal pops up.
                             
                                printf('<option value="%s">%s</option>',$projectIDD,$projectTitle);
                             
                            
                        }
                      }
           
                ?>
              </select>

              <label>Please what resource would you like to donate?</label>
              <select name="resource_type" id="resource" class="form-control">
                <option value="money">Money</option>
                <option value="time">Time</option>
              </select>


              <div id="money-fields">
                  <div style="margin-top:10px;">
                    <input style="margin-right: 50px;" id="m1" type="radio" name="amount" value="10">
                    <label for="m1" style="background:#ccc;padding:4px;border-radius: 2px;">$10</label>
                  </div>
                  <div style="margin-top:10px;">
                    <input style="margin-right: 50px;" id="m2" type="radio" name="amount" value="20">
                    <label for="m2" style="background:#ccc;padding:4px;border-radius: 2px;">$20</label>
                  </div>
                  <div style="margin-top:10px;">
                    <input style="margin-right: 50px;" id="m3" type="radio" name="amount" value="50">
                    <label for="m3" style="background:#ccc;padding:4px;border-radius: 2px;">$50</label>
                  </div>
                  <div style="margin-top:10px;">
                    <input style="margin-right: 50px;" id="m4" type="radio" name="amount" value="100">
                    <label for="m4" style="background:#ccc;padding:4px;border-radius: 2px;">$100</label>
                  </div>
                  <div style="margin-top:10px;">
                    <input style="margin-right: 50px;" id="m5" type="radio" name="amount" value="200">
                    <label for="m5" style="background:#ccc;padding:4px;border-radius: 2px;">$200</label>
                  </div>
              </div>
              <div id="time-fields" style="display: none;">
                  <div style="margin-top:10px;">
                    <input style="margin-right: 50px;" id="t1" type="radio" name="amount" value="1">
                    <label for="t1" style="background:#ccc;padding:4px;border-radius: 2px;">1 Hour</label>
                  </div>
                  <div style="margin-top:10px;">
                    <input style="margin-right: 50px;" id="t2" type="radio" name="amount" value="2">
                    <label for="t2" style="background:#ccc;padding:4px;border-radius: 2px;">2 Hours</label>
                  </div>
                  <div style="margin-top:10px;">
                    <input style="margin-right: 50px;" id="t3" type="radio" name="amount" value="5">
                    <label for="t3" style="background:#ccc;padding:4px;border-radius: 2px;">5 Hours</label>
                  </div>
                  <div style="margin-top:10px;">
                    <input style="margin-right: 50px;" id="t4" type="radio" name="amount" value="10">
                    <label for="t4" style="background:#ccc;padding:4px;border-radius: 2px;">10 Hours</label>
                  </div>
                  <div style="margin-top:10px;">
                    <input style="margin-right: 50px;" id="t5" type="radio" name="amount" value="15">
                    <label for="t5" style="background:#ccc;padding:4px;border-radius: 2px;">15 Hours</label>
                  </div>
              </div>
              <input class="form-control" type="submit" name="submit" value="submit">
            </form>
        </div>
        

       
    </main>
    

<style>
input[type=button], input[type=submit], input[type=reset] {
    background-color: #ffa500;
  
    color: white;
    
   
}
.status-success{
  padding:5px;
  background:#00E68D;
  margin-top:20px;
  width:400px;
  text-align: center;
}
.status-danger{
  padding:5px;
  background:#FF736A;
  margin-top:20px;
  width:400px;
  text-align: center;
}


  </style>





<?php 
           // the two lines below are for the popups. The first one is the donation box that popups up when a user clicks on the donate button. While the second line is the status box that notifies the user of the status of an action. like "Donation successful !. Thank You"
       // include_once "popups/modals/donate.php"; 
       include_once "popups/notifiers/general.php"; 
      //////////////////////////////////////////////////////////////////////////////////////////////////////////////
      /////////////////////   General(in all pages) external scripts and activators    /////////////////////////////
      //////////////////////////////////////////////////////////////////////////////////////////////////////////////
       // the line below is the javascript that controls this page. This is also where plugins like Owl-Carousel are initialized.
       include_once "section_bottom/general.php"; 

       



    ?>
    <script type="text/javascript">
      $('select#resource').on('click',function(e){
        e.preventDefault();
        if(e.currentTarget.selectedIndex==0){ //money
                $('#time-fields').fadeOut(100,function(){$('#money-fields').fadeIn(100)});
        }else{    //Time
                $('#money-fields').fadeOut(100,function(){$('#time-fields').fadeIn(100)});
        }

      })
    </script>
</body>
</html> 