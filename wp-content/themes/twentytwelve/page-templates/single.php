<?php
/**
 * Template Name: Single
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
<nav id="site-navigation" class="main-navigation" role="navigation">
			<h3 class="menu-toggle"><?php _e( 'Menu', 'twentytwelve' ); ?></h3>
			<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentytwelve' ); ?>"><?php _e( 'Skip to content', 'twentytwelve' ); ?></a>
			<div class="menu-user-container" ><?php  wp_nav_menu( array('menu' => 'user'  )) ; ?>
			 <li><a href="<?php echo get_logout_url(); ?>" >logout</a></li></div>

		</nav><!-- #site-navigation -->
<?php
//Get Album ID
if(isset($_GET['v']))
{
$album_id=$_GET['v'];
//Fetching photos from Album
$result2 = mysql_query("SELECT * FROM photos where album_id=$album_id");
    while($row2 = mysql_fetch_array($result2))
   {
?> <div id="imagelist">
    <p><img src="<?php echo get_template_directory_uri()."/".$row2['location'];?>"></p>

	<a href="<?php echo get_template_directory_uri();?>/plugins/phpimageeditor/index.php?imagesrc=../../<?php echo $row2['location']; ?>&lightbox[iframe]=true&amp;lightbox[width]=1270&amp;lightbox[height]=860" class="lightbox">Edit</a>
	<?php echo '</div>';
   }
}
?>
