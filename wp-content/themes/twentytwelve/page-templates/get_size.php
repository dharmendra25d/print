<?php
//wordpress required file for custom php pages
require('../../../../wp-blog-header.php');
$q=$_GET['q']; //get ajax value
 ?>
Select Size	<select name="size" onchange="showmaterial(this.value)">
			<option value="">select</option>
<?php 		$result = $wpdb->get_results( "SELECT * FROM services where child_service_id =$q" );//fetch all records relating to the category
			foreach($result as $myrow)
			{
			 $service = $myrow->size;
			 $service_id = $myrow->id;
?>
			<option value="<?php echo $service_id;?> "><?php echo $service;?></option>
<?php
			}		
 ?>			</select>

