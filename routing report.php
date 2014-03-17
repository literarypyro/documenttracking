<?php
session_start();
?>
<?php
/** Online Routing Slip
*
* This page lists all the Routing ever done in a document.  It describes the flow and 
* tracks the document as it is passed from source to destination
*
* @author Patrick Simon Silva
* @version 2.0
* @package routingReport
*/
?>
<?php
	require("db_page.php");
	require("functions/routing process.php");
	require("functions/general functions.php");
	require("functions/document functions.php");
	
	$mainPageMessage="This page will reload to the main page after 5 mins.";
	require("title.php");
//	require("header.php");
	$_SESSION['page']="routing report.php";
?>
	<script language="javascript">
	function openPrint(url){
		window.open(url);
	
	}
	</script>

	<link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="justified-nav.css" rel="stylesheet">	
	<style type="text/css">
	thead th{
		text-align:center;
	}
	.col-md-4 {
		float:right;
		
		
	}
	.container {
		width:50%;
		margin-left:10%;
	}
	legend {
		text-align:center;
	
	}
	</style>
	<meta http-equiv="refresh" content="300;url=receiveDocument.php" />
	<!--
	<LINK href="css/program design 2.css" rel="stylesheet" type="text/css">
	-->
	
<!--
	style="background-image:url('body background.jpg');"
-->
	<body >
	<div align=right><a href='receiveDocument.php'>Go Back to Main Page</a></div>
	<div align=left ></div>
	<br>
	<div align=right><input type=button class='btn btn-info' value='Prepare Print Out' onclick='openPrint("print_outline.php")' /></div>

	<!--Heading Table-->
	<?php 
	$headingTable="
	<table align=center width=100%>
	<tr>";
	$a=$a;

	if(($_SESSION['document_type']=='IN')||($_SESSION['document_type']=='MEMO')){
	$headingTable.="	
		<th colspan=2><h3>INTERACTIVE ROUTING (INTERNAL/INCOMING)</h3></th>";
	}
	else {
	$headingTable.="	
		<th colspan=2><h3>INTERACTIVE ROUTING (OUTGOING)</h3></th>";
	}
	$headingTable.="	
	</tr>
	</table>";	

	$db=retrieveRecordsDb();  // retrieved from db_page
	
	$ref_no=getDocumentId($db,$_SESSION['reference_number']); // retrieved from functions/document functions
	//Record the accessing of this page
	recordDocumentAccess($db,$ref_no,$_SESSION['username'],$_SESSION['department']); // retrieved from functions/document functions
	
	$row=getDocumentDetails($db,$ref_no); // retrieved from functions/document functions
	$dStatus=$row['status'];
	$referenceLabel=$_SESSION['reference_number'];
	
	
	//Document Details for Below
	$originating_office=getOriginatingOffice($db,$row['originating_office']); // retrieved from functions/general functions
	$document_type=$row['document_type'];
	$receive_date=date("F d, Y, H:iA",strtotime($row['receive_date']));
	$document_date=date("F d, Y, H:iA",strtotime($row['document_date']));
	$subject=$row['subject'];

	$routing_id=$ref_no;
	$headingTable.="	
	<table  width=100%>
	<tr width=100%>
		<td width=50%>&nbsp;</td>
		<td width=50% align=right>Reference Number: ".$referenceLabel."</td>
	</tr>
	</table>";
	echo $headingTable;
	?>
	<!--Heading Table-->
	
	<!--Document Details Table-->
	<?php
	$documentDetailsTable="
	<table id='csstable'  class='table table-striped table-bordered' border=1 width=100%>
	<tr>
		<th colspan=2 >ORIGINATING OFFICE</th>
		<th colspan=2>".$originating_office."</th>
	</tr>
	<tr>
		<td colspan=2 valign=center rowspan=2><b>Subject: ".$subject."</b></td>
		<td colspan=2><b>Date of Document: </b>".$document_date."</td>
	</tr>
	<tr>
		<td colspan=2>
			<b>Date/Time";  
		if($document_type=="OUT"){
		$documentDetailsTable.="
			Sent for Approval: "; 
		}
		else {
		$documentDetailsTable.="
			Received:  ";
		}	
		$documentDetailsTable.="
			</b>".$receive_date."
		</td>

	</tr>
	</table>";
	echo $documentDetailsTable;

	?>
	<!-- Document Details Table -->
	
	<!-- Link -->
	<a href='download.php?refId=<?php echo $routing_id; ?>' target='window'>Click here to download Document</a>
	<br>
	<br>
	<!-- Link -->


	<!-- Actions Table -->
	<?php 
	$actionTable="	
	<table id='csstable' class='table table-striped table-bordered table-hover' border=1 width=100%>
	<thead>
	<tr>
		<th colspan=6><h3>ACTION/S UNDERTAKEN</h3></th>
	</tr>
	<tr>
		<th>DATE/TIME</th>
		<th align=center><b>FROM</b><br>Position and Name of<br> Official/Signature</th>
		<th align=center><b>TO</b><br>Position and Name of<br> Official/Signature</th>
		<th>REQUEST/ACTION</th>
		<th>ADDITIONAL REMARKS/ATTACHMENTS</th>
		<th>Status</th>
	</tr>
	</thead>
	";

	$db=retrieveRecordsDb(); //retrieved from db_page
	$rs=getRoutingActions($db,$ref_no);	 //retrieved from functions/routing process
	$nm=$rs->num_rows;
	for($a=0;$a<$nm;$a++){
		$row=$rs->fetch_assoc();
		
		//For From Officer
		
		if($row['from_name']=="OTHER"){
			$officer_name=$row['alter_from'];
			$officer_position=$row['alter_position'];
		
		}
		else {
			$row2=getOfficer($db,$row['from_name']);
			$officer_name=$row2['name'];
			$officer_position=$row2['position'];
		}
		//For Targets
		$rs2=getRoutingTargets($db,$row['id']); //retrieved from functions/routing process
		$nm2=$rs2->num_rows;
		
		for($i=0;$i<$nm2;$i++){
		
			$row2=$rs2->fetch_assoc();
			//$to_caption.=", ".$row2['destination_office'];		

			//For From Officer
			
			if($row2['destination_office']=="ALL"){
				$officer_name2="ALL DIVISIONS";
				$officer_position2="";
			}
			else {
				if($row2['to_name']=="OTHER"){
					$officer_name2=$row2['alter_to'];	
					$officer_position2=$row2['alter_position'];
				}
				else {
					$row3=getOfficer($db,$row2['to_name']); // retrieved from functions/general functions
					$officer_name2=$row3['name'];
					$officer_position2=$row3['position'];
				}	
			}

			$link=getRoutingUpload($db,$row2['id']); // retrieved from functions/routing process
			$action=getAction($db,$row2['action_id']); // retrieved from functions/routing process
			$actionStatus=$row2['status'];
			if(($link=="uploads/others/routing_uploads/")||($link=="")){
				$remark=$row2['remarks'];
				
			}
			else {
				$remark=" <a href=\"".$link."\" target='window'  >[Click here for attachment]</a>".", ".$row2['remarks'];
			}
			
			
	$actionTable.="
	<tbody>
	<tr>
		<td valign=center>".date("F d, Y h:ia",strtotime($row['request_date']))."<br></td>
		<td align=center>".strtoupper($officer_name)."<br>".$officer_position."</td>
		<td align=center>".strtoupper($officer_name2)."<br>".$officer_position2."</td>
		<td align=center>".$action."</br></td>	
		<td align=center>".$remark."</br></td>	
		<td align=center>".$actionStatus."</br></td>	
	</tr>";
			if($i==(($nm2*1)-1)){
				$lastDestination=$row['from_office'];
			}

		}
	
	}
	$actionTable.="
	</tbody>
	</table>";
	echo $actionTable;

	?>

	<!--Actions Table-->
	
	<!-- Actions to Make Table -->
	<div class='container col-centered'>
	<div class='well col-md-4'>
	<form action='submit.php' method='post'>
	<legend>Select Action</legend>
	<div class='form-inline'>
	<div class='form-group'>
	<select class='form-control' name='interaction'>
		<option value='ADD'>Add New Action</option>
		<?php
		if($lastDestination==$_SESSION['department']){
		?>
			<option value='DEL'>Remove Last Action</option>
		<?php
		}
		?>
	</select>
	</div>
	<div class='form-group'>
	
	<input class='btn btn-primary' type=submit value='Submit'>
	</div>
	</div>
	</form>
	</div>
	</div>
	<?php
	$_SESSION['printOut']=$documentDetailsTable."<br>".$actionTable;
	?>
	<!-- Actions to Make Table -->
	</body>
