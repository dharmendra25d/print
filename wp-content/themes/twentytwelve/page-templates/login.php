<?php
/**
 * Template Name: Login
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
	get_header(); 

 if(isset($_SESSION['username']))
{
?>
<nav id="site-navigation" class="main-navigation" role="navigation">
			<h3 class="menu-toggle"><?php _e( 'Menu', 'twentytwelve' ); ?></h3>
			<a class="assistive-text" href="#content" title="<?php esc_attr_e( 'Skip to content', 'twentytwelve' ); ?>"><?php _e( 'Skip to content', 'twentytwelve' ); ?></a>
			<div class="menu-user-container" ><?php  wp_nav_menu( array('menu' => 'user'  )) ; ?>
			 <li><a href="<?php echo get_logout_url(); ?>" >logout</a></li></div>

		</nav><!-- #site-navigation -->
<?php
}

?>

<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', 'page' ); ?>
			<?php endwhile; // end of the loop. ?>
<?php
get_footer(); 
?>
