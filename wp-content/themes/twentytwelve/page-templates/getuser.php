<?php
//wordpress required file for custom php pages
require('../../../../wp-blog-header.php');
$q=$_GET['q'];
 ?>
Select Category<select name="cat" onchange="showsize(this.value)">
				<option value="">select</option>
<?php 			$result = $wpdb->get_results( "SELECT * FROM child_services where parent_service=$q" );
				foreach($result as $myrow)
				{
				 $service = $myrow->name;
				 $service_id = $myrow->id;
?>
				Select Service<option value="<?php echo $service_id;?> "><?php echo $service;?></option>
<?php
				 }
 ?>
				</select>
