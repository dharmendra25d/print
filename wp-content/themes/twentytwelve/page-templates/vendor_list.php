<?php
/**
 * Template Name: Vendor List
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
$_SESSION['username'];
get_header(); 
?>

<h1>Welcome Guest</h1>
<center><h2>Choose Vendor</h2></center>
<?php
				echo"<table><tr><th>Vendor</th></tr>";
				$result = $wpdb->get_results( "SELECT * FROM wp_wp_eMember_members_tbl where membership_level=3" );
				foreach($result as $myrow)
				{
					$first_name = $myrow->first_name;
					$member_id = $myrow->member_id;
?>  			 	<a href="#" onclick="document.f1.v.value='<?php echo $row1['id']?>'; document.f1.submit();">
					<p></p>
<?php			
					echo '<tr><td><p id="caption">'.$first_name.' </p></td></tr>';
					echo '</div></a>';
					echo"<table><tr><th>size</th><th>Price</th></tr>";
					$result = $wpdb->get_results( "SELECT * FROM vendor_services where vendor_id = $member_id" );
					foreach($result as $myrow)
					{
						$size = $myrow->size;
						$price = $myrow->price;
						$result = $wpdb->get_results( "SELECT * FROM services where id = $size" );
						foreach($result as $myrow)
						{
							$size = $myrow->size;
							echo '<tr><td><p id="caption">'.$size.' </td></p>';
							echo '<td><p id="caption">'.$price.' </p></td></tr>';
						}
						echo "</table>";
					}
					
				}
?>
<form name=f1 id="f1" action="sub-main" method=GET >
<input name=v type=hidden value=undefined>
</form>
<?php
get_footer(); 
?>
