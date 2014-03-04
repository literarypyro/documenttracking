<?php
session_start();
?>
<?php
/** Upload the Document soft copy 
*
* This page helps upload the document and confirm the Reference Number 
*
* @author Patrick Simon Silva
* @version 2.0
* @package uploadDocument
*/
?>
<!--
<LINK href="css/program design.css" rel="stylesheet" type="text/css">
-->
<link href="dist/css/bootstrap.min.css" rel="stylesheet">
<link href="justified-nav.css" rel="stylesheet">	

<!--style="background-image:url('body background.jpg');"-->
<body >

<?php	
//	require("header.php");
require("db_page.php");
require("title.php");
?>
<style type='text/css'>
	.container {
		margin-left:30%;
		float:left;
	}
	legend {
		text-align:center;
	}
</style>
<title>Receive/Issue New Document</title>
<?php
require("functions/form functions.php");
require("functions/document functions.php");
require("functions/general functions.php");
?>
<link rel="stylesheet" href="css/humanity/jquery-ui-1.10.4.custom.css" />
<script type='text/javascript' src="js/jquery-1.10.2.js"></script>
<script type='text/javascript'  src="js/jquery-ui-1.10.4.custom.min.js"></script>
<script language='javascript'>
$(document).ready(function(){
	$('#receive_date').datepicker();

});

</script>
<?php
	$db=retrieveRecordsDb();
	$_SESSION['page']="uploadDocument.php";

	//retrieve the inputted Document Id 
	if(isset($_SESSION['documentCreated'])){
		$documentId=$_SESSION['documentCreated'];
		$_SESSION['documentCreated']=="";	
	}

	if(isset($_POST['updateFile'])){
		$documentId=$_POST['updateFile'];
	}

	if(isset($_POST['updateFileApprove'])){
		$documentId=$_POST['updateFileApprove'];
	}

	$reference_number="";
	$reference_number=calculateReferenceNumber($db,getDocumentDetails($db,$documentId),adjustControlNumber($documentId)); //retrieved from functions/document functions
	$row=getDocumentDetails($db,$documentId); //retrieved from functions/document functions

	$confirmSubject=$row['subject'];
	$confirmOffice=$row['originating_office'];
	$confirmSecure=$row['security'];
	$statusCurrent=$row['status'];

?>
	<div align=right><a href='receiveDocument.php'>Go Back to Division Page</a></div>
	<br>
	<div class='container'>
	<div class='well col-md-6'>
	<form enctype="multipart/form-data" action='submit.php' method='post'>
		<legend>Upload Document</legend>
		<table align=center>
		<tr>
			<td><label class='control-label'>Subject of Document:</label></td>
			<td><?php echo $confirmSubject; ?></td>
		</tr>
		<tr>
			<td><label class='control-label'>Date of Confirmation:</label></td>
			<td>
			<div class='form-inline'>
			<div class='form-group'>			
			<input type='text' name='receive_date' id='receive_date' class='form-control' />
			</div>	
			<div class='form-group'>			
			<?php retrieveHourListHTML('receiveHour');  // retrieved from functions/form functions ?>
			</div>	
			<div class='form-group'>			
			<?php retrieveMinuteListHTML("receiveMinute");  // retrieved from functions/form functions ?>
			</div>	
			<div class='form-group'>			
			<?php retrieveShiftListHTML('amorpm');  // retrieved from functions/form functions ?>
			</div>	
			</div>
			</td>
		</tr>
		<tr>
			<td><label class='control-label'>Confirm Reference No.</label></td>
			<td><input class='form-control' type=text name='reference_number' size=40 value='<?php echo $reference_number; ?>' /></td>
		</tr>
		<tr>
			<td><label class='control-label'>Upload Document Here:</label></td>
			<td><input class='form-control' type='file' name='document' /><input type='hidden' name="MAX_FILE_SIZE" value="4000000" />
		</tr>
		<tr>
			<td	colspan=2 align=center><input type=hidden name='docId' value='<?php echo $documentId; ?>' ><input class='btn btn-primary' type=submit value='Submit' />
		</td>
		</tr>
	</table>
	</form>
	</div>
	</div>

