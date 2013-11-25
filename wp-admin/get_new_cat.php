<?php
/**
 * Media Library administration panel.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** WordPress Administration Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );

$q = $_GET['q'];
						echo"<table>";
						$result = $wpdb->get_results( "SELECT * FROM child_services where parent_service=$q" );
						foreach($result as $myrow)
						{
						$service = $myrow->name;
						$service_id = $myrow->id;
?>
						<tr class="record"><td><?php echo $service; ?></td><td><a href="#" id="<?php echo $service_id; ?>" class="record delbutton">Delete</a></td></tr>
<?php 					} ?>
						</table>
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