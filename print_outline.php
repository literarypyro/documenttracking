<?php
session_start();
?>
<script language="javascript">
function openPage(url){
window.open(url,"_self");

}

</script>
<style type='text/css'>
table {
	border-collapse:collapse;


}

</style>
<?php
require("Classes/PHPExcel.php");
require("Classes/PHPExcel/IOFactory.php");
require("functions/excel functions.php");
require("functions/routing process.php");
require("functions/general functions.php");
require("functions/form functions.php");
require("functions/document functions.php");

require("db_page.php");

if(($_SESSION['page']=="routing report.php")||($_SESSION['page']=="document_history.php")){

?>
<?php

$routingHeading="
<table width=100%>
<tr >
<td valign=center align=center rowspan=4>
<img align=center valign=top src='dotc.jpg' height=80 width=80  ></img>
</td>
<td colspan=2 valign=top>
Republic of the Philippines
</td>
<th align=center>ROUTING/ACTION SLIP</th>
</tr>
<tr>
<td colspan=2><b>DEPARTMENT OF TRANSPORTATION AND COMMUNICATIONS</b></td>
<td valign=top align=center>(Always Attach this Form to All Communications)</td>
</tr>
<tr>
<td >
METRO RAIL TRANSIT III EDSA LINE (DOTC-MRT3)
</td>
<td >
&nbsp;</td>
</tr>

</tr>
<tr width=100%>
<td colspan=2 width=50%>
&nbsp;
</td>
<td colspan=2 width=50% align=center>Reference Number: ".$_SESSION['reference_number']."
</td>
</tr>
<tr>
<td colspan=4>
</table>";
$_SESSION['printContent']=$routingHeading.$_SESSION['printOut'];
echo $_SESSION['printContent'];

if(isset($_GET['print'])){
	$ref_no=$_SESSION['reference_number'];

	if(is_dir("c:/routing slip")){
	}
	else {
		mkdir("c:/routing slip");
	}

	if(is_dir("printout/routing slip")){
	}
	else {
		mkdir("printout/routing slip");
	}

	if(file_exists("c:/routing slip/dotc.jpg")){
		
	
	}
	else {
		copy("dotc.jpg","c:/routing slip/dotc.jpg");
	
	}
	
	
	$folder="c:/routing slip/";
	
	$_SESSION['file']=$folder."Routing Print Out, ".$ref_no.".xls";
	require("new routing printout.php");
	//$fp=fopen($file,'w+');
	//fwrite($fp,$_SESSION['printContent']);
	//fclose($fp);
	copy($_SESSION['file'],"printout/routing slip/Routing Print Out, ".$ref_no.".xls");
	echo "A Print Out has been generated!  Press right click and Save As: <a href='printout/routing slip/Routing Print Out, ".$ref_no.".xls'>Here</a>";
}
else {
?>
<input type=button value="Confirm to Print Out" onclick='openPage("print_outline.php?print=1")' />
<?php
}
}
else if($_SESSION['page']=="end of the month report.php"){
	if($_SESSION['filterDocument']=='SENT'){
		$sentNM=1;
		$unsentNM=0;
		$ordersNM=0;
	}
	else if($_SESSION['filterDocument']=='AWAIT'){
		$sentNM=0;
		$unsentNM=1;
		$ordersNM=0;
	}
	else if($_SESSION['filterDocument']=='ORDER'){
		$sentNM=0;
		$unsentNM=0;
		$ordersNM=1;
	}
	else {
		$sentNM=1;
		$unsentNM=1;
		$ordersNM=1;
	}

$routingHeading="
<table width=100%>
<tr >
<td valign=center align=center rowspan=4>
<img align=center valign=top src='dotc.jpg' height=80 width=80  ></img>
</td>
<td colspan=2 valign=top>
Republic of the Philippines
</td>
</tr>
<tr>
<td colspan=2><b>DEPARTMENT OF TRANSPORTATION AND COMMUNICATIONS</b></td>
<td valign=top align=center>(Always Attach this Form to All Communications)</td>
</tr>
<tr>
<td >
METRO RAIL TRANSIT III EDSA LINE (DOTC-MRT3)
</td>
<td >
&nbsp;</td>
</tr>

</table>";

echo $routingHeading;

	$headingTable="<br>
	<table align=center border=1 width=100%>
	<tr><th colspan=2><h2>END OF THE MONTH REPORT</h2></th>
	</tr>
	</table>";	
	echo $headingTable;
		$sentClause=" (status in ('SENT','FORWARDED') or status like '%CLOSED%%') ";
		if(isset($_SESSION['sentClause'])){ $sentClause=$_SESSION['sentClause']; }
		if(isset($_SESSION['sentMonth'])){
			$month=date("m",strtotime($_SESSION['sentYear']."-".$_SESSION['sentMonth']));
			$dateClause="  and receive_date like '%".$_SESSION['sentYear']."-".$month."%%'";

			$year=$_SESSION['sentYear'];
		}
		else {
			if(isset($_SESSION['filterMonth'])){
				$filterMonth=$_SESSION['filterMonth'];
				$filterYear=$_SESSION['filterYear'];
				$dateClause=" and receive_date like '%".$_SESSION['filterYear']."-".date("m",strtotime($_SESSION['filterYear']."-".$_SESSION['filterMonth']))."%%'";
				$month=$filterMonth;
				$year=$filterYear;
			}
			else {
				$dateClause=" and receive_date like '%".date("Y")."-".date("m")."%%'";
				$month=date("m");
				$year=date("Y");
			}
		}
		
		
		
		$db=retrieveRecordsDb();
		$sql="select * from document where ".$sentClause." ".$dateClause." order by receive_date desc";

		$rs=$db->query($sql);
		$nm=$rs->num_rows;
		
		if($sentNM==0){
			$nm=$sentNM;
		}
	if(($nm>0)||(($nm==0)&&(($_SESSION['filterDocument']=="SENT")||($_SESSION['filterDocument']=="ALL")))){
		?>
		<br>
	<table id='cssTable' border=1 width=100% >
	<tr>
	<th colspan=6><h2>Documents Sent This Month</h2></th>
	</tr>

	<tr>
		<th>Originating Office</th>
		<th>Subject</th>
		<th>Reference Number</th>
		<th>Document Type</th>
		<th>Document Date</th>
		<th>Last Status</th>	
	</tr>	
	<?php
		for($i=0;$i<$nm;$i++){
		$row=$rs->fetch_assoc();
	?>	
	<tr>
		<td><?php echo getOriginatingOffice($db, $row['originating_office']); ?></td>
		<td><?php echo $row['subject']; ?></td>
		<td><?php echo calculateReferenceNumber($db,$row,adjustControlNumber($row['ref_id'])); ?></td>
		<td><?php echo $row['document_type']; ?></td>
		<td><?php echo date("Y-m-d", strtotime($row['document_date'])); ?></td>
		<td><?php echo $row['status']; ?></td>

	</tr>
	<?php
		}
	?>
	</table>
<?php
	}

		$db=retrieveRecordsDb();
		
	//	$month=$_SESSION['filterMonth'];
	//	$year=$_SESSION['filterYear'];
		
		$awaitClause=" status in ('INCOMPLETE','FOR: ROUTING','AWAITING REPLY','FOR: CLARIFICATION','FOR: GM APPROVAL') ";
		if(isset($_SESSION['awaitClause'])){ $awaitClause=$_SESSION['awaitClause']; }

		if(isset($_SESSION['awaitMonth'])){
			$dateClause="  and receive_date like '%".$_SESSION['awaitYear']."-".$_SESSION['awaitMonth']."%%'";
			$month=date("m",strtotime($_SESSION['awaitYear']."-".$_SESSION['awaitMonth']));
			$year=$_SESSION['awaitYear'];
		}
		else {
			if(isset($_SESSION['filterMonth'])){
				$filterMonth=$_SESSION['filterMonth'];
				$filterYear=$_SESSION['filterYear'];
				$dateClause=" and receive_date like '%".$_SESSION['filterYear']."-".date("m",strtotime($_SESSION['filterYear']."-".$_SESSION['filterMonth']))."%%'";
				$month=$filterMonth;
				$year=$filterYear;
			}
			else {
				$dateClause=" and receive_date like '%".date("Y")."-".date("m")."%%'";
				$month=date("m");
				$year=date("Y");
			}
		}
		$sql="select * from document where ".$awaitClause."  ".$dateClause." order by receive_date desc";

		$rs=$db->query($sql);
		$nm=$rs->num_rows;


		if($unsentNM==0){
			$nm=$unsentNM;
		}
		
		if(($nm>0)||(($nm==0)&&(($_SESSION['filterDocument']=="AWAIT")||($_SESSION['filterDocument']=="ALL")))){
	?>
<br>
	<table id='cssTable' border=1 width=100% >
	<tr>
	<th colspan=6><h2>Documents Still Awaiting Reply/Unsent This Month</h2></th>
	</tr>

	<tr>
		<th>Originating Office</th>
		<th>Subject</th>
		<th>Reference Number</th>
		<th>Document Type</th>
		<th>Document Date</th>
		<th>Last Status</th>	
	</tr>	
	<?php

		for($i=0;$i<$nm;$i++){
		$row=$rs->fetch_assoc();
	?>	
	<tr>
		<td><?php echo getOriginatingOffice($db, $row['originating_office']); ?></td>
		<td><?php echo $row['subject']; ?></td>
		<td><?php echo calculateReferenceNumber($db,$row,adjustControlNumber($row['ref_id'])); ?></td>
		<td><?php echo $row['document_type']; ?></td>
		<td><?php echo date("Y-m-d", strtotime($row['document_date'])); ?></td>
		<td><?php echo $row['status']; ?></td>

	</tr>
	<?php
		}
	?>
	</table>	
	<?php
	}

$db=retrieveRecordsDb();
	
	$orderClause=" and status in ('ISSUED AND SENT','ISSUED') ";
	if(isset($_SESSION['orderClause'])){ $orderClause=$_SESSION['orderClause']; }
	if(isset($_SESSION['orderMonth'])){
		$dateClause="  and receive_date like '%".$_SESSION['orderYear']."-".$_SESSION['orderMonth']."%%'";
		$month=date("m",strtotime($_SESSION['orderYear']."-".$_SESSION['orderMonth']));
		$year=$_SESSION['orderYear'];
	
	
	}
	else {
		if(isset($_SESSION['filterMonth'])){
			$filterMonth=$_SESSION['filterMonth'];
			$filterYear=$_SESSION['filterYear'];
			$dateClause=" and receive_date like '%".$_SESSION['filterYear']."-".date("m",strtotime($_SESSION['filterYear']."-".$_SESSION['filterMonth']))."%%'";
			$month=$filterMonth;
			$year=$filterYear;
		}
		else {
			$dateClause=" and receive_date like '%".date("Y")."-".date("m")."%%'";
			$month=date("m");
			$year=date("Y");
		}
	}
	
	$sql="select * from document where document_type='ORD' ".$orderClause." ".$dateClause;
	$rs=$db->query($sql);
	
	$nm=$rs->num_rows;
	if($ordersNM==0){
		$nm=$ordersNM;
	}
		if(($nm>0)||(($nm==0)&&(($_SESSION['filterDocument']=="ORDER")||($_SESSION['filterDocument']=="ALL")))){
	?>
	<br>

	<table id='cssTable' border=1 width=100% >
	<tr>
	<th colspan=5><h2>Office Orders Issued This Month</h2></th>
	</tr>
	<tr>
	<th>Subject</th>
	<th>Classification</th>
	<th>Document Date</th>
	<th>Originating Office</th>
	<th>Last Status</th>
	</tr>
	<?php

	for($i=0;$i<$nm;$i++){
		$row=$rs->fetch_assoc();
	?>
	<tr>
		<td><?php echo $row['subject']; ?></td>
		<td>Office Order</td>
		<td><?php echo date("Y-m-d h:ia",strtotime($row['document_date'])); ?></td>
		<td><?php echo getOriginatingOffice($db,$row['originating_office']); ?></td>
		<td><?php echo $row['status']; ?></td>
	</tr>
	<?php
	}
	?>
	</table>
	<?php
	}
	if(isset($_GET['print'])){

	$fileName="End of the Month Report ";
	$fileName.=date("Y-m-d").".xls";
	
	$excel=startCOMGiven();

	if(is_dir("c:/report/")){
	}
	else {
		mkdir("c:/report/");
	}

	if(is_dir("printout/report/")){
	}
	else {
		mkdir("printout/report/");
	}

		
	// $workSheetName="Monthly Summary";
	// $workbookname=$folder.$fileName;

//	echo "A Print Out has been generated!  Press right click and Save As: <a href='".$_SESSION['file']."'>Here</a>";
	$verify=fileExists($workbookname);
	if($verify=="true"){
		deleteFile($workbookname);
	}

	if(file_exists("c:/report/dotc.jpg")){
	}
	else {
		copy("dotc.jpg","c:/report/dotc.jpg");
	
	}
	
	$folder="c:/report/";
	
	$_SESSION['file']=$folder.$fileName;
	require("new report printout.php");
	copy($_SESSION['file'],"printout/report/".$fileName);
	echo "A Print Out has been generated!  Press right click and Save As: <a href='printout/report/".$fileName."'>Here</a>";
	
	
	}
	else {
	?>
	<br>
	<div align=center><input type=button value='Generate Print Out' onclick='openPage("print_outline.php?print=1")' /></div>
	<br>

	<?php
	}
}	
 ?>
