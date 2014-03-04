<?php
session_start();
?>
<?php
require("db_page.php");

require("title.php");
require("functions/document functions.php");
require("functions/general functions.php");
require("functions/routing process.php");
require("functions/user functions.php");
?>
<!--
<LINK href="css/program design.css" rel="stylesheet" type="text/css">
-->
<link href="dist/css/bootstrap.min.css" rel="stylesheet">
<link href="justified-nav.css" rel="stylesheet">	

<title>Full List</title>
<body >
<div align="right" width=100%><a href="receiveDocument.php">Back to Main Page</a></div>
<?php
if($_GET['pp']=="1a"){
	require("main/pending_documents.php");
}
if($_GET['pp']=="1b"){
	require("main/outgo_documents.php");
}
else if($_GET['pp']==2){
	require("main/unsent_documents.php");
}
else if($_GET['pp']==3){
	require("main/ogm page.php");
}
else if($_GET['pp']==4){
	require("main/records_officer.php");
}
else if($_GET['pp']==5){
	require("main/copy forwarded.php");
}

else if($_GET['ts']==5){
	require("main/outgoing copies.php");
}

else if($_GET['ts']==1){
	require("main/office orders.php");
}
?>
</body>