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
$title = __('Manage Sub-categories');

require_once( ABSPATH . 'wp-admin/admin-header.php' );
?>
<h1>
<?php
echo esc_html( $title );
?>
</h1>
<!-- Add new sub category -->
<br />
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
		<div>Sub Category Name<input type="text" name="subcategory" value="" required /></div>
							<div><input type="submit" name="subcat" value="Add" /></div>
	</div>						
</form>
<!-- Add new sub category End here -->

<!-- View Subcategory -->
<form name="sub-category" method="post" action="">
<div>
 <h2>
 Sub Category List
 </h2>
	<div class="postbox">
	
	<!--	Select category<select name="main"  >
						<option value="">select</option> -->
<?php 	/**				$result = $wpdb->get_results( "SELECT * FROM main_services" );
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
						echo"<br /><table style=\"text-align:center;\" width=\"80%\"><tr><th  width=\"20%\">S. No.</th><th  width=\"20%\">Category</th ><th  width=\"20%\">Subcategory</th ><th width=\"20%\">Option</th>";
						$result = $wpdb->get_results( "SELECT * FROM child_services where parent_service=$cat" );
						foreach($result as $myrow)
						{
						$count++;
						$service = $myrow->name;
						$service_id = $myrow->id;
								$result = $wpdb->get_results( "SELECT * FROM main_services where id=$myrow->parent_service" );
								foreach($result as $myrow)
								{
								$cat = $myrow->name;
								$cat_id = $myrow->id;
?>
						<tr class="record"><td><?php echo $count; ?>.</td><td><?php echo $cat; ?></td><td><?php echo $service; ?></td><td><a href="?id=<?php echo $service_id;?>&id1=<?php echo $cat_id; ?>" >Edit</a>&nbsp; /&nbsp; <a href="#" id="<?php echo $service_id; ?>" class="delbutton">Delete</a></td></tr>
<?php 							}
						} 
						echo"</table>";
}
else
{ **/
					 $count=0;
						echo"<br /><table style=\"text-align:center;\" width=\"80%\"><tr><th  width=\"20%\">S. No.</th><th  width=\"20%\">Category</th ><th  width=\"20%\">Subcategory</th ><th width=\"20%\">Option</th>";
						$result = $wpdb->get_results( "SELECT * FROM child_services ");
						foreach($result as $myrow)
						{
						$count++;
						$service = $myrow->name;
						$service_id = $myrow->id;
								$result = $wpdb->get_results( "SELECT * FROM main_services where id=$myrow->parent_service" );
								foreach($result as $myrow)
								{
								$cat = $myrow->name;
								$cat_id = $myrow->id;
?>
						<tr class="record"><td><?php echo $count; ?>.</td><td><?php echo $cat; ?></td><td><?php echo $service; ?></td><td><a href="?id=<?php echo $service_id;?>&id1=<?php echo $cat_id; ?>" >Edit</a>&nbsp; /&nbsp; <a href="#" id="<?php echo $service_id; ?>" class="delbutton">Delete</a></td></tr>
<?php 							}
						} 
						echo"</table>";

echo	"</div>";

//Edit Subcategory 
if(isset($_GET['id']))
{
	$subcat_id=$_GET['id'];
	$cat_id=$_GET['id1'];
	$result = $wpdb->get_row( "SELECT * FROM child_services where id=$subcat_id" );
						$subcat = $result->name;
?>
<form name="edit-subcategory" method="post" action="">
<div>
 <h2>
 Edit Sub Category
 </h2>
	<div class="postbox">
		Select category<select name="main_service"  required>
						<option value="">select</option>
<?php 					$result = $wpdb->get_results( "SELECT * FROM main_services" );
						foreach($result as $myrow)
						{
						$service = $myrow->name;
						$service_id = $myrow->id;
						if ($service_id == $cat_id)
						$selected = "selected=\"selected\"";
						else
						$selected = "";
?>							
						<option value="<?php echo $service_id;?> " <?php echo $selected; ?>><?php echo $service;?></option>
<?php
						}
 ?>
						</select>
		<div>Sub Category Name<input type="text" name="subcate" value="<?php echo $subcat; ?>" required /></div>
							<input type="hidden" name="subcat_id" value="<?php echo $subcat_id;  ?>" >
							<div><input type="submit" name="edit" value="Save" /></div>
	</div>						
</form>
<?php
}
//Update Sub category values to database
if(isset($_POST['edit']))
{
  $subcat=$_POST['subcate'];
   $subcat_id=$_POST['subcat_id']; 
$result= $wpdb->query("UPDATE child_services SET name = '$subcat' WHERE ID = $subcat_id");
if($result)
{
header('Location:services.php');
exit;
}
}
?>
<br />
<!-- Manage Size Start here -->
<h1>Manage Size</h1>

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

