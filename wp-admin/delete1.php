<?php
require_once( dirname( __FILE__ ) . '/admin.php' );
if($_POST['id'])
{
$id=$_POST['id'];

$sql = "delete from child_services where id='$id'";
mysql_query( $sql);
}
?>