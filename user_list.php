<?php
session_start();
?>

<?php
require("db_page.php");
require("title.php");
require("functions/user functions.php");
require("functions/general functions.php");
require("functions/document functions.php");
?>
<?php

	if($_POST['records_username']==$_SESSION["username"]){

		if(isset($_POST['userAction'])){
			$db=retrieveUsersDb();
			switch($_POST["userAction"]){
				case "password":
					$sql="update users set password='".$_POST['updateText']."' where username='".$_POST['updateUser']."'";
					$rs=$db->query($sql);
				break;
			
				case "username":
					$sql="update users set username='".$_POST['updateText']."' where username='".$_POST['updateUser']."'";
					$rs=$db->query($sql);
					
					$sql="update records_officer set username='".$_POST['updateText']."' where username='".$_POST['updateUser']."'";
					$rs=$db->query($sql);
				break;
			
				case "delete":
					$sql="delete from users where username='".$_POST['updateUser']."'";
					$rs=$db->query($sql);

					$sql="delete from records_officer where username='".$_POST['updateUser']."'";
					$rs=$db->query($sql);
				break;
				
			}
		}	


		if(isset($_POST['officerAction'])){
			$db=retrieveRecordsDb();
			switch($_POST["officerAction"]){
				case "position":
					$sql="update originating_officer set position='".$_POST['updateText']."' where id='".$_POST['officerList']."'";
					$rs=$db->query($sql);
				break;
			
				case "name":
					$sql="update originating_officer set name='".$_POST['updateText']."' where id='".$_POST['officerList']."'";
					$rs=$db->query($sql);
					
				break;
			
				case "delete":
					$sql="delete from originating_officer where id='".$_POST['officerList']."'";
					$rs=$db->query($sql);
				break;
			}
		}	

		if(isset($_POST['addOfficerName'])){
			$db2=retrieveRecordsDb();
			$sql="insert into originating_officer(name,position) values ('".$_POST['addOfficerName']."','".$_POST['addOfficerPosition']."')";
			$rs=$db2->query($sql);
		}


		
		if(isset($_POST['divisionAdd'])){
			$db=retrieveUsersDb();
			$sql="insert into division_management(division_id,security_phrase,user_no) values ('".$_POST['divisionAdd']."','".$_POST['phraseAdd']."','".$_POST['limitAdd']."')";
			$rs=$db->query($sql);
		}
		
		if(isset($_POST['modifyField'])){
			$department=$_POST['department'];
			$action=$_POST['modifyField'];
			$updateValue=$_POST['updateField'];

			$db=retrieveUsersDb();

			$sql_upd="update division_management set ".$action."='".$updateValue."' where division_id='".$department."'";
			$rs=$db->query($sql_upd);
		}
	}



?>
<!--
<LINK href="css/program design.css" rel="stylesheet" type="text/css">
-->
<link href="dist/css/bootstrap.min.css" rel="stylesheet">
<link href="justified-nav.css" rel="stylesheet">	

<body>
<div align=right><a href='receiveDocument.php?ts=3#USERMANAGE'>Go Back to Main Page</a></div>

<?php
$db2=retrieveUsersDb();
if(verifyUser($db2,$_POST['records_username'],$_POST['records_password'])=="Okay for access."){
	require("main/user_list.php");
}
else {
	echo "Sorry. Invalid ID.";
}
?>
</body>