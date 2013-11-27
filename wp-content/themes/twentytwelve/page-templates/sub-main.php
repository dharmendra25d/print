<?php
/**
 * Template Name: Sub-Main
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
//Insert photos to Database
session_start();
echo $_SESSION['username'];
	get_header(); 
 $id=$_GET['v'];
?>

<h1>Welcome Guest</h1>
<center><h2>Choose a serivce</h2></center>
<?php
//Add photo to Album
$result = mysql_query("SELECT * FROM child_services where parent_service=$id");
while($row1 = mysql_fetch_array($result))
 {
?>
     <a href="#" onclick="document.f1.v.value='<?php echo $row1['id']?>'; document.f1.submit();">
    <p></p>
	<?php
     echo '<p id="caption">'.$row1['name'].' </p>';
     echo '</div></a>';
    }
 
?>
<form name=f1 id="f1" action="member-login" method=GET >
<input name=v type=hidden value=undefined>
</form>
<?php
get_footer(); 
?>
