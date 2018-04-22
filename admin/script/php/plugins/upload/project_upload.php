<?php
        session_start(); 
        // date_default_timezone_set('Africa/Lagos');
    require_once("../../../../settings/config.php");
    require_once(FULLROOT."settings/connect.php");
    
    require_once(FULLROOT."settings/functions.php");
    require_once(FULLROOT."settings/user_info.php");


//error_reporting(E_ALL);

// we first include the upload class, as we will need it here to deal with the uploaded file
include('class.upload.php');


        // $postType = mysql_prep($_GET['type']);
        $title = mysql_prep($_POST['title']);
        $cat = mysql_prep($_POST['category']);
        $body = mysql_prep($_POST['desc']);


     

     ////////////////////////////////////////////////////////////////////////////////////////////////
     ///////////////////////     IMAGE PROCESSING ZONE - START    ///////////////////////////////////
     ////////////////////////////////////////////////////////////////////////////////////////////////

                    // set variables
        $dir_dest = (isset($_GET['dir']) ? $_GET['dir'] : POST_IMG_DIR_FULL);
        $dir_pics = (isset($_GET['pics']) ? $_GET['pics'] : $dir_dest);



            // ---------- SIMPLE UPLOAD ----------

            // we create an instance of the class, giving as argument the PHP object
            // corresponding to the file field from the form
            // All the uploads are accessible from the PHP object $_FILES
            $handle = new Upload($_FILES['file']);

            // then we check if the file has been uploaded properly
            // in its *`".$tt."`* location in the server (often, it is /tmp)
            if ($handle->uploaded) {
                $handle->image_resize            = true;
                $handle->image_ratio_y           = true;
                $handle->image_x                 = 700;
                // $handle->image_reflection_height = '40px';
                // $handle->image_reflection_space = 0;
                // M = matching , U = user, T = time
                $handle->file_new_name_body = "PRJ".uniqid()."U".$_SESSION['user_id']."T".time(); 

                // yes, the file is on the server
                // now, we start the upload 'process'. That is, to copy the uploaded file
                // from its `".$tt."` location to the wanted location
                // It could be something like $handle->Process('/home/www/my_uploads/');
                $handle->Process($dir_dest);

                // we check if everything went OK if yes, we then put the record in the database
                if ($handle->processed) {
                    
                   

                 $stmt=$con->prepare("INSERT into projects(title,body,main_image,theme_id,biz_id,author) values(?,?,?,?,?,?)") or die($con->error);
                 $stmt->bind_param("ssssss",$title,$body,$handle->file_dst_name,$cat,$_SESSION['company_id'],$_SESSION['user_id']) or die($con->error); 
                 $stmt->execute() or die($con->error);
                 $last_insert=$stmt->insert_id;
                 $time=time();
                     if( $stmt->affected_rows>0){ 
                             $arrRes = array('success' =>1 ,'item_id'=>$last_insert,'post_time'=>$time );
                             echo json_encode($arrRes);
                      }
                    $stmt->close();
                   
                } else {
                    // one error occured
                    //File not uploaded to the wanted location
                    $arrRes = array('success' =>3 ,'err'=>$handle->error );
                             echo json_encode($arrRes);
                }

                // we delete the `".$tt."` files
                $handle-> Clean();

            } else {
                // if we're here, the upload file failed for some reasons
                // i.e. the server didn't receive the file
                $arrRes = array('success' =>2 ,'err'=>$handle->error );
                          echo json_encode($arrRes);
            }

     ////////////////////////////////////////////////////////////////////////////////////////////////
     ///////////////////////     IMAGE PROCESSING ZONE - END    ///////////////////////////////////
     ////////////////////////////////////////////////////////////////////////////////////////////////


?>
