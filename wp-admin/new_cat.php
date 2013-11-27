<?php
ob_start();
require_once( dirname( __FILE__ ) . '/admin.php' );
$title = __('Manage Category');
require_once( ABSPATH . 'wp-admin/admin-header.php' );
?>
<h1>
<?php
echo esc_html( $title );
?>
</h1>
<br />
<!-- Add new category -->
<div id="post-body-content">
<h2>Add New Category</h2>
	<div class="postbox">
		<form name="category" method="post" action="">
			<div class="custom">Category Name<input type="text" name="category" value="" required /></div>
				<div class="custom"><input type="submit" name="cat" value="Add" /></div>
		</form>
	</div>
</div>
<!-- Add new category End here -->


<?php
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
<br />

<div id="post-body-content">
		<h2>Category List </h2>
		<div class="postbox">
		 <table style="text-align:center;" width="80%"><tr><th width="5%">S. No.</th><th width="10%">Category</th width="10%"><th width="10%">Option</th></tr>
<?php 					$count=0;
						
						$result = $wpdb->get_results( "SELECT * FROM main_services" );
						foreach($result as $myrow)
						{
						$count++;
						$service = $myrow->name;
						$service_id = $myrow->id;
?>
						<tr class="record"><td><?php echo $count; ?>.</td><td><?php echo $service;?></td><td><a href="?id=<?php echo $service_id; ?>">Edit</a>&nbsp;/&nbsp;<a href="#" id="<?php echo $service_id; ?>" class="delbutton">Delete</a></td></tr>
<?php
						}
 ?>			</table>			
		</div>
</div>
<?php 
if(isset($_GET['id']))
{
$cat_id=$_GET['id'];
$result = $wpdb->get_row( "SELECT * FROM main_services where id=$cat_id" );
						
						$cat = $result->name;
?>
<div id="post">
<h2>Edit Category</h2>
	<div class="postbox">
		<form name="edit-category" method="post" action="new_cat.php">
			<div class="custom">Category Name<input type="text" name="edit-category" value="<?php echo $cat; ?>" required /></div>
												<input type="hidden" name="cat_id" value="<?php echo $cat_id;  ?>" >
				<div class="custom"><input type="submit" name="cat" value="save" /></div>
		</form>
	</div>
</div>
<!-- Add new category End here -->


<?php
}
//Update category values to database
if(isset($_POST['cat']))
{
  $cat=$_POST['edit-category'];
  $cat_id=$_POST['cat_id'];
 
$result= $wpdb->query("UPDATE main_services SET name = '$cat' WHERE ID = $cat_id");
if($result)
{
header('Location:new_cat.php');
exit;
}


}