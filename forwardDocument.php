<?php
session_start();
?>

	<link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="justified-nav.css" rel="stylesheet">	
	<style type='text/css'>
	.col-lg-4 {
		
		horizontal-align:middle;
	
	}
	</style>
	<!--
<LINK href="css/program design.css" rel="stylesheet" type="text/css">
	-->


<body >
<?php	
	//require("header.php");
require("db_page.php");

	require("title.php");
	?>
<title>Forward Document</title>
<?php
require("functions/form functions.php");
require("functions/document functions.php");
require("functions/general functions.php");

?>
<?php

$_SESSION['page']="forwardDocument.php";
$db=retrieveRecordsDb();
$row=getDocumentDetails($db,getDocumentId($db,$_SESSION['reference_number']));
$confirmSubject=$row['subject'];
?>
	<div align=right><a href='receiveDocument.php'>Go Back to Division Page</a></div>
	<br>
	<div class='container'>
	<div align=center class='well col-lg-6 col-centered'>
	
	<form action='submit.php' method='post'>
		<legend>Forward Document Copy</legend>
		<table align=center>
		<tr>
			<td><label class='control-label'>Subject of Document:</label></td>
			<td><?php echo $confirmSubject; ?></td>
		</tr>
		<tr>
			<td><label class='control-label'>Enter Destination:</label></td>
			<td>
				<?php
				if(isset($_GET['fTy'])){
					retrieveDepartmentListHTML($db,"","forward_to");
				
				
				}
				else {
				?>
				<input class='form-control' style='width: 80%' cols=50 type=text name='forward_to' />
				<?php
				}
				?>
			</td>
		</tr>
		<tr>
			<td><label class='control-label'>Enter Additional Remarks:</label></td>
			<td>
			<textarea class='form-control' rows=5 cols=50 name='forwardRemarks'></textarea>
			</td>
		</tr>
		<tr>
			<td	colspan=2 align=center><input type=hidden name='docId' value='<?php echo $documentId; ?>' ><input class='btn btn-primary' type=submit value='Submit' />
		</td>
		</tr>
	</table>
	</form>
	</div>
	</div>