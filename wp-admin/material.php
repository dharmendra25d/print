<?php
ob_start();
/**
 * Media Library administration panel.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** WordPress Administration Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );
$title = __('Manage Material');

require_once( ABSPATH . 'wp-admin/admin-header.php' );
?>
<h1>
<?php
echo esc_html( $title );
?>
</h1>
<!--Add New Material start here -->
<form name="service" method="post" action="">
<div id="post-body-content">
<h2>Add Material</h2>
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
					Add Material:<input type="text" name="mat" value="" />
						<div>
							<input type="submit" name="material" value="Add" />
						</div>
				</div>
	</div>
</div>
<!--Add New Material End here -->
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


<?php
//inserting material values to database
if(isset($_POST['material']))
{
 $main=$_POST['main_service'];
 $child=$_POST['child_service'];
 $material=$_POST['mat'];
 $wpdb->insert( 
	'material', 
	array( 
		'id' =>'', 
		'service_id' => $main,
		'child_service_id' => $child,
		'material' => $material
	), 
	array( 
		'%d',
		'%d',
		'%d',
		'%s'
	) 
);
header('Location:material.php');
exit;
}

?>


<div id="post-body-content">
		<h2>Material List</h2>
		<div class="postbox">
					<table style="text-align:center;" width="80%"><tr><th width="5%">S. No.</th><th width="10%">Category</th width="10%"><th>Sub Category</th><th width="10%">Material</th><th width="10%">Option</th></tr>	
<?php 					$count=0;
						$result = $wpdb->get_results( "SELECT * FROM material" );
						foreach($result as $myrow)
						{
						$count++;
						$material = $myrow->material;
						$child_service_id  = $myrow->child_service_id ;
						$service_id  = $myrow->service_id; 
							$result = $wpdb->get_results( "SELECT * FROM child_services where id=$child_service_id" );
							foreach($result as $myrow)
							{
							$subcat = $myrow->name;
								$result = $wpdb->get_results( "SELECT * FROM main_services where id=$service_id" );
								foreach($result as $myrow)
								{
								$cat = $myrow->name;
								echo "<tr><td>$count</td><td>$cat</td><td>$subcat</td><td>$material</td><td><a href =\"\">Edit</a> / <a href =\"\">Delete</a></td></tr>";	

								}
							}
?>
<?php
						}
 ?>					</table>		
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
