<?php
require_once( dirname( __FILE__ ) . '/admin.php' );
if($_POST['id'])
{
$id=$_POST['id'];

$sql = "delete from child_services where id='$id'";
mysql_query( $sql);
}
else if($_POST['id1'])
{
$id1=$_POST['id1'];

$sql1 = "delete from services where id='$id1'";
mysql_query( $sql1);
}
?>