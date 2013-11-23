<?php
/**
 * Template Name: vendor
 *
 * Description: A page template that provides a key component of WordPress as a CMS
 * by meeting the need for a carefully crafted introductory page. The front page template
 * in Twenty Twelve consists of a page content area for adding text, images, video --
 * anything you'd like -- followed by front-page-only widgets in one or two columns.
 *
 * @package WordPress
 * @subpackage Twenty_Twelve
 * @since Twenty Twelve 1.0
 */
get_header(); 
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
get_footer();
?> 


