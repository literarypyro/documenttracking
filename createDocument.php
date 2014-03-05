<?php
session_start();
?>
<?php
/** Enter the Document details
*
* This page helps create the document 
*
* @author Patrick Simon Silva
* @version 2.0
* @package createDocument
*/
?>
<?php	
//require("header.php");
require("db_page.php");
require("title.php");
require("functions/form functions.php");
require("functions/general functions.php");
$_SESSION['page']="createDocument.php";

?>

<link rel="stylesheet" href="css/humanity/jquery-ui-1.10.4.custom.css" />
<script type='text/javascript' src="js/jquery-1.10.2.js"></script>
<script type='text/javascript'  src="js/jquery-ui-1.10.4.custom.min.js"></script>
<script language='javascript'>
$(document).ready(function(){
	$('#receive_date').datepicker();
	$('#document_date').datepicker();

});

</script>
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
function prepareSubmitForm(){
	var dDate=new Date($('#document_date').datepicker('getDate'));
	
	var month=dDate.getMonth().toString()*1+1;
	var day=dDate.getDate();
	var year=dDate.getFullYear();
	
	
	var documentDate=year+""+month+""+day;
	documentDate*=1;
	
	
	var dDate=new Date($('#receive_date').datepicker('getDate'));
	
	var month=dDate.getMonth().toString()*1+1;
	var day=dDate.getDate();
	var year=dDate.getFullYear();
	

	
	var receiveDate=year+""+month+""+day;
	receiveDate*=1;
	
	if(receiveDate<documentDate){
	
		alert("Receive Date must be greater or equal to Document Date");
	}
	else {
		document.forms["submitForm"].submit();
	
	}
	
}
</script>
<title>Receive/Issue New Document</title>
<!--
<LINK href="css/program design.css" rel="stylesheet" type="text/css"> 
-->
<link href="dist/css/bootstrap.min.css" rel="stylesheet">
<link href="justified-nav.css" rel="stylesheet">	
<style type='text/css'>
.form-control {
	width:auto;
}
.container {
	margin-left:30%;
	float:left;
}
legend {
	text-align:center;
}
</style>
<!--style="background-image:url('body background.jpg');"-->
<body >
<div align=right><a href="receiveDocument.php">Back to Main Page</a></div>
<div class='container'>
<div class='well col-md-8'>
<form enctype="multipart/form-data" id='submitForm' name='submitForm' action='submit.php' method='post'>
<legend>
Receive/Issue New Document
</legend>
<table align=center >
<tr>
	<td><label class='control-label'>Type of Document:</label></td>
	<td>
	<select class="form-control" name='document_type'>
		<option value='IN'>Incoming</option>
		<option value='MEMO'>Internal Document</option>
		<option value='ORD'>Office Order</option>
		<option value='OUT'>Outgoing</option>
	</select>
	
	</td>
</tr>

<tr>
	<td><label class='control-label'>Subject of Document:</label></td>
	<td><input type='text' name='doc_subject' size=40 /></td>
</tr>
<tr>
	<td><label class='control-label'>Classification of Document:</label></td>
<!--
	<td><input type=text name='classification' size=40 /></td>
</tr>
<tr>
	<td  align=right>-or- Select from the list<input type=checkbox name='chooseList' value='on' ></td>
	-->
	<td>
	<div class='form-inline'>
	<?php
		$db=retrieveRecordsDb(); // retrieved from db_page
		retrieveClassListHTML2($db,"class_list",'classification',$_SESSION['department']); // retrieved from functions/form functions	
	?>
	</div>
	</td>
</tr>
<tr>
	<td><label class='control-label'>
	Date of Document:
	</label></td>
	<td>
	<div class='form-inline'>
	
	<div class='form-group'>
	<input type='text' class='form-control' id='document_date' name='document_date' />

	</div>
	<div class='form-group'>
	<?php retrieveHourListHTML("documentHour");  // retrieved from functions/form functions ?>
	</div>
	<div class='form-group'>
	<?php retrieveMinuteListHTML("documentMinute");  // retrieved from functions/form functions ?>
	</div>
	<div class='form-group'>
	<?php retrieveShiftListHTML("docamorpm");  // retrieved from functions/form functions ?>
	</div>
	</td>
</tr>
<tr>
	<td><label class='control-label'>Date/Time Sent/Received:
	</label></td>
	<td>
	<div class='form-inline'>
	
	<div class='form-group'>
	<input class='form-control' type='text' name='receive_date' id='receive_date'  />
	</div>

	<div class='form-group'>
	<?php retrieveHourListHTML("receiveHour");  // retrieved from functions/form functions ?>
	</div>
	<div class='form-group'>
	<?php retrieveMinuteListHTML("receiveMinute");  // retrieved from functions/form functions ?>
	</div>
	<div class='form-group'>
	<?php retrieveShiftListHTML("amorpm");  // retrieved from functions/form functions ?>
	</div>
	</div>
	
	
	</td>
</tr>
<tr>
	<td><label class='control-label'>Originating Office:</label></td>
<!--
	<td><input type=text name='origInput' /></td>
</tr>
<tr>
	<td  align=right>-or- Select from the list<input type=checkbox name='origList' value='on' ></td>
	-->
	<td>
	<div class='form-inline'>
	
	<?php
	
	$db=retrieveRecordsDb(); // retrieved from db_page
	$departmentName=getDepartment($db,$_SESSION['department']); //retrieved from functions/general functions
	$sql="select * from originating_office where department_name='".$departmentName."'";
	$rs=$db->query($sql);
	$row=$rs->fetch_assoc();
	
	retrieveOfficeListHTML($db,$row['department_code'],'originating_office','origInput');  // retrieved from functions/form functions
	?>
	</div>	
	</td>
</tr>
<tr>
	<td><label class='control-label'>Originating Officer:</label></td>
	<td>
	<div class='form-inline'>
	
	<div class='form-group'>
	
	<?php
	$db=retrieveRecordsDb(); //retrieved from db_page

	$sql="select * from originating_officer";
	$rs=$db->query($sql);
	$nm=$rs->num_rows;
	?>
	<select class='form-control' id='originating_officer' name='originating_officer' onchange="checkAlternate(this,'OTHER','alterOfficer')">
	<?php
	for($i=0;$i<$nm;$i++){
		$row=$rs->fetch_assoc();
		?>
		<option value='<?php echo $row['id']; ?>'><?php echo $row['name']; ?></option>
		<?php
	}
	?>
	<option value='OTHER'>OTHER</option>
	<?php
	?>	
	</select>
	</div>
	<div class='form-group'>
	<input type='text' class='form-control' id='alterOfficer' name='alterOfficer' />
	</div>
	</div>
	
	</td>
</tr>
<tr>
	<td><label class='control-label'>Security Level</label></td>
	<td>
		<select class='form-control' name='security'>
		<option value='unsecured'>Accessible to All Divisions</option>
		<option value='GMsecured'>GM Level</option>
		<option value='divSecured'>Division Level</option>
		</select>
	</td>
</tr>
<tr>
	<td colspan=2 align=center><input type=button value='Submit' class='btn btn-primary' onclick='prepareSubmitForm()' /></td>
</tr>
</table>
</form>
</div>
</div>
</body>