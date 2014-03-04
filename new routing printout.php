<?php
session_start();
?>
<?php

/* require("functions/excel functions.php");
require("functions/routing process.php");
require("functions/general functions.php");
require("functions/form functions.php");
require("functions/document functions.php");
require("db_page.php"); */

?>
<?php
//Create the Object
$workSheetName="Records";
$workbookname=$_SESSION['file'];
//$workbookname="C:/testing 2.xls";
$excel=startCOMGiven();

$verify=fileExists($_SESSION['file']);
if($verify=="true"){
	unlink($_SESSION['file']);
}

//$ExWb=createWorkbook($excel,$workbookname,"create");
$ExWs=createWorksheet($excel,$workSheetName,$ExWb,"create");


//Create the Header
//addImage(setRange("a1","b6"),$excel,"c:/routing slip/records picture2.jpg","true",$ExWs);

addContent(setRange("a1","b6"),$excel,"","true",$ExWs);

//LEFT SIDE
styleCellArea(setRange("c3","g3"),"true","false",$ExWs,$excel);
styleCellArea(setRange("c4","g4"),"true","false",$ExWs,$excel);

addContent(setRange("c2","g2"),$excel,"Republic of the Philippines","true",$ExWs);
addContent(setRange("c3","g3"),$excel,"DEPARTMENT OF TRANSPORTATION","true",$ExWs);
addContent(setRange("c4","g4"),$excel,"AND COMMUNICATION","true",$ExWs);
addContent(setRange("c5","g5"),$excel,"METRO RAIL TRANSIT III EDSA LINE","true",$ExWs);
addContent(setRange("c6","g6"),$excel,"(DOTC-MRT3)","true",$ExWs);

//RIGHT SIDE
styleCellArea(setRange("h3","j3"),"true","false",$ExWs,$excel);

addContent(setRange("h3","j3"),$excel,"ROUTING/ACTION SLIP","true",$ExWs);
addContent(setRange("h4","j4"),$excel,"(Please Attach this form","true",$ExWs);
addContent(setRange("h5","j5"),$excel,"To All Communications)","true",$ExWs);

$db=retrieveRecordsDb();
$ref_no=getDocumentId($db,$_SESSION['reference_number']);

$row=getDocumentDetails($db,$ref_no);
$dStatus=$row['status'];
$referenceLabel=$_SESSION['reference_number'];

$originating_office=getOriginatingOffice($db,$row['originating_office']);
$document_type=$row['document_type'];
$receive_date=date("F d, Y, h:iA",strtotime($row['receive_date']));
$document_date=date("F d, Y, h:iA",strtotime($row['document_date']));
$subject=$row['subject'];


//Readying document Details
addContent(setRange("g9","j9"),$excel,"Reference Number:".$_SESSION['reference_number'],"true",$ExWs);
styleCellArea(setRange("a10","d10"),"true","true",$ExWs,$excel);
styleCellArea(setRange("a11","d12"),"false","true",$ExWs,$excel);
styleCellArea(setRange("e10","j10"),"true","true",$ExWs,$excel);
styleCellArea(setRange("e11","j11"),"false","true",$ExWs,$excel);
styleCellArea(setRange("e12","j12"),"false","true",$ExWs,$excel);

addContent(setRange("a10","d10"),$excel,"ORIGINATING OFFICE","true",$ExWs);
addContent(setRange("a11","d12"),$excel,"Subject: ".$subject,"true",$ExWs);

addContent(setRange("e10","j10"),$excel,$originating_office,"true",$ExWs);
addContent(setRange("e11","j11"),$excel,"Date of Document: ".$document_date,"true",$ExWs);
addContent(setRange("e12","j12"),$excel,"Receive Date/Time: ".$receive_date,"true",$ExWs);

styleCellArea(setRange("a14","j14"),"true","true",$ExWs,$excel);
styleCellArea(setRange("a15","b17"),"true","true",$ExWs,$excel);
styleCellArea(setRange("c15","e17"),"true","true",$ExWs,$excel);
styleCellArea(setRange("f15","h17"),"true","true",$ExWs,$excel);
styleCellArea(setRange("i15","j17"),"true","true",$ExWs,$excel);

addContent(setRange("a14","j14"),$excel,"Actions Taken","true",$ExWs);
$excel->getActiveSheet()->getStyle("A14:J14")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

addContent(setRange("a15","b17"),$excel,"DATE/TIME","true",$ExWs);
$excel->getActiveSheet()->getStyle("A15:B17")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

addContent(setRange("c15","e17"),$excel,"FROM\nName and Position\n Official/Signature","true",$ExWs);
$excel->getActiveSheet()->getStyle("C15:E17")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

addContent(setRange("f15","h17"),$excel,"TO\nName and Position\n Official/Signature","true",$ExWs);
$excel->getActiveSheet()->getStyle("F15:H17")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

addContent(setRange("i15","j17"),$excel,"ADDITIONAL REMARKS","true",$ExWs);
$excel->getActiveSheet()->getStyle("I15:J17")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

//To get the latest Actions
$rs=getRoutingActions($db,$ref_no);	
$nm=$rs->num_rows;
for($i=0;$i<$nm;$i++){
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
	$sql2="select * from routing_targets where routing_id='".$row['id']."'";
	$rs2=$db->query($sql2);
	$nm2=$rs2->num_rows;
	
	
	for($m=0;$m<$nm2;$m++){
		
		$row2=$rs2->fetch_assoc();
	
	
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
				$row3=getOfficer($db,$row2['to_name']);
				$officer_name2=$row3['name'];
				$officer_position2=$row3['position'];
			}	
		}
		$action=getAction($db,$row2['action_id']);
		$actionStatus=$row2['status'];

		$rowNumber=18*1+$m;

		$fromOfficer[0]="c".$rowNumber;
		$fromOfficer[1]="d".$rowNumber;

		$toOfficer[0]="e".$rowNumber;
		$toOfficer[1]="f".$rowNumber;
		styleCellArea(setRange("a".$rowNumber,"b".$rowNumber),"false","true",$ExWs,$excel);
		styleCellArea(setRange("c".$rowNumber,"e".$rowNumber),"false","true",$ExWs,$excel);
		styleCellArea(setRange("f".$rowNumber,"h".$rowNumber),"false","true",$ExWs,$excel);
		styleCellArea(setRange("i".$rowNumber,"j".$rowNumber),"false","true",$ExWs,$excel);

		$excel->getActiveSheet()->getRowDimension($rowNumber)->setRowHeight(50);
		$excel->getActiveSheet()->getRowDimension($rowNumber)->setRowHeight(50);
//		setCellSize($fromOfficer,"50","8.43",$ExWs,$excel);
//		setCellSize($toOfficer,"50","8.43",$ExWs,$excel);
		
		addContent(setRange("a".$rowNumber,"b".$rowNumber),$excel,date("F d, Y h:ia",strtotime($row['request_date'])),"true",$ExWs);
		addContent(setRange("c".$rowNumber,"e".$rowNumber),$excel,"\n\n".strtoupper($officer_name)."\n".$officer_position,"true",$ExWs);
		addContent(setRange("f".$rowNumber,"h".$rowNumber),$excel,"\n\n".strtoupper($officer_name2)."\n".$officer_position2,"true",$ExWs);
		addContent(setRange("i".$rowNumber,"j".$rowNumber),$excel,$row2["remarks"],"true",$ExWs);

	 }	
}
save($ExWb,$excel,$workbookname);








?>
