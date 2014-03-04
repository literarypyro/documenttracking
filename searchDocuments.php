<?php
session_start();

?>
	<!--
	<LINK href="css/program design.css" rel="stylesheet" type="text/css">
	-->	
	<link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="justified-nav.css" rel="stylesheet">	
	
	
	<body>
	<!--
	<body style="background-image:url('body background.jpg');">
	-->
	<?php	
	require("db_page.php");

	require("title.php");
?>
<style type='text/css'>
.form-control {
	width:auto;
}
</style>
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
	<title>Search Documents</title>
	<div align=right><a href="receiveDocument.php">Back to Main Page</a></div>

<?php
require("functions/general functions.php");
require("functions/form functions.php");
require("functions/document functions.php");

$whereClause="";

$validateElement=0;
$validateElement+=validateForm($_POST['subject']);
$validateElement+=validateForm($_POST['classification']);
$validateElement+=validateDate($_POST['dateYear'],$_POST['dateMonth'],$_POST['dateDay']);
$validateElement+=validateForm($_POST['reference']);

if($validateElement>0){
	$subjectClause="";
	$classificationClause="";
	$dateClause="";
	$referenceClause="";	

	$whereClause=" where "; 	
	if(validateForm($_POST['subject'])>0){
		$subjectClause=" subject like '%%".str_replace(' ','%',$_POST['subject'])."%%'";
		
		if($validateElement>1){
			$subjectClause.=" AND ";	
		}

	}

	if(validateForm($_POST['classification'])>0){
	
		if($_POST['classification']=='5'){
			$class=$_POST['classification_search'];
		}
		else {
			$class=$_POST['classification'];
		}
		$classificationClause=" classification_id='".$class."'";

		if($validateElement>1){
			$classificationClause.=" AND ";	
		}

	}

	if(validateDate($_POST['dateYear'],$_POST['dateMonth'],$_POST['dateDay'])>0){
		if($_POST['dateDay']==""){
			$dateClause=" receive_date like '%%".$_POST['dateYear']."-".date("m",strtotime($_POST['dateYear']."-".$_POST['dateMonth']))."%%'";
		}
		else {
			$dateClause=" receive_date like '%%".$_POST['dateYear']."-".date("m",strtotime($_POST['dateYear']."-".$_POST['dateMonth']))."-".$_POST['dateDay']."%%'";
		}
		
//		echo $dateClause;
//		echo $validateElement;

		if($validateElement>1){
			$dateClause.=" AND ";	
		}
	}

	if(validateForm($_POST['reference'])>0){

		$referenceClause=" (select reference_id from document_receipt where document_id=document.ref_id) like '%%".$_POST['reference']."%%'";
		
		//		$referenceClause=" reference like '%%".$_POST['reference']."%%'";
	}

	$whereClause.=$subjectClause.$classificationClause.$dateClause.$referenceClause;
	
	$filter="";

	if($_SESSION['user_type']=='records officer'){
		$filter="";
		
	}
	else {
		$filter.=" and ((sending_office='".$_SESSION['department']."' and security in ('divSecured','GMsecured')) or (security='unsecured'))";

	}

	$db=retrieveRecordsDb();
	

	$searchSQL="select * from document ".$whereClause." and document_type='".$_SESSION['find_type']."' ".$filter; 	
	$searchRS=$db->query($searchSQL);	

	$searchNM=$searchRS->num_rows;

	
	switch ($_SESSION['find_type']) {
    case "IN":
		$document_label="INCOMING";
        break;
    case "OUT":
		$document_label="OUTGOING";
			break;
    case "MEMO":
		$document_label="INTERNAL MEMO";
        break;
    case "ORD":
		$document_label="OFFICE ORDER";
        break;

	}	

	
	
	if($searchNM>0){
	?>

	<table class='table table-striped table-hover' width=100%>
	<thead>
	<tr>
	<th colspan=5><h2>SEARCH RESULTS FOR <?php echo $document_label; ?> DOCUMENTS </h2></th>
	</tr>
	<tr>
	<th>Subject</th>
	<th>Originating Office</th>
	<th>Document Date</th>
	<th>Received Date</th>
	<th>Reference Number</th>
	</tr>
	</thead>
	<tbody>
	<?php
	$view_Option="<select class='form-control' name='view'>";
	for($i=0;$i<$searchNM;$i++){
		$searchRow=$searchRS->fetch_assoc();
		
?>
			<tr>
				<td><?php echo $searchRow['subject']; ?></td>
				<td><?php echo getOriginatingOffice($db,$searchRow['originating_office']); ?></td>
				<td><?php echo $searchRow['document_date']; ?></td>
				<td><?php echo $searchRow['receive_date']; ?></td>
				<td><?php echo calculateReferenceNumber($db,$searchRow,adjustControlNumber($searchRow['ref_id'])); ?></td>
			</tr>

			<?php

		$view_Option.="<option value='".$searchRow['ref_id']."'>".calculateReferenceNumber($db,$searchRow,adjustControlNumber($searchRow['ref_id']))."</option>";

	}
$view_Option.="</select>";
?>
	</tbody>

</table>
<form method=post action='document_history.php'>
<?php

	echo "<table>";
	echo "<tr>";
	echo "<th>View Document:</th>";
	echo "<td>";
	echo $view_Option;

	echo "</td>";
	echo "<td><input class='btn btn-success' type=submit value='View' /></td>";
	

	echo "</tr>";
	echo "</table>";

?>


</form>
<br>
<br>



<?php
	}
	else {
		echo "Your search has found 0 results.";
		echo "<br><br>";
		
	}

?>
<?php
	
}
?>

<div class='well col-lg-4'> 
<form class="bs-example form-horizontal"  action='searchDocuments.php' method='post'>
<legend>Search for Documents</legend>
<div class='form-group'>
	<label class='col-lg-4 control-label'>Subject</label>
	<div class='col-lg-8'>
	<input class='form-control'  type='text' name='subject' />
	</div>
</div>
<div class='form-group'>

	<label class='col-lg-4 control-label'>Classification</label>
	<div class='col-lg-8  form-inline' >
		<div class='form-group col-lg-6'>

		<select class='form-control' name='classification' id='classification' onchange='checkAlternate(this,5,"classification_search")' >
		<option></option>
		<?php

		$db=retrieveRecordsDb();
		$sql="select * from classification";
		$rs=$db->query($sql);

		$nm=$rs->num_rows;

		for($i=0;$i<$nm;$i++){
			$row=$rs->fetch_assoc();
?>			
			<option value='<?php echo $row['id']; ?>'><?php echo $row['classification_desc']; ?></option>

<?php
		}
		?>
		</select>
		</div>
		<div class='form-group col-lg-4'>

		<input class='form-control'  type=text name='classification_search' id='classification_search' disabled=true />
		</div>
	</div>
</div>
<div class='form-group'>

	<label class='col-lg-4 control-label'>Received Date (YYYY-mm-dd)</label>
	<div class='col-lg-8 form-inline'>
		<div class='form-group col-lg-5'>
		<select  class='form-control' name='dateMonth'>
		<option></option>
		<?php 
		$yer=date("Y");
		$db=retrieveRecordsDb();
		for($i=1;$i<13;$i++){
			$mm=$yer."-".$i;
			$month=date("F",strtotime($mm));
			
		?>
			<option value='<?php echo $i; ?>'><?php echo $month; ?></option>
		<?php
		}
		?>
		</select>
		</div>
		<div class='form-group col-lg-3'>
		<select  class='form-control' width=2px name='dateDay'>
		<option></option>
		<?php
		for($i=1;$i<32;$i++){
		?>
			<option value='<?php echo $i; ?>'><?php echo $i; ?></option>
		<?php		
		}
		?>
		</select>
		</div>
		<div class='form-group col-lg-4'>
		<select  class='form-control' name='dateYear'>
		<option></option>
		<?php
		$dateYY=date("Y")*1;
		
		for($i=$dateYY-6;$i<$dateYY+15;$i++){
		?>
			<option value='<?php echo $i; ?>'><?php echo $i; ?></option>
		<?php		
		}
		?>
		</select>
		</div>
	</div>
</div>	
<div class='form-group'>

	<label class='col-lg-4 control-label'>Reference Number</label>
	<div class='col-lg-8'>
	<input class='form-control' type='text' name='reference' />
	</div>
</div>	
<div class='form-group'>
	<div class='col-lg-12'>
	<label class='col-lg-10 control-label'><font color=red>Leave the items you don't want to search for blank.</font></label>
	</div>

</div>	
<div class='form-group' align=center>
	<input  type=submit class='btn btn-primary' value='Search' />
</div>	

</form>
</div>
<?php
function validateForm($element){
	$elementcount=0;	
	if($element==""){
		$elementcount=0;
	}

	else {
		$elementcount=1;
	}


	return $elementcount;

}

function validateDate($y,$m,$d){
	$elementcount=1;	
	if((trim($m)=="")){
		$elementcount=0;
	}

	if((trim($y)=="")){
		$elementcount=0;
	}
	

	return $elementcount;



}

?>