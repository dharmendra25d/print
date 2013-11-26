<?php
/**
 * Template Name: Add Album
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
get_header(); 
?>
<script type="text/javascript">
      $('#btnsave').live("click" , function()
	  {
	  $('.lightbox').hide();
	  }); 
  </script>
<nav id="site-navigation" class="main-navigation" role="navigation">
			<h3 class="menu-toggle"><?php _e( 'Menu', 'twentytwelve' ); ?></h3>
			<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentytwelve' ); ?>"><?php _e( 'Skip to content', 'twentytwelve' ); ?></a>
			<div class="menu-user-container" ><?php  wp_nav_menu( array('menu' => 'user'  )) ; ?>
			 <li><a href="<?php echo get_logout_url(); ?>" >logout</a></li></div>

		</nav><!-- #site-navigation -->
<?php
//Adding Album info to Database
if (isset($_POST['Submit'])) {
 $name=$_POST['album'];
 $save=mysql_query("INSERT INTO album (name, user_id) VALUES ('$name','$_SESSION[user]')");
 echo"Successfully Added";
 echo"<br />";
 ?>
<?php
 }
 
?>
<!--Creating New Album-->
 <form action="" method="post" enctype="multipart/form-data" name="addroom">
 New Album: <br />
   <input type="text" name="album" class="ed">
   <br />
   <input type="submit" name="Submit" value="Add" id="button1" />
 </form>
 <!-- End Album -->
</body>
</html>