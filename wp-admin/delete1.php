<?php
require_once( dirname( __FILE__ ) . '/admin.php' );
if($_POST['id'])
{
$id=$_POST['id'];

$sql = "delete from main_services where id='$id'";


mysql_query( $sql);
}
?>