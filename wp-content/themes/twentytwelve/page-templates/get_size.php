<?php

require('../../../../wp-blog-header.php');


  $q=$_GET['q'];


 ?>

Select Size<select name="size" onchange="showmaterial(this.value)">
<option value="">select</option>
<?php $result = $wpdb->get_results( "SELECT * FROM services where child_service_id =$q" );
	foreach($result as $myrow)
	{
	 $service = $myrow->size;
	 $service_id = $myrow->id;
?>
<br />	Select Service<option value="<?php echo $service_id;?> "><?php echo $service;?></option>

<?php
	}
 ?>

<div>

</select>

