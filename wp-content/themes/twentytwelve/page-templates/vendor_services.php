<?php
/**
 * Template Name: Vendor Services
*/
get_header();
?>
 <form name="service" method="post" action="">
	<div class="">
	Select Service<select name="main_service" onchange="showUser(this.value)">
					<option value="">select</option>
<?php   			$result = $wpdb->get_results( "SELECT * FROM main_services" );
					foreach($result as $myrow)
					{
					 $service = $myrow->name;
					 $service_id = $myrow->id;
?>
					<option value="<?php echo $service_id; ?> "><?php echo $service;?></option>
<?php
					 }
 ?>
					</select>
	</div>
	<div id="txtHint">
	Select Category<select name="cat">
					<option value="">select</option>
					</select>
	</div>
	<div id="txtHint1">
	Select Size<select name="size"><option value="">select</option>
				</select>
	</div>
	<div id="txtHint2">
	Select Material<select name="material"><option value="">select</option>
				</select>
	</div>
	<div>
	Add Price:<input type="text" name="price" value="" />$
			<div>
			<input type="submit" name="service" value="Add" />
			</div>
	</div>
	
<!-- Ajax script for sending main service value -->	
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
<!-- Ajax script for sending selected category value -->	

<script>
	function showsize(str)
	{
	if (str=="")
	  {
	  document.getElementById("txtHint1").innerHTML="";
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
		document.getElementById("txtHint1").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","<?php echo get_template_directory_uri(); ?>/page-templates/get_size.php?q="+str,true);
	xmlhttp.send();
	}																
</script>

<!-- Ajax script for sending selected size value -->	

<script>
		function showmaterial(str)
	{
	if (str=="")
	  {
	  document.getElementById("txtHint2").innerHTML="";
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
		document.getElementById("txtHint2").innerHTML=xmlhttp.responseText;
		}
	  }
	xmlhttp.open("GET","<?php echo get_template_directory_uri(); ?>/page-templates/get_material.php?q="+str,true);
	xmlhttp.send();
	}																		
</script>

<?php
		// Inserting all form values to database
		if(isset($_POST['service']))
		{
			 echo $main=$_POST['main_service'];
			 echo $child=$_POST['cat'];
			 echo $size=$_POST['size'];
			 echo $material=$_POST['material'];
			 echo $price=$_POST['price'];


		$wpdb->insert(   			//Inserting values to vendor service table
			'vendor_services', 
			array( 
				'id' =>'', 
				'service_id' => $main,
				'child_service_id' => $child,
				'size' => $size,
				'price' => $price,
				'material' => $material,
				'vendor_id' => $_SESSION[user]
				
			), 
			array( 
				'%d',
				'%d',
				'%d',
				'%d',
				'%s',
				'%s'
				
			) 
		);
		}
 ?>