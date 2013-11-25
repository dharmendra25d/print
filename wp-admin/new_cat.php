<?php
ob_start();
require_once( dirname( __FILE__ ) . '/admin.php' );
$title = __('Add New Category');

require_once( ABSPATH . 'wp-admin/admin-header.php' );
?>
<h2>
<?php
echo esc_html( $title );
?>
</h2>
<!-- Add new category -->
<form name="category" method="post" action="">
 Category Name<input type="text" name="category" value="" required />
               <input type="submit" name="cat" value="Add" />
</form>
<!-- Add new category End here -->

<!-- Add new sub category -->
<form name="sub-category" method="post" action="">
<div>
 <h2>
 Add New Sub Category
 </h2>
	<div class="postbox">
		Select category<select name="main_service"  required>
						<option value="">select</option>
<?php 					$result = $wpdb->get_results( "SELECT * FROM main_services" );
						foreach($result as $myrow)
						{
						$service = $myrow->name;
						$service_id = $myrow->id;
?>
						<option value="<?php echo $service_id;?> "><?php echo $service;?></option>
<?php
						}
 ?>
						</select>
		Sub Category Name<input type="text" name="subcategory" value="" required />
							<input type="submit" name="subcat" value="Add" />
	</div>						
</form>
<!-- Add new sub category End here -->
<!-- View Subcategory -->
<form name="sub-category" method="post" action="">
<div>
 <h2>
 View Sub Category
 </h2>
	<div class="postbox">
		Select category<select name="main"  required>
						<option value="">select</option>
<?php 					$result = $wpdb->get_results( "SELECT * FROM main_services" );
						foreach($result as $myrow)
						{
						$service = $myrow->name;
						$service_id = $myrow->id;
?>
						<option value="<?php echo $service_id;?> "><?php echo $service;?></option>
<?php
						}
 ?>
						</select>

							<input type="submit" name="view" value="submit" />

</form>
<!-- View Subcategory -->
<?php
if(isset($_POST['view']))
{
 $cat=$_POST['main'];   $count=0;
						echo"<br /><table><tr><th>S. No.</th><th>Name</th><th>Delete</th>";
						$result = $wpdb->get_results( "SELECT * FROM child_services where parent_service=$cat" );
						foreach($result as $myrow)
						{
						$count++;
						$service = $myrow->name;
						$service_id = $myrow->id;
?>
						<tr class="record"><td><?php echo $count; ?>.</td><td><?php echo $service; ?></td><td><a href="#" id="<?php echo $service_id; ?>" class="delbutton">Delete</a></td></tr>
<?php 					} 
						echo"</table>";
}

//inserting category values to database
if(isset($_POST['category']))
{
 $cat=$_POST['category'];
 $wpdb->insert( 
	'main_services', 
	array( 
		'id' =>'', 
		'name' => $cat
		
	), 
	array( 
		'%d',
		'%s'
	) 
);
header('Location:new_cat.php');
exit;

}

//inserting category values to database
if(isset($_POST['subcat']))
{
 $main=$_POST['main_service'];
 $subcat=$_POST['subcategory'];
 $wpdb->insert( 
	'child_services', 
	array( 
		'id' =>'', 
		'name' => $subcat,
		'parent_service' => $main
	), 
	array( 
		'%d',
		'%s',
		'%d'

	) 
);
header('Location:new_cat.php');
exit;
}

?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<script type="text/javascript" >
$(function() {
$(".delbutton").click(function(){
var del_id = $(this).attr("id");

var info = 'id=' + del_id;
if(confirm("Sure you want to delete this update? There is NO undo!"))
{
$.ajax({
type: "POST",
url: "delete1.php",
data: info,
success: function(){
}
});
$(this).parents(".record").animate({ backgroundColor: "#fbc7c7" }, "fast")
.animate({ opacity: "hide" }, "slow");
}
return false;
});
});
</script>
