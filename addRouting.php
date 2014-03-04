<?php
session_start();
?>
<?php
/** Enter Routing Destinations
*
* In generating a new Routing Action of a document, there are two parts.
*  The first part specifies the request time, and the origin.  This, the second 
* part, lists the destination offices of the document, whether single or multiple,
* or to all offices.
*
* @author Patrick Simon Silva
* @version 2.0
* @package addRouting
*/
?>
	<!--style="background-image:url('body background.jpg');"-->
	<body >
	<?php	
//		require("header.php");
	require("db_page.php");
	$mainPageMessage="This page will reload to the main page after 7 mins.";

	require("title.php");
?>

<?php
require("functions/routing process.php");
require("functions/form functions.php");
$_SESSION['page']="addRouting.php";
?>
<?php

?>
<script language='javascript'>
function disableForm(a){
	if(a.checked==true){
		document.getElementById("to_department").disabled=true;
		document.getElementById("to_name").disabled=true;
	
	}
	else {
		document.getElementById("to_department").disabled=false;
		document.getElementById("to_name").disabled=false;
	}
}

function checkAlternate(a,v,alter){
	if(a.value==v){
		document.getElementById(alter).disabled=false;
	}
	else {
		document.getElementById(alter).disabled=true;
	
	}

}
</script>
<link href="dist/css/bootstrap.min.css" rel="stylesheet">
<link href="justified-nav.css" rel="stylesheet">	

<style type='text/css'>
.form-control {
	width:auto;
}
thead th {
	text-align:center;

}
</style>
<meta http-equiv="refresh" content="420;url=receiveDocument.php" />
<!--
<LINK href="css/program design.css" rel="stylesheet" type="text/css">
-->
	<div align=right><a href='routing report.php'>Go back to Interactive Routing page</a></div>
	<table width=100% align=center class='table table-striped table-hover table-bordered'>
	<thead>
	<tr><th colspan=4><h3>ROUTING DESTINATIONS</h3></th></tr>
	<tr>
		<th>Name of Official</th>
		<th>Position of Official</th>
		<th>Destination Office</th>
		<th>Action Taken</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$db=retrieveRecordsDb();
	$rs=getRoutingTargets($db,$_SESSION['routingID']);	
	$nm=$rs->num_rows;
	for($i=0;$i<$nm;$i++){
		$row=$rs->fetch_assoc();
		if($row['to_name']=="OTHER"){
			$officer_name=$row['alter_to'];
			$officer_position="";		
		}
		else {
			$row2=getOfficer($db,$row['to_name']);
			$officer_name=$row2['name'];
			$officer_position=$row2['position'];
		
		}
		
		
		$action=getAction($db,$row['action_id']);
		
	?>
		<tr>
		<td><?php echo $officer_name; ?></td>
		<td><?php echo $officer_position; ?></td>
		<td><?php echo $row['destination_office']; ?></td>
		<td><?php echo $action; ?></td>
		</tr>

	<?php	
	}	
	?>	
	</tbody>
	</table>

	<br>
	<form action='submit.php' method=post>
	<table width=100% align=center>
	<tr><th colspan=4><h3>ADD DESTINATION</h3></th></tr>
	</table>
	</form>
	<br>
	<div class='well col-lg-5' >
	<form action='submit.php' method=post>
	<legend>SEND TO INDIVIDUAL DESTINATIONS/ALL OFFICES</legend>
	
	<table  >
	<tr>
	<td><b>To:</b> </td>
	<td>
	<div class='form-inline'>
		<div class='form-group'>
		<input class='checkbox'	type=checkbox name='sendToAll' value='on' onclick='disableForm(this)' />
		</div>
		<div class='form-group'>
		SEND TO ALL OFFICES
		</div>
	</div>
	</td>
	</tr>
	<tr>
	<td>Officer</td>
	<td>
	<?php
		$db=retrieveRecordsDb();
		retrieveOfficerListHTML($db,"to_name");
	?>	
	</td>
	</tr>
	<tr><td colspan=2>(If Other)</td></tr>
	<tr>
	<td>Name</td>
	<td>
	<input class='form-control' type='text' id='alterOfficer' name='alterOfficer' />
	</td>
	</tr>
	<tr>
	<td>Position</td>
	<td>
	<input class='form-control' type='text' id='alterPosition' name='alterPosition' />
	</td>
	</tr>
	<tr><td>Destination Office</td>
	<td>
	<select class='form-control' id='to_department' name='to_department'>
	<?php
	$db=retrieveRecordsDb();
	$sql="select * from department";
	$rs=$db->query($sql);
	$nm=$rs->num_rows;
	for($i=0;$i<$nm;$i++){
	$row=$rs->fetch_assoc();
	?>
		<option value='<?php echo $row['department_code']; ?>'><?php echo $row['department_name']; ?></option>
	<?php
	}
	?>
	</select>
	</td></tr>
	<tr><td>Action to Document</td>
	<td>
	<div class='form-inline'>
	<div class='form-group'>
	<select class='form-control' name='to_action' id='to_action' onchange='checkAlternate(this,"X","other_action")' >
	<?php
	$db=retrieveRecordsDb();
	$sql="select * from document_actions";
	$rs=$db->query($sql);
	$nm=$rs->num_rows;
	for($i=0;$i<$nm;$i++){
	$row=$rs->fetch_assoc();
	?>
		<option value='<?php echo $row['action_code']; ?>'><?php echo $row['action_description']; ?></option>
	<?php
	}
	?>
	
	</select>&nbsp;
	</div>
	<div class='form-group'>
	<input class='form-control'  type='text' id='other_action' disabled=true name='other_action' size=30 cols=60 />
	</div>
	</div>
	
	</td></tr>
	<tr>
	<td>
	Additional Remarks:
	</td>
	<td>
	<textarea class='form-control' name='remarks' cols=70 rows=5></textarea>
	</td>
	</tr>
	<tr>
	<td align=center colspan=2>
	<input class="btn btn-primary" type=submit value=Confirm />
	</td>
	</tr>
	</table>
	</form>	
	</div>





