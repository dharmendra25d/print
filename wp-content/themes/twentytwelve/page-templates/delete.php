<?php
include("wp-config.php");
if($_POST['id'])
{
$id=$_POST['id'];

$sql = "delete from user_detail where id='$id'";
mysql_query( $sql);
}
?>