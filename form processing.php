<?php
session_start();
?>
<?php
	require('db_page.php');
	if($_SESSION['page']=="login.php"){
		require("functions/user functions.php");
		$db=retrieveUsersDb(); 
		if(isset($_POST['username'])){
			$sql="select * from users where username='".$_POST['username']."' and password='".$_POST['password']."'";
			$rs=$db->query($sql);
			$nm=$rs->num_rows;
				
			if($nm>0){
				if(checkLog($_POST['username'],$db)>0){
				echo "Security error. User has already logged in.";	
				echo '<meta http-equiv="refresh" content="3;url=login.php" />';

				}
				else {
			
				$row=$rs->fetch_assoc();	
				$_SESSION['name']=$row['lastName'].", ".$row['firstName'];
				$_SESSION['username']=$row['username'];
				$_SESSION['department']=$row['deptCode'];

				if($row['deptCode']=='REC'){
					$verify="select * from records_officer where username='".$row['username']."' and active='true'"; 
					$rsVerify=$db->query($verify);
					$nmVerify=$rsVerify->num_rows;
					if($nmVerify==0){
						echo "Sorry. Backup account is currently disabled";	
						echo '<meta http-equiv="refresh" content="1;url=login.php" />';

					}
					else {
						echo "Redirecting to Main Page, hold on...";
//						header("Location: receiveDocument.php");	
						loginUser($db,$_SESSION['username']);
						echo '<meta http-equiv="refresh" content="1;url=receiveDocument.php" />';
					}
				}	
				else {
					echo "Redirecting to Main Page, hold on...";
//					header("Location: receiveDocument.php");	
					loginUser($db,$_SESSION['username']);
					echo '<meta http-equiv="refresh" content="1;url=receiveDocument.php" />';

				}	
				}
			}
			else {
				echo "Invalid login credentials.  Please check your password or create new account.";	
				echo '<meta http-equiv="refresh" content="3;url=login.php" />';
			}
		}		
		else {
			header("Location: ".$_SESSION['page']);
		}

	}
	else if($_SESSION['page']=="createAccount.php"){
		require("functions/user functions.php");
		$db=retrieveUsersDb();
		if(isset($_POST['userName'])){
			if($_POST['password']==$_POST['repassword']){
				$eval=checkDepartmentAvailability($db,$_POST['department'],$_POST['phrase']);
				if($eval=="Okay to proceed"){
					$credentials[0]=$_POST['department'];
					$credentials[1]=$_POST['userName'];
					$credentials[2]=$_POST['password'];
					$credentials[3]=$_POST['firstName'];
					$credentials[4]=$_POST['lastName'];

					if($credentials[0]=="REC"){
						addRecordsOfficer($db,$credentials);
						echo "User has been added.  Redirecting...";
						echo '<meta http-equiv="refresh" content="3;url=login.php" />';
					}
					else {
						addUser($db,$credentials);
						echo "User has been added.  Redirecting...";
						echo '<meta http-equiv="refresh" content="3;url=login.php" />';
					}
				}
				else {
					echo $eval;
					echo '<meta http-equiv="refresh" content="3;url=login.php" />';
				}
			}
			else {
				echo "Error.  Please reverify your password.";
				echo '<meta http-equiv="refresh" content="3;url=login.php" />';
			}
		}
		else {
			header("Location: ".$_SESSION['page']);
		}


	}
	else if($_SESSION['page']=="createDocument.php"){
		require("functions/document functions.php");
		require("functions/general functions.php");
		require("functions/routing process.php");

		if(isset($_POST['receive_date'])){
		$db=retrieveRecordsDb();
		//For the Classification

		if($_POST['class_list']=="5"){
			$classId=$_POST['classification'];
		}
		else{
			$classId=$_POST['class_list'];
		}
		
		//For the Originating Office
		if($_POST['originating_office']=="13"){
			$origoffice=$_POST['origInput'];
		}
		else {

			$origoffice=$_POST['originating_office'];
		}

		if($_POST['originating_officer']=="OTHER"){
			$origOfficer=$_POST['alterOfficer'];
		}
		else {

			$origOfficer=$_POST['originating_officer'];
		}		
		
		
		
		
		
		$receiveHour=0;
		$receiveMinute=0;
		$receiveMinute=$_POST['receiveMinute'];

		$receiveHour=adjustTime($_POST['amorpm'],$_POST['receiveHour']);
		$receiveDay=date("Y-m-d",strtotime($_POST['receive_date']));
		
		//$receiveDay=$_POST['receiveYear']."-".$_POST['receiveMonth']."-".$_POST['receiveDay'];
		$received_date=$receiveDay." ".$receiveHour.":".$receiveMinute.":00";


		$documentHour=0;
		$documentMinute=0;
	
		$documentMinute=$_POST['documentMinute'];
		$documentHour=adjustTime($_POST['docamorpm'],$_POST['documentHour']);

		$selectDay=date("Y-m-d",strtotime($_POST['document_date']));
		
		$selectDate=$selectDay." ".$documentHour.":".$documentMinute.":00";
		$incrementId=retrieveIncrement($db);
		
		$details[0]=$_POST['doc_subject'];
		$details[1]=$selectDate;
		$details[2]=$_POST['document_type'];
		$details[3]=$origOfficer;
		$details[4]=$received_date;
		$details[5]=$_SESSION['department'];
		$details[6]=$_POST['security'];
		$details[7]=$incrementId;

		$docId=createNewDocument($db,$classId,$origoffice,$details);
		$chronId=adjustControlNumber($docId);
		
		echo "Database has been updated! Redirecting...<br>";
		$_SESSION['documentCreated']=$docId; 

		//Reference Number will no longer be session-based, but implied based on Receive Time.	
 		echo '<meta http-equiv="refresh" content="2;url=uploadDocument.php" />';

		}
		else {
			header("Location: ".$_SESSION['page']);	
		} 
	}
	else if($_SESSION["page"]=="uploadDocument.php"){
		//Possibility of being able to get a log of all users who viewed your documents?
	 	require("functions/document functions.php");
		require("functions/general functions.php");
		require("functions/routing process.php");
		if(isset($_FILES['document'])){
			if(basename($_FILES['document']['name'])!==""){
			
			
				$db=retrieveRecordsDb();
				$row=getDocumentDetails($db,$_POST['docId']);
				 
				$origOffice=getOriginatingOffice($db,$row['originating_office']);
				
				$blank="";
				$path=$blank.(basename($_FILES['document']['name']));
				
				$documentLink=prepareUpload($documentType,$row['sending_office'],$row['security'],$path,$origOffice);

				$uploadLink=uploadDocument($_FILES['document']['tmp_name'],$documentLink);

				if($uploadLink=="Transfer was successful."){
					echo $uploadLink;
					echo "<br>";
					
					$receiveHour=0;
					$receiveMinute=0;
					$receiveHour=adjustTime($_POST["amorpm"],$_POST["receiveHour"]);

					//$receiveDay=$_POST['receiveYear']."-".$_POST['receiveMonth']."-".$_POST['receiveDay'];
					$receiveDay=date("Y-m-d",strtotime($_POST['receive_date']));
					
					$receiveMinute=$_POST['receiveMinute'];
					$received_date=$receiveDay." ".$receiveHour.":".$receiveMinute.":00";

					//ref ID
					//Time
					//Doc Id
					//Link
					
					$referenceNumber=$_POST['reference_number'];
					$link=$documentLink;
					$receiveTime=$received_date;
					$documentId=$_POST['docId'];		
					
					$receiveDetails[0]=$referenceNumber;
					$receiveDetails[1]=$receiveTime;
					$receiveDetails[2]=$documentId;
					$receiveDetails[3]=$link;
							
					
					receiveDocument($db,$receiveDetails);
					
					
					$uploadDetails[0]=$referenceNumber;
					$uploadDetails[1]=$link;
				
					
					addUpload($db,$uploadDetails);
					
					
					//Upload Status
					if($row['document_type']=="ORD"){
						$uploadStat="ISSUED";
					}
					else if($row['document_type']=="OUT"){
						if($row['security']=="GMsecured"){
							$uploadStat="FOR: GM APPROVAL";
							
						}
						else {
							$uploadStat="SENT";
						}
						
					}
					else {
						$uploadStat="FOR: ROUTING";
					}
				
					updateDocumentStatus($db,$uploadStat,getDocumentId($db,$referenceNumber));
					echo "The document has been confirmed.";

	//				if(($row['document_type']=="ORD")||($row['document_type']=="OUT")){
					if($row['document_type']=="OUT"){
					
						$msg="outgoing";
						$filename  = "data/OGM.txt";
						// store new message in the file
						file_put_contents($filename,$msg);

					
						echo '<meta http-equiv="refresh" content="3;url=receiveDocument.php" />';
					}
					else {
						echo "<br>Proceeding to Routing Page.  Please hold on...";
						echo '<meta http-equiv="refresh" content="3;url=routing report.php" />';
						$_SESSION['reference_number']=$referenceNumber;
					}
				} 
				else{
					echo $uploadLink;
					echo '<meta http-equiv="refresh" content="15;url=uploadDocument.php" />';
				}
			}
			else {
				$db=retrieveRecordsDb();
				$row=getDocumentDetails($db,$_POST['docId']);
				 
				$origOffice=getOriginatingOffice($db,$row['originating_office']);			
			
					$receiveHour=0;
					$receiveMinute=0;
					$receiveHour=adjustTime($_POST["amorpm"],$_POST["receiveHour"]);

//					$receiveDay=$_POST['receiveYear']."-".$_POST['receiveMonth']."-".$_POST['receiveDay'];
					$receiveDay=date("Y-m-d",strtotime($_POST['receive_date']));



					$receiveMinute=$_POST['receiveMinute'];
					$received_date=$receiveDay." ".$receiveHour.":".$receiveMinute.":00";

					//ref ID
					//Time
					//Doc Id
					//Link
					
					$referenceNumber=$_POST['reference_number'];
					$link=$documentLink;
					$receiveTime=$received_date;
					$documentId=$_POST['docId'];		
					
					$receiveDetails[0]=$referenceNumber;
					$receiveDetails[1]=$receiveTime;
					$receiveDetails[2]=$documentId;
					$receiveDetails[3]=$link;
							
					
					receiveDocument($db,$receiveDetails);
					if($row['document_type']=="ORD"){
						$uploadStat="ISSUED";
					}
					else if($row['document_type']=="OUT"){
						if($row['security']=="GMsecured"){
							$uploadStat="FOR: GM APPROVAL";
							
						}
						else {
							$uploadStat="SENT";
						}
						
					}
					else {
						$uploadStat="FOR: ROUTING";
					}
				
					updateDocumentStatus($db,$uploadStat,getDocumentId($db,$referenceNumber));
					echo "The document has been confirmed.";

	//				if(($row['document_type']=="ORD")||($row['document_type']=="OUT")){
					if($row['document_type']=="OUT"){
					
						$msg="outgoing";
						$filename  = "data/OGM.txt";
						// store new message in the file
						file_put_contents($filename,$msg);

					
						echo '<meta http-equiv="refresh" content="3;url=receiveDocument.php" />';
					}
					else {
						echo "<br>Proceeding to Routing Page.  Please hold on...";
						echo '<meta http-equiv="refresh" content="3;url=routing report.php" />';
						$_SESSION['reference_number']=$referenceNumber;
					}					
	
			}
		}
		else {
			/**
				$db=retrieveRecordsDb();
				$row=getDocumentDetails($db,$_POST['docId']);
			 
				$origOffice=getOriginatingOffice($db,$row['originating_office']);

				$receiveHour=0;
				$receiveMinute=0;
				$receiveHour=adjustTime($_POST["amorpm"],$_POST["receiveHour"]);

				$receiveDay=$_POST['receiveYear']."-".$_POST['receiveMonth']."-".$_POST['receiveDay'];

				$receiveMinute=$_POST['receiveMinute'];
				$received_date=$receiveDay." ".$receiveHour.":".$receiveMinute.":00";

				//ref ID
				//Time
				//Doc Id
				//Link
				
				$referenceNumber=$_POST['reference_number'];
				$link="";
				$receiveTime=$received_date;
				$documentId=$_POST['docId'];		
				
				$receiveDetails[0]=$referenceNumber;
				$receiveDetails[1]=$receiveTime;
				$receiveDetails[2]=$documentId;
				$receiveDetails[3]=$link;
						
				
				receiveDocument($db,$receiveDetails);
				
				
				$uploadDetails[0]=$referenceNumber;
				$uploadDetails[1]=$link;
			
				
				addUpload($db,$uploadDetails);

				echo '<meta http-equiv="refresh" content="15;url=uploadDocument.php" />';
			*/
			header("Location: ".$_SESSION['page']);
		}

		
	}
	else if($_SESSION["page"]=="routing report.php"){
		$db=retrieveRecordsDb();
		require("functions/document functions.php");
		require("functions/routing process.php");
		if(isset($_POST['interaction'])){
			if($_POST['interaction']=="ADD"){
				header("Location: routingPrepare.php");
				
			}
			else {		
				$refId=getDocumentId($db,$_SESSION['reference_number']);
				deleteLastAction($db,$refId,$_SESSION['department']);		
				header("Location: routing report.php");
				//echo '<meta http-equiv="refresh" content="5;url=routing report.php" />';

			}
			
		}
		else {
			header("Location: routing report.php");
			
		}
	
	}
	else if($_SESSION["page"]=="routingPrepare.php"){
		require("functions/general functions.php");
		require("functions/document functions.php");
		require("functions/routing process.php");
		$db=retrieveRecordsDb();
		$referenceId=getDocumentId($db,$_SESSION['reference_number']);
		
		if(isset($_POST['from_name'])){
			$_SESSION['from_name']=$_POST['from_name'];
		}
	
		if(isset($_POST['from_name'])){
			$detailsRow=getDocumentDetails($db,$referenceId);
			$receiveHour=0;
			$receiveMinute=0;
			
			$receiveHour=adjustTime($_POST['amorpm'],$_POST['receiveHour']);
			$receiveMinute=$_POST['receiveMinute'];
			//$receiveDay=$_POST['receiveYear']."-".$_POST['receiveMonth']."-".$_POST['receiveDay'];

			$receiveDay=date("Y-m-d",strtotime($_POST['receive_date']));
			
			$received_date=$receiveDay." ".$receiveHour.":".$receiveMinute.":00";

			$fr_name[0]=$_POST['from_name'];
			$reference_element=explode(".",$_SESSION['reference_number']);
			$ref_no=$reference_element[2];
			
			$fr_name[1]=$_POST['alterOfficer'];
			$fr_name[2]=$_POST['alterPosition'];
			
			$routingId=addNewRouting($db,$referenceId,$received_date,$_SESSION['department'],$fr_name);
			$routingId=$db->insert_id;
			$_SESSION['routingID']=$routingId;
			if($detailsRow['status']=="FOR: ROUTING"){
			header("Location: addRouting.php");
			}
			else {
			header("Location: addRouting2.php");
			
			}
		}	
		else {
			header("Location: routingPrepare.php");
		
		}


	}
	else if($_SESSION["page"]=="addRouting.php"){
		require("functions/document functions.php");
		require("functions/routing process.php");
		require("functions/general functions.php");	
		$db=retrieveRecordsDb();

		//for updating the document status
		if((isset($_POST['sendToAll']))||(isset($_POST['to_name']))){
			$ref_no=getDocumentId($db,$_SESSION['reference_number']);
	
			$db=retrieveRecordsDb();
			$row=getDocumentDetails($db,$ref_no);
		
			$documentStatus=$row['status'];
			$documentSecurity=$row['security'];
		
			if($documentStatus=="FOR: GM APPROVAL"){
				if($_SESSION['department']=="OGM"){
		
					if($_POST['to_action']=="A"){
						updateDocumentStatus($db,"SENT",$ref_no);		
	//					$documentStatus="SENT";
					}
					else if($_POST['to_action']=="B"){
						updateDocumentStatus($db,"DISAPPROVED",$ref_no);		
	//					$documentStatus="DISAPPROVED";

					}
					else {
						updateDocumentStatus($db,"FOR: CLARIFICATION",$ref_no);		
	//					$documentStatus="FOR: CLARIFICATION";

					}
				}
			}
			else if($documentStatus=="FOR: CLARIFICATION"){
				updateDocumentStatus($db,"FOR: GM APPROVAL",$ref_no);		
	//			$documentStatus="FOR: GM APPROVAL";

			}
			else if($documentStatus=="ISSUED"){
				updateDocumentStatus($db,"ISSUED AND SENT",$ref_no);		
	//			$documentStatus="FOR: GM APPROVAL";

			}

			else if($documentStatus=="FOR: ROUTING"){
				if($documentSecurity=="GMsecured"){
					updateDocumentStatus($db,"FOR: GM APPROVAL",$ref_no);		
	//				$documentStatus="FOR: GM APPROVAL";

				}
				else {
					updateDocumentStatus($db,"SENT",$ref_no);		
	//				$documentStatus="SENT";

				}			
			}
			else {
				updateDocumentStatus($db,"AWAITING REPLY",$ref_no);		
	//			$documentStatus="AWAITING REPLY";

			}
			
			//For readying the Routing Status
			$destinationOffice="";
			$destinationOfficial="";
			$actionMade="";
			
			if(isset($_POST['sendToAll'])){
				$destinationOffice="ALL OFFICERS";
				$destinationOfficial="ALL OFFICERS";
				$actionMade=$_POST['to_action'];
			}
			
			if(isset($_POST['to_name'])){
				$destinationOffice=$_POST["to_department"];
				$destinationOfficial=$_POST['to_name'];
				$actionMade=$_POST['to_action'];
			
			}
			
			if($actionMade=="X"){
				$actionMade=$_POST['other_action'];
			
			}
			

			//For updating the Routing Status
			$to_add[0]=$destinationOffice;
			$to_add[1]=$destinationOfficial;
			$to_add[2]=$actionMade;
			$to_add[4]=$_SESSION['routingID'];
			$to_add[5]=$_POST['remarks'];
			$to_add[6]=$ref_no;
			$to_add[7]=$_POST['alterOfficer'];
			$to_add[8]=$_POST['alterPosition'];

			switch($documentStatus){
				case "AWAITING REPLY":
				$rStatus[0]="ANSWERED";
				$rStatus[1]="PENDING";		
				
				$routing=getRoutingActions($db,$ref_no);
				$routNm=$routing->num_rows;
				for($i=0;$i<$routNm;$i++){
					$row2=$routing->fetch_assoc();
					if($row2["id"]==$_SESSION['routingID']){
					}
					else {
						$updateId=updateRoutingStatus($db,"\"".$_SESSION['department']."\",'ALL OFFICERS'",$rStatus,$row2["id"]);  
					}
				}

				$to_add[3]="PENDING";
				$addId=addRoutingStatus($db,$to_add);
				if(isset($_FILES['routing_file'])){
					$path=$blank.(basename($_FILES['routing_file']['name']));
					$documentLink=prepareUpload("NON","routing_uploads","others",$path,"");
					$uploadLink=uploadDocument($_FILES['routing_file']['tmp_name'],$documentLink);
					linkUpload($db,$addId,$documentLink);


				}

				break;
				
				case "FOR: CLARIFICATION":
				$rStatus[0]="ANSWERED";
				$rStatus[1]="NEEDING CLARIFICATION";		
				
				$routing=getRoutingActions($db,$ref_no);
				$routNm=$routing->num_rows;
				for($i=0;$i<$routNm;$i++){
					$row2=$routing->fetch_assoc();
					if($row2["id"]==$_SESSION['routingID']){
					}
					else {
						$updateId=updateRoutingStatus($db,"\"".$_SESSION['department']."\",'ALL OFFICERS'",$rStatus,$row2["id"]);  

					}
				}
				$to_add[3]="ANSWERED";
				$addId=addRoutingStatus($db,$to_add);
				if(isset($_FILES['routing_file'])){
					$path=$blank.(basename($_FILES['routing_file']['name']));
					$documentLink=prepareUpload("NON","routing_uploads","others",$path,"");
					$uploadLink=uploadDocument($_FILES['routing_file']['tmp_name'],$documentLink);
					linkUpload($db,$addId,$documentLink);


				}
				break;
			
				case "FOR: GM APPROVAL":

					if($actionMade=="A"){
						if($_SESSION['department']=="OGM"){
							$to_add[3]="ANSWERED";
						}
						else {
							$to_add[3]="PENDING";
						
						}

						$addId=addRoutingStatus($db,$to_add);
						if(isset($_FILES['routing_file'])){
							$path=$blank.(basename($_FILES['routing_file']['name']));
							$documentLink=prepareUpload("NON","routing_uploads","others",$path,"");
							$uploadLink=uploadDocument($_FILES['routing_file']['tmp_name'],$documentLink);
							linkUpload($db,$addId,$documentLink);


						}

					}
					else if($actionMade=="B"){
						$rStatus[0]="ANSWERED";
						$rStatus[1]="PENDING";		
						$routing=getRoutingActions($db,$ref_no);
						$routNm=$routing->num_rows;
						for($i=0;$i<$routNm;$i++){
								$row2=$routing->fetch_assoc();
							if($row2["id"]==$_SESSION['routingID']){
							}
							else {
								$updateId=updateRoutingStatus($db,"\"".$_SESSION['department']."\",'ALL OFFICERS'",$rStatus,$row2["id"]);  
							}
						}
			
						if($_SESSION['department']=="OGM"){
						
							$to_add[3]="ANSWERED";
						}
						else {
							$to_add[3]="PENDING";
						
						}
						$addId=addRoutingStatus($db,$to_add);
						if(isset($_FILES['routing_file'])){
							$path=$blank.(basename($_FILES['routing_file']['name']));
							$documentLink=prepareUpload("NON","routing_uploads","others",$path,"");
							$uploadLink=uploadDocument($_FILES['routing_file']['tmp_name'],$documentLink);
							linkUpload($db,$addId,$documentLink);


						}
					}
					else {
						if($_SESSION['department']=="OGM"){
							$to_add[3]="NEEDING CLARIFICATION";
						}
						else {
							$to_add[3]="PENDING";
						}
						$addId=addRoutingStatus($db,$to_add);
						if(isset($_FILES['routing_file'])){
							$path=$blank.(basename($_FILES['routing_file']['name']));
							$documentLink=prepareUpload("NON","routing_uploads","others",$path,"");
							$uploadLink=uploadDocument($_FILES['routing_file']['tmp_name'],$documentLink);
							linkUpload($db,$addId,$documentLink);


						}

					}
				break;
				
				case "SENT":
				$rStatus[0]="ANSWERED";
				$rStatus[1]="PENDING";		
				
				$routing=getRoutingActions($db,$ref_no);
				$routNm=$routing->num_rows;
				for($i=0;$i<$routNm;$i++){
					$row2=$routing->fetch_assoc();
					if($row2["id"]==$_SESSION['routingID']){
					}
					else {
						updateRoutingStatus($db,"\"".$_SESSION['department']."\",'ALL OFFICERS'",$rStatus,$row2["id"]);  
					}
				}

				$to_add[3]="PENDING";
				$addId=addRoutingStatus($db,$to_add);
				if(isset($_FILES['routing_file'])){
					$path=$blank.(basename($_FILES['routing_file']['name']));
					$documentLink=prepareUpload("NON","routing_uploads","others",$path,"");
					$uploadLink=uploadDocument($_FILES['routing_file']['tmp_name'],$documentLink);
					linkUpload($db,$addId,$documentLink);


				}

				break;		

				case "FOR: ROUTING":
				$to_add[3]="PENDING";
				$addId=addRoutingStatus($db,$to_add);
				if(isset($_FILES['routing_file'])){
					$path=$blank.(basename($_FILES['routing_file']['name']));
					$documentLink=prepareUpload("NON","routing_uploads","others",$path,"");
					$uploadLink=uploadDocument($_FILES['routing_file']['tmp_name'],$documentLink);
					linkUpload($db,$addId,$documentLink);
				}
				break;			
				
				case "ISSUED":
				$to_add[3]="ISSUED AND SENT";
				$addId=addRoutingStatus($db,$to_add);
				if(isset($_FILES['routing_file'])){
					$path=$blank.(basename($_FILES['routing_file']['name']));
					$documentLink=prepareUpload("NON","routing_uploads","others",$path,"");
					$uploadLink=uploadDocument($_FILES['routing_file']['tmp_name'],$documentLink);
					linkUpload($db,$addId,$documentLink);


				}

				break;			

				
			}

			header("Location: addRouting.php");
			
		}
		else {

	
			header("Location: addRouting.php");
		
		}
	
	}
	else if($_SESSION["page"]=="receiveDocument.php"){
		require("functions/user functions.php");
		if(isset($_POST["reference_number"])){
			if(isset($_POST['actionToTake'])){
				if($_POST['actionToTake']=="REPLY"){
					$_SESSION['reference_number']=$_POST['reference_number'];
					header("Location: routing report.php");
				}
				else if($_POST['actionToTake']=="FORWARD"){
					require("functions/document functions.php");
					require("functions/general functions.php");
					$db=retrieveRecordsDb();
					$row=getDocumentDetails($db,getDocumentId($db,$_POST['reference_number']));
					if($row['document_type']=="OUT"){
						echo "Error: Document is an outgoing copy!";
						echo '<meta http-equiv="refresh" content="1;url=receiveDocument.php" />';

					}
					else {
						$_SESSION['reference_number']=$_POST['reference_number'];
						header("Location: forwardDocument.php");
					}
				}
				else if($_POST['actionToTake']=="CLOSE"){
				
					require("functions/document functions.php");
					require("functions/general functions.php");
					require("functions/routing process.php");
					$db=retrieveRecordsDb();	
					$ref_no=getDocumentId($db,$_POST['reference_number']);
					updateDocumentStatus($db,"CLOSED: ".$_SESSION['department'],$ref_no);
					
					$rs=getRoutingActions($db,$ref_no);
					$row=$rs->fetch_assoc();
					
					$status[0]="CLOSED";
					$status[1]="PENDING";
					updateRoutingStatus($db,$_SESSION['department'],$status,$row['id']);
					
					$status[0]="CLOSED";
					$status[1]="ISSUED AND SENT";
					updateRoutingStatus($db,$_SESSION['department']."','ALL OFFICERS",$status,$row['id']);
					
					
					
					echo "Document has been closed.";
					echo '<meta http-equiv="refresh" content="1;url=receiveDocument.php" />';

				}

			}
			else {
				$_SESSION['reference_number']=$_POST['reference_number'];
				header("Location: routing report.php");
			}
		}
		
		if(isset($_POST['fwdReferenceNumber'])){

			$_SESSION['reference_number']=$_POST['fwdReferenceNumber'];
			$_SESSION['fwdOut']="Y";

			header("Location: forwardDocument.php?fTy=oU");
		}
		
		if(isset($_POST['forwardDocument'])){
			$db=retrieveRecordsDb();
			$forwardTo=$_POST['forwardToDept'];
			$forwardRemarks="Attached is a copy of an Outgoing Document";
			$forwardTime=date("Y-m-d H:i:s");
			$forwardSender=$_SESSION['department'];
			$forwardNumber=$_POST['forwardDocument'];
			$forwardType="MEMO";
			
			$sql="insert into forward_copy(remarks,to_department,reference_number,forward_date,forwarding_office,document_type) values ";
			$sql.="(";
			$sql.="\"".$forwardRemarks."\",";
			$sql.="\"".$forwardTo."\",";
			$sql.="\"".$forwardNumber."\",";
			$sql.="'".$forwardTime."',";
			$sql.="\"".$forwardSender."\",";
			$sql.="\"".$forwardType."\"";
			$sql.=")";	
		
			$rs=$db->query($sql);	
			header("Location: receiveDocument.php");

		
		}
		
		if(isset($_POST['document_action'])){
		

		
			if($_POST['document_action']=="REC"){
				$_SESSION['doc_action']="REC";
				header("Location: createDocument.php");
			}
			else if($_POST['document_action']=="ISS"){
				$_SESSION['doc_action']="ISS";
				header("Location: createDocument.php");
			}
			else if($_POST['document_action']=="FIND"){
				$_SESSION['find_type']=$_POST['document_type'];
				header("Location: searchDocuments.php");
			}
			$_SESSION['document_type']=$_POST["document_type"];
		}
		
		if($_POST['enableBackup']=="on"){
			$db2=retrieveUsersDb();
			
			if(verifyUser($db2,$_POST['records_username'],$_POST["records_password"])=="Okay for access."){
				$db=retrieveUsersDb();
				$stats=backupStatus($db);

				if($stats=="false"){
					$update="update records_officer set active='true' where role='back-up'";
					$rs=$db->query($update);

					$update="update records_officer set active='false' where role='primary'";
					$rs=$db->query($update);

					header("Location: receiveDocument.php?ts=4#BACKUP");

				}
				else {
					$update="update records_officer set active='false' where role='back-up'";
					$rs=$db->query($update);

					$update="update records_officer set active='true' where role='primary'";
					$rs=$db->query($update);
					header("Location: receiveDocument.php?ts=4#BACKUP");
				
				}
			}
			else {
				echo "Password is invalid.  Please provide your correct password";
				echo '<meta http-equiv="refresh" content="1;url=receiveDocument.php?ts=4#BACKUP" />';
				//header("Location: receiveDocument.php?ts=4#BACKUP");
			
			}
		}
		
/**		else {
			header("Location: receiveDocument.php?ts=4#BACKUP");
		}
	*/
	}
	else if($_SESSION["page"]=="forwardDocument.php"){
		$db=retrieveRecordsDb();
		require("functions/document functions.php");

		$forwardTo=$_POST['forward_to'];
		$forwardRemarks=$_POST['forwardRemarks'];
		$forwardTime=date("Y-m-d H:i:s");
		$forwardSender=$_SESSION['department'];
		$forwardNumber=$_SESSION['reference_number'];
		if($_SESSION['fwdOut']=="Y"){
			$forwardType="IN";
			unset($_SESSION['fwdOut']);
		}		
		else {
			$forwardType="OUT";
		}
		$docId=getDocumentId($db,$_SESSION['reference_number']);
		
		
		$sql="insert into forward_copy(remarks,to_department,reference_number,forward_date,forwarding_office,document_type) values ";
		$sql.="(";
		$sql.="\"".$forwardRemarks."\",";
		$sql.="\"".$forwardTo."\",";
		$sql.="\"".$forwardNumber."\",";
		$sql.="'".$forwardTime."',";
		$sql.="\"".$forwardSender."\",";
		$sql.="\"".$forwardType."\"";
		$sql.=")";	
		
		
		$rs=$db->query($sql);	
		updateDocumentStatus($db,"FORWARDED",$docId);
		
		header("Location: receiveDocument.php");
		
	}
	else if($_SESSION['page']=="end of the month report.php"){
		if(isset($_POST['filterDocument'])){
		$_SESSION['filterDocument']=$_POST['filterDocument'];	
		$_SESSION['filterMonth']=$_POST['filterMonth'];	
		$_SESSION['filterYear']=$_POST['filterYear'];	
		
		unset($_SESSION['awaitMonth']);
		unset($_SESSION['awaitYear']);
		unset($_SESSION['sentMonth']);
		unset($_SESSION['sentYear']);
		unset($_SESSION['orderMonth']);
		unset($_SESSION['orderYear']);

		}
		else {
			$_SESSION['filterDocument']="ALL";	
//			$_SESSION['filterMonth']=date("m");	
//			$_SESSION['filterYear']=date("Y");	
		}
		
		
		if(isset($_POST['sentDocumentFilter'])){
			if($_POST['sentDocumentFilter']=="CLOSED"){
				$_SESSION['sentClause']=" status like ('%CLOSED%%')";
			}
			else if($_POST['sentDocumentFilter']=="SENT"){
				$_SESSION['sentClause']=" status in ('SENT')";

			}
			else if($_POST['sentDocumentFilter']=="FORWARD"){
				$_SESSION['sentClause']=" status in ('FORWARDED')";
			}
			else {
				$_SESSION['sentClause']=" (status in ('SENT','FORWARDED') or status like '%CLOSED%%') ";
		
			}
			$_SESSION['sentMonth']=$_POST['sentMonth'];
			$_SESSION['sentYear']=$_POST['sentYear'];
			

			
		}
		
		if(isset($_POST['awaitDocsFilter'])){

			if($_POST['awaitDocsFilter']=="AR"){
				$_SESSION['awaitClause']=" status in ('AWAITING REPLY')";
			}
			else if($_POST['awaitDocsFilter']=="GM"){
				$_SESSION['awaitClause']=" status in ('FOR: CLARIFICATION','FOR: GM APPROVAL')";

			}
			else if($_POST['awaitDocsFilter']=="NR"){
				$_SESSION['awaitClause']=" status in ('FOR: ROUTING')";

			}

			else if($_POST['awaitDocsFilter']=="IN"){
				$_SESSION['awaitClause']=" status in ('INCOMPLETE')";
			}
			else {
				$_SESSION['awaitClause']=" status in ('INCOMPLETE','FOR: ROUTING','AWAITING REPLY','FOR: CLARIFICATION','FOR: GM APPROVAL') ";
			}		
			
			$_SESSION['awaitMonth']=$_POST['awaitMonth'];
			$_SESSION['awaitYear']=$_POST['awaitYear'];

			
		}
		
		if(isset($_POST['ordersDocsFilter'])){
			if($_POST['ordersDocsFilter']=="NS"){
				$_SESSION['orderClause']=" and status in ('ISSUED')";
			}
			else if($_POST['ordersDocsFilter']=="IS"){
				$_SESSION['orderClause']=" and status in ('ISSUED AND SENT')";

			}
			else {
				$_SESSION['orderClause']=" and status in ('ISSUED','ISSUED AND SENT') ";
		
			}	

			$_SESSION['orderMonth']=$_POST['orderMonth'];
			$_SESSION['orderYear']=$_POST['orderYear'];

			
		}
		
		header("Location: end of the month report.php");
	}
	else {
		header("Location: receiveDocument.php");
	}
	
?>