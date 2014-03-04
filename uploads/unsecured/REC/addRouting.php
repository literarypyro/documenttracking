<?php
session_start();
?>
	<body style="background-image:url('body background.jpg');">
	<?php	
		require("header.php");
?>

<?php
require("db_page.php");
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


<LINK href="css/program design.css" rel="stylesheet" type="text/css">
	<div align=right><a href='routing report.php'>Go back to Interactive Routing page</a></div>
	<table width=100% align=center border=1>
	<tr><th colspan=4>ROUTING DESTINATIONS</th></tr>
	<tr>
		<th>Name of Official</th>
		<th>Position of Official</th>
		<th>Destination Office</th>
		<th>Action Taken</th>
	</tr>
	<?php
	$db=retrieveRecordsDb();
	$rs=getRoutingTargets($db,$_SESSION['routingID']);	
	$nm=$rs->num_rows;
	for($i=0;$i<$nm;$i++){
		$row=$rs->fetch_assoc();
		$row2=getOfficer($db,$row['to_name']);
		$action=getAction($db,$row['action_id']);
		
	?>
		<tr>
		<td><?php echo $row2['name']; ?></td>
		<td><?php echo $row2['position']; ?></td>
		<td><?php echo $row['destination_office']; ?></td>
		<td><?php echo $action; ?></td>
		</tr>

	<?php	
	}	
	?>	
	</table>

	<br>
	<form action='submit.php' method=post>
	<table width=100% align=center border=1>
	<tr><th colspan=4>ADD DESTINATION</th></tr>
	</table>
	<br>
	<form action='submit.php' method=post>
	<table width=75% style='border:1px solid gray' >
	<tr><th style='border:1px solid gray' colspan=4>SEND TO INDIVIDUAL DESTINATIONS/ALL OFFICES</th></tr>
	<tr>
	<td><b>To:</b> </td>
	<td><input type=checkbox name='sendToAll' value='on' onclick='disableForm(this)' />SEND TO ALL OFFICES</td>
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
	<tr><td>Destination Office</td>
	<td>
	<select id='to_department' name='to_department'>
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

	<select name='to_action' id='to_action' onchange='checkAlternate(this,"X","other_action")' >
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
	
	</select>&nbsp;<input type='text' id='other_action' disabled=true name='other_action' size=30 cols=60 />
	</td></tr>
	<tr>
	<td>
	Additional Remarks:
	</td>
	<td>
	<textarea name='remarks' cols=70 rows=5></textarea>
	</td>
	</tr>
	<tr>
	<td align=center colspan=2>
	<input type=submit value=Confirm />
	</td>
	</tr>
	</table>
	</form>	






