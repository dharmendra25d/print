<?php

require('../../../../wp-blog-header.php');


  $q=$_GET['q'];


 ?>

<select name="child_service" onchange="showsize(this.value)">
<option value="">select</option>
<?php $result = $wpdb->get_results( "SELECT * FROM services where child_service_id =$q" );
	foreach($result as $myrow)
	{
	 $service = $myrow->name;
	 $service_id = $myrow->id;
?>
<br />	Select Service<option value="<?php echo $service_id;?> "><?php echo $service;?></option>

<?php
	}
 ?>

<div>

</select>
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
xmlhttp.open("GET","<?php echo get_template_directory_uri(); ?>/page-templates/getuser.php?q="+str,true);
xmlhttp.send();
}
</script>