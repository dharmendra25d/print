<?php
/**
 * Media Library administration panel.
 *
 * @package WordPress
 * @subpackage Administration
 */

/** WordPress Administration Bootstrap */
require_once( dirname( __FILE__ ) . '/admin.php' );

if ( !current_user_can('upload_files') )
	wp_die( __( 'You do not have permission to upload files.' ) );



$title = __('Services');

require_once( ABSPATH . 'wp-admin/admin-header.php' );
?>

<div class="wrap">
<?php screen_icon(); ?>
<h2>
<?php
echo esc_html( $title );
if ( current_user_can( 'upload_files' ) ) { ?>
	<a href="media-new.php" class="add-new-h2"><?php echo esc_html_x('Add New', 'file'); ?></a><?php
}
?>
<select onchange="showUser(this.value)">

<option value="">select</option>
<?php $result = $wpdb->get_results( "SELECT * FROM main_services" );
	foreach($result as $myrow)
	{
	 $service = $myrow->name;
	 $service_id = $myrow->id;
?>
<br />	Select Service
					<option value="<?php echo $service_id;?> "><?php echo $service;?></option>

<?php
	}
 ?>

<div>

</select></div> 
<div id="txtHint"><select><option value="">select</option></select></div>

<script>
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
<?php
include( ABSPATH . 'wp-admin/admin-footer.php' );
?>