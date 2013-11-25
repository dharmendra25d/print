<?php
/**
 * Media Library administration panel.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** WordPress Administration Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );


$title = __('Services');

require_once( ABSPATH . 'wp-admin/admin-header.php' );
?>
<h2>
<?php
echo esc_html( $title );
if ( current_user_can( 'upload_files' ) ) { ?>
	<a href="services.php" class="add-new-h2"><?php echo esc_html_x('Add New', 'file'); ?></a><?php
}
?>
</h2>
<form name="service" method="post" action="">
<div id="post-body-content">
<h2>Add Size</h2>
	<div class="postbox">
Select category<select name="main_service" onchange="showUser(this.value)">
				<option value="">select</option>
<?php 			$result = $wpdb->get_results( "SELECT * FROM main_services" );
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
			<div id="txtHint">
Select sub-category<select>
				<option value="">select</option>
			</select>
			</div>
				<div>
					Add Size:<input type="text" name="size" value="" />(ex: 3x4)
						<div>
							<input type="submit" name="service" value="Add" />
						</div>
				</div>
	</div>
</div>

<script>
// ajax script for main service
function showUser(str)
{
if (str=="")
  {
  document.getElementById("txtHint").innerHTML="";
  return;
  } 
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
    document.getElementById("txtHint").innerHTML=xmlhttp.responseText;
    }
  }
xmlhttp.open("GET","getuser.php?q="+str,true);
xmlhttp.send();
}
</script>
</form>

<form name="material" method="post" action="">
	<div id="post-body-content">
		<h2>Add Material</h2>
		<div class="postbox">
		Select Service<select name="main_service" >
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
 ?>						</select>
		Add Material:<input type="text" name="material" value="" />
						<div>
							<input type="submit" name="material_service" value="Add" />
						</div>
		</div>
	</div>
</form>

<?php
//inserting size values to database
if(isset($_POST['service']))
{
 $main=$_POST['main_service'];
 $child=$_POST['child_service'];
 $size=$_POST['size'];
 $wpdb->insert( 
	'services', 
	array( 
		'id' =>'', 
		'service_id' => $main,
		'child_service_id' => $child,
		'size' => $size
	), 
	array( 
		'%d',
		'%d',
		'%d',
		'%s',
		'%s'
	) 
);
}
//inserting material values to database
if(isset($_POST['material_service']))
{
 $main=$_POST['main_service'];
 $material=$_POST['material'];
$wpdb->insert( 
	'material', 
	array( 
		'id' =>'', 
		'service_id' => $main,
		'material' => $material
	), 
	array( 
		'%d',
		'%d',
		'%s'
	) 
);
}
?>
<div id="post-body-content">
		<h2>View Category <a href="new_cat.php"> Add New</a></h2>
		<div class="postbox">
		 
<?php 					$count=0;
						echo"<br /><table><tr><th>S. No.</th><th>Name</th><th>Delete</th>";
						$result = $wpdb->get_results( "SELECT * FROM main_services" );
						foreach($result as $myrow)
						{
						$count++;
						$service = $myrow->name;
						$service_id = $myrow->id;
?>
						<tr class="record"><td><?php echo $count; ?>.</td><td><?php echo $service;?></td><td><a href="#" id="<?php echo $service_id; ?>" class="delbutton">Delete</a></td></tr>
<?php
						}
 ?>			</table>			
		</div>
</div>

<div id="post-body-content">
		<h2>View Sizes</h2>
		<div class="postbox">
<?php 					$result = $wpdb->get_results( "SELECT * FROM services" );
						foreach($result as $myrow)
						{
						$service = $myrow->size;
						$service_id = $myrow->id;
?>
						<div><?php echo $service;?></div>
<?php
						}
 ?>						
		</div>
</div>
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
url: "delete.php",
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
<?php	

include( ABSPATH . 'wp-admin/admin-footer.php' );
?>
