<?php
session_start();
?>
<?php
//require("header.php");
require("db_page.php");
require("functions/document functions.php");
require("functions/general functions.php");
require("functions/routing process.php");
require("functions/user functions.php");
$mainPageMessage="This page reloads every 5 minutes.";

require("title.php");


$_SESSION['page']="receiveDocument.php";


?>	
	<link href="dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="justified-nav.css" rel="stylesheet">	
<!--	

	<LINK href="css/tab menu.css" rel="stylesheet" type="text/css">
	<LINK href="css/menuh.css" rel="stylesheet" type="text/css">
	<LINK href="css/program design.css" rel="stylesheet" type="text/css">
-->
    <script type="text/javascript" src="jquery-1.11.0.js"></script>
    <script type="text/javascript" src="prototype.js"></script>
    <script type="text/javascript" src="dist/js/bootstrap.min.js"></script>
	
	<style type='text/css'>
	.nav > li >a:hover {
		background-color:gold;
	
	}
	.nav-justified > li > a:hover {
		background-color:gold;
		background-image:none;
	}
	
	
	</style>
	
	<?php
//	require("javascript/main menu.php");
	echo '<meta http-equiv="refresh" content="300;url=receiveDocument.php" />';
	?>
	<title>Main Page</title>
	<!--style="background-image:url('body background.jpg');"-->
	<body  onload="openWindow()">

<?php
$sql="select * from department where department_code='".$_SESSION['department']."'";
$db=retrieveRecordsDb();

turnOfTheYear($db);

$rs=$db->query($sql);
$row=$rs->fetch_assoc();

?>

<?php require("main_left_sidebar.php"); ?>	

	
<table id='cssContent' border="0" width="100%" id="table1" cellspacing="0" bgcolor="#FFFFFF" cellpadding="5px" bordercolor="#CCCCCC" style="border:1px solid white; border-left-width: 1px; border-right-width: 1px; border-bottom-width: 1px">
<tr>

<?php //require("main_left_sidebar.php"); ?>	
<!--background-color:#66ceae;-->
	<td width="85%" rowspan=2 valign="top"  align=center style="border-style: none; border-width: medium;background-color:white;" bordercolor="#FF6600">
<div  width=100%>
<?php
if($_GET['ts']=="2"){

}
else if($_GET['ts']=="3"){
}
else if($_GET['ts']=="4"){
}

else if($_GET['ts']=="6"){
}
else if($_GET['pp']==6){

}
else {
	$dFO=4;

	require("main/office orders.php");
}
?>
</div>
<br>
<div  width=100%>

<?php

if($_GET['ts']=="2"){

}
else if($_GET['ts']=="3"){
}
else if($_GET['ts']=="4"){
}
else if($_GET['ts']=="5"){
}

else if($_GET['ts']=="6"){
}
else {
	if($_GET['pp']=="1a"){
		require("main/pending_documents.php");
	}
	else if($_GET['pp']=="1b"){
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
	else if($_GET['pp']==6){
		require("main/endofMonth.php");
	}
	else {
		if($_SESSION['department']=="OGM"){
			require("main/ogm page.php");
		}
		else {
			$iN=5;
			$St=5;
			require("main/pending_documents.php");
		}
	}
}
?>
</div>

<br>
<!--id="content"-->
<div  width=100%>
<?php
if($_GET['ts']==1){
//	require("main/office orders.php");
}
else if($_GET['ts']==2){
	require("main/new action.php");
}
else if($_GET['ts']==6){
	require("main/search Document.php");
}
else if($_GET['ts']==3){
	if($_SESSION['department']=="REC"){
		require("main/userManagement.php");
	}
}
else if($_GET['ts']==4){
	if($_SESSION['department']=="REC"){
		require("main/backupAccount.php");
	}
}
else if($_GET['ts']==5){
	if($_SESSION['department']=="REC"){
		require("main/outgoing copies.php");
	}
}

else {
	$dFO=10;
//	require("main/office orders.php");
}
?>
</div>
</td>
<?php 
//require("main_right_sidebar.php"); ?>	
</tr>
</table>

<?php

$filename="data/".$_SESSION['department'].".txt";
$latest_timestamp=filemtime($filename);
echo "
<script type=\"text/javascript\">
var Comet = Class.create();
Comet.prototype = {

  timestamp: ".$latest_timestamp.",
  url: './newMessages.php',
  noerror: true,

  initialize: function() { },

  connect: function()
  {
    this.ajax = new Ajax.Request(this.url, {
      method: 'get',
      parameters: { 'timestamp' : this.timestamp, 'department' : '".$_SESSION['department']."' },
      onSuccess: function(transport) {
        // handle the server response
        var response = transport.responseText.evalJSON();
        this.comet.timestamp = response['timestamp'];
        this.comet.handleResponse(response);
        this.comet.noerror = true;
      },
      onComplete: function(transport) {
        // send a new ajax request when this request is finished
        if (!this.comet.noerror)
          // if a connection problem occurs, try to reconnect each 5 seconds
          setTimeout(function(){ comet.connect() }, 5000); 
        else
          this.comet.connect();
        this.comet.noerror = false;
      }
    });
    this.ajax.comet = this;
  },

  disconnect: function()
  {
  },

  handleResponse: function(response)
  {
    alert(\"You have a new message!\");
	window.location.href='receiveDocument.php';
//	$('content').innerHTML += '<div>' + response['msg'] + '</div>';
  },

  doRequest: function(request)
  {
    new Ajax.Request(this.url, {
      method: 'get',
      parameters: { 'msg' : request }
    });
  },
  
  refresh: function()
  {
	comet.doRequest($('word').value);return false;
	//alert(\"A\");
  }
  
  
  
}
var comet = new Comet();
comet.connect();
</script>";

?>
<?php
// echo "
// <script type=\"text/javascript\">
// function openWindow(){
// window.open(\"http://localhost/scanMessages2.php?department=".$_SESSION['department']."\");
// }
// </script>";
?>
</body>