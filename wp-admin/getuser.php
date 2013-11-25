<?php
/**
 * Media Library administration panel.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** WordPress Administration Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );
 $q=$_GET['q'];
?>
Select sub-category<select name="child_service">
						<option value="">select</option>
<?php 						$result = $wpdb->get_results( "SELECT * FROM child_services where parent_service=$q" );
							foreach($result as $myrow)
							{
							$service = $myrow->name;
							$service_id = $myrow->id;
?>
Select Service			<option value="<?php echo $service_id;?> "><?php echo $service;?></option>
<?php
							}
 ?>
					</select>