?>

<!--View All Size Values -->
<div id="post-body-content">
		<h2>All Size</h2>
		<div class="postbox">
					<table style="text-align:center;" width="80%"><tr><th width="5%">S. No.</th><th width="10%">Category</th width="10%"><th>Sub Category</th><th width="10%">Size</th><th width="10%">Option</th></tr>	
<?php 					$count=0;
						$result = $wpdb->get_results( "SELECT * FROM services" );
						foreach($result as $myrow)
						{
						$count++;
						$size = $myrow->size;
						$size_id= $myrow->id;
						$child_service_id  = $myrow->child_service_id ;
						$service_id  = $myrow->service_id; 
							$result = $wpdb->get_results( "SELECT * FROM child_services where id=$child_service_id" );
							foreach($result as $myrow)
							{
							$subcat = $myrow->name;
							$subcat_id = $myrow->id;
								$result = $wpdb->get_results( "SELECT * FROM main_services where id=$service_id" );
								foreach($result as $myrow)
								{
								$cat = $myrow->name;
								$cat_id = $myrow->id;
?>
						<tr class="record"><td><?php echo $count; ?>.</td><td><?php echo $cat; ?></td><td><?php echo $subcat; ?></td><td><?php echo $size; ?></td><td><a href="?cat=<?php echo $cat_id;?>&cat1=<?php echo $subcat_id; ?>&cat2=<?php echo $size_id; ?>" >Edit</a>&nbsp; /&nbsp; <a href="#" id="<?php echo $size_id; ?>" class="delbutton_size">Delete</a></td></tr>
<?php
								}
							}
?>
<?php
						}
 ?>					</table>		
		</div>
</div>
<?php
//Edit Size
if(isset($_GET['cat']))
{
	$cat_id=$_GET['cat'];
	$subcat_id=$_GET['cat1'];
	$size_id=$_GET['cat2'];
	$result = $wpdb->get_row( "SELECT * FROM services where id=$size_id" );
						$size = $result->size;
?>
<form name="edit-subcategory" method="post" action="">
<div>
 <h2>
 Edit Size
 </h2>
	<div class="postbox">
		Select category<select name="main_service"  required>
						<option value="">select</option>
<?php 					$result = $wpdb->get_results( "SELECT * FROM main_services" );
						foreach($result as $myrow)
						{
						$service = $myrow->name;
						$service_id = $myrow->id;
						if ($service_id == $cat_id)
						$selected = "selected=\"selected\"";
						else
						$selected = "";
?>							
						<option value="<?php echo $service_id;?> " <?php echo $selected; ?>><?php echo $service;?></option>
<?php
						}
 ?>
						</select>
						<div>Select subcategory<select name="subcate"  required>
						<option value="">select</option>
<?php 					$result = $wpdb->get_results( "SELECT * FROM child_services" );
						foreach($result as $myrow)
						{
						$service = $myrow->name;
						$service_id = $myrow->id;
						if ($service_id == $subcat_id)
						$selected = "selected=\"selected\"";
						else
						$selected = "";
?>							
						<option value="<?php echo $service_id;?> " <?php echo $selected; ?>><?php echo $service;?></option>
<?php
						}
 ?>
						</select></div>
		<div>size<input type="text" name="e_size" value="<?php echo $size; ?>" required /></div>
							<input type="hidden" name="esize_id" value="<?php echo $size_id;  ?>" >
							<div><input type="submit" name="edit_size" value="Save" /></div>
	</div>						
</form>
<?php
}
//Update Size values to database
if(isset($_POST['edit_size']))
{
   $e_size=$_POST['e_size'];
   $esize_id=$_POST['esize_id']; 
$result= $wpdb->query("UPDATE services SET size = '$e_size' WHERE ID = $esize_id");
if($result)
{
header('Location:services.php');
exit;
}
}
?>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
<!-- Delete jquery for Subcategory -->
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

<!-- Delete jquery for Size -->
<script type="text/javascript" >
$(function() {

$(".delbutton_size").click(function(){
var del_id = $(this).attr("id");

var info = 'id1=' + del_id;
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

//inserting subcategory values to database
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
header('Location:services.php');
exit;
}


include( ABSPATH . 'wp-admin/admin-footer.php' );
?>
