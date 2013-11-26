<?php
/**
 * Template Name: Add Photos
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
//Insert photos to Database
session_start();
echo $_SESSION['user_name'];
echo $wp_user_data->user_login;
if(isset($_FILES['files'])){
    $album_id=$_POST['album_id'];
    $errors= array();
	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
		$file_name = $key.$_FILES['files']['name'][$key];
		$file_size =$_FILES['files']['size'][$key];
		$file_tmp =$_FILES['files']['tmp_name'][$key];
		$file_type=$_FILES['files']['type'][$key];	
		$location="photos/" . $_FILES["files"]["name"][$key];

        if($file_size > 2097152){
			$errors[]='File size must be less than 2 MB';
        }		
        $query="INSERT INTO photos (location,album_id) VALUES('$location','$album_id'); ";
        $desired_dir="/home/content/61/11647461/html/dev/print_project/wp-content/themes/twentytwelve/photos";
        if(empty($errors)==true){
            if(is_dir($desired_dir)==false){
                mkdir("$desired_dir/", 0705);		// Create directory if it does not exist
            }
            if(is_dir("$desired_dir/".$file_name)==false){
                move_uploaded_file($file_tmp,"$desired_dir/".$_FILES["files"]["name"][$key]);
            }else{									// rename the file if another one exist
                $new_dir="$desired_dir/".$file_name.time();
                 rename($file_tmp,$new_dir) ;				
            }
		 mysql_query($query);			
        }else{
                print_r($errors);
        }
    }
	if(empty($error)){
		echo "Success";
	}
}
	get_header(); 
?>
<nav id="site-navigation" class="main-navigation" role="navigation">
			<h3 class="menu-toggle"><?php _e( 'Menu', 'twentytwelve' ); ?></h3>
			<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentytwelve' ); ?>"><?php _e( 'Skip to content', 'twentytwelve' ); ?></a>
			<div class="menu-user-container" ><?php  wp_nav_menu( array('menu' => 'user'  )) ; ?>
			 <li><a href="<?php echo get_logout_url(); ?>" >logout</a></li></div>

		</nav>
<form action="" method="POST" enctype="multipart/form-data">
    Select Album: <br />
<select name="album_id" required>
<option value="" >Select One</option>
<?php
//Fetching Album Info  
$result = mysql_query("SELECT * FROM album where user_id=$_SESSION[user]");
while($row = mysql_fetch_array($result))
{
?>
   <option value="<?php echo $row['id'];?>"><?php echo $row['name'];?></option>
<?php 
}
?>
</select>
 <br />
Select Image: <br />

	<input type="file" name="files[]" class="ed" multiple/>
	<input type="submit"  value="Upload" id="button1" />
</form>
<?php
//Add photo to Album
$result = mysql_query("SELECT * FROM album where user_id=$_SESSION[user]");
while($row1 = mysql_fetch_array($result))
 {
 $result1 = mysql_query("SELECT * FROM photos where album_id=$row1[id] LIMIT 1");
   while($row = mysql_fetch_array($result1))
    {
?>
     <a href="#" onclick="document.f1.v.value='<?php echo $row1['id']?>'; document.f1.submit();"><div id="imagelist">
    
    <p><img src="<?php echo get_template_directory_uri()."/".$row['location'];?>"></p>
	<?php
     echo '<p id="caption">'.$row1['name'].' </p>';
     echo '</div></a>';
    }
 }
?>
<form name=f1 id="f1" action="single" method=GET >
<input name=v type=hidden value=undefined>
</form>
