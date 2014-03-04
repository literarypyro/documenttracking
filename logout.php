<?php
session_start();
?>
<?php
require('db_page.php');
$db=retrieveUsersDb();
$loginSQL="insert into log_history(username, time, action) values ('".$_SESSION['username']."','".date("Y-m-d H:i:s")."','logout')";
$loginrs=$db->query($loginSQL);
$loginnm=$loginrs->num_rows;

$sql="update log_action set logout='".date("Y-m-d H:i:s")."' where username='".$_SESSION['username']."'";
$rs=$db->query($sql);
session_destroy();

header('Location: login.php');


?>

