<?php
//wordpress required file for custom php pages
require('../../../../wp-blog-header.php');
$q=$_GET['q'];
 ?>
Select Material<select name="material" >
				<option value="">select</option>
<?php 			$result = $wpdb->get_results( "SELECT * FROM services where id =$q" );
				foreach($result as $myrow)
				{
				 $service = $myrow->material;
				 $service_id = $myrow->id;
?>
				<option value="<?php echo $service_id;?> "><?php echo $service;?></option>
<?php
				 }
 ?>
				</select>

