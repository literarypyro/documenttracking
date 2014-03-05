<?php
?>
<!--background-color:#66ceae;-->
<?php
$date=date("Y-m-d");
?>
<?php
$db=retrieveRecordsDb();
$rs=receiveRoutingMessages($db,$_SESSION['department']);
$pending=$rs->num_rows;

$sql="select * from document inner join document_routing on document.id=document_routing.reference_id where sending_office='".$_SESSION['department']."' and (status in ('FORWARDED','SENT','AWAITING REPLY','FOR: GM APPROVAL','FOR: CLARIFICATION') or status like '%CLOSED%%') and document_type='OUT' order by request_date desc";
$rs=$db->query($sql);
$outgoing=$rs->num_rows;

$rs=sortDocument($db,"FOR: ROUTING",$_SESSION['department']);
$unsent=$rs->num_rows;

$sql="select * from forward_copy where document_type in ('MEMO','IN') and to_department='".$_SESSION['department']."' order by forward_date desc";

$rs=$db->query($sql);
$copies=$rs->num_rows;

$sql="select * from routing_targets inner join document_routing on routing_targets.routing_id=document_routing.id where status='ISSUED AND SENT' and destination_office in ('".$_SESSION['department']."','ALL OFFICERS') and request_date like '".$date."%%'";
$rs=$db->query($sql);
$orders=$rs->num_rows;

?>

<!--

<td width="15%" colspan=2 rowspan=2 align=center valign="top"  style="border-left-style: solid; border-left-width: 1px; border-left-color:black; border-right-style: none; border-right-width: 1px; border-top-style: none; border-top-width: 1px; border-bottom-style: solid; border-bottom-width: 1px; border-bottom-color:black; border-color:#FF600;" bordercolor="#FF6600">
-->
<table width=100% style='background-color:white;border:1px solid white;'>
<tr>
<td width=35% style='background-color:white;border:1px solid white;'>

<div class="masthead" align=center>
<ul class="nav nav-justified">
	<li <?php if($_GET['ts']=="2"){ echo "class='active'"; } ?>><a id='ACTIONS' href="createDocument.php" onclick="">NEW ACTION</a></li>
	<li <?php if($_GET['pp']=="1a"){ echo "class='active'"; } ?>><a id='PENDING'  href="receiveDocument.php?pp=1a&iN=10&St=10#PENDING">INCOMING <?php if($pending>0){ echo "(".$pending.")"; } ?></a></li>
	<li <?php if($_GET['pp']=="1b"){ echo "class='active'"; } ?>><a id='OUTGO'  href="receiveDocument.php?pp=1b&iN=10&St=10#OUTGO">OUTGOING <?php if($outgoing>0){ echo "(".$outgoing.")"; } ?></a></li>
	<li <?php if($_GET['pp']=="5"){ echo "class='active'"; } ?>><a id='FORWARDEDCOPY'  href="receiveDocument.php?pp=5&cInG=10#FORWARDEDCOPY">COPIES RECEIVED <?php if($copies>0){ echo "(".$copies.")"; } ?></a></li>
	<li <?php if($_GET['pp']=="2"){ echo "class='active'"; } ?>><a id='UNSENT'  href="receiveDocument.php?pp=2&Ir=10&fL=10#UNSENT">UNSENT DOCUMENTS <?php if($unsent>0){ echo "(".$unsent.")"; } ?></a></li>

<!--
</ul>

	
</div>	
-->

<!-- end the menuh div --> 
<!--</td>-->
<!--
</td>
</td>
</table>
<hr style='color:rgb(213,233,237);visibility:hidden;' >
<table width=100%  style='border: 1px solid  rgb(213,233,237)'>
<tr>
<td  style='border: 1px solid  rgb(213,233,237)'>
-->
<!--
<td width=65% style='background-color:white;border:1px solid white;'>
<div id="menuh" align=left>
<ul id="tabmenu">
	-->
	<li <?php if($_GET['ts']=="1"){ echo "class='active'"; } ?>><a id='ORDERS'  href="receiveDocument.php?ts=1&dFO=10#ORDERS" onclick="">OFFICE ORDERS <?php if($orders>0){ echo "(".$orders.")"; } ?></a></li>
	<li <?php if($_GET['ts']=="6"){ echo "class='active'"; } ?>><a id='SEARCH'  href="receiveDocument.php?ts=6#SEARCH" onclick="">ARCHIVE</a></li>
	<li><a href="logout.php" style='border-right:1px solid white'>LOG OUT</a></a>

</ul>
	
</div>
</td>
</tr>



<!--
</td>
</tr>
</table>
-->
	<?php
	if($_SESSION['department']=="REC"){
	$user_db=retrieveUsersDb();
	?>
<!--
	<br>

	<hr style='color:rgb(213,233,237);visibility:hidden;' >
<table width=100% style='border: 1px solid  rgb(213,233,237)' >
<tr>
<td  style='border: 1px solid  rgb(213,233,237)'>
-->
</table>
<br>
<table width=100% style='background-color:white;border:1px solid white;'>
	<tr>
	<td width=100%  colspan=2 style='background-color:white;border:1px solid white;'>
<div class="masthead" align=center>
<ul class="nav nav-justified">


		<li <?php if($_GET['pp']=="4"){ echo "class='active'"; } ?>><a id="RECORDS"  href="receiveDocument.php?pp=4&AMd=10&RDm=10#RECORDS">RECORDS OFFICER PAGE</a></li>
	<?php

	$month=date("m");
	$day=date("d");
	if(($month==4)||($month==6)||($month==9)||($month==11)){
		$indicator=30;

	}
	else if($month==2){
		$indicator=28;
	}
	else {
		$indicator=31;
	}
	//	if($day>=$indicator){
	?>
		<li <?php if($_GET['pp']=="6"){ echo "class='active'"; } ?>><a id="EOMR"  href="receiveDocument.php?pp=6#EOMR">END OF THE MONTH REPORT</a></li>
	<?php
	//} 
	?>
		<li <?php if($_GET['ts']=="3"){ echo "class='active'"; } ?>><a id="USERMANAGE"   href="receiveDocument.php?ts=3#USERMANAGE"  >USER MANAGEMENT</a></li>
		<li <?php if($_GET['ts']=="4"){ echo "class='active'"; } ?>><a id="BACKUP"   href="receiveDocument.php?ts=4#BACKUP"  >BACKUP ACCOUNT</a></li>
		<li <?php if($_GET['ts']=="5"){ echo "class='active'"; } ?>><a id="OUTGOING" style='border-right:1px solid white'   href="receiveDocument.php?dtg=10&ftg=10&ts=5#OUTGOING"  >OUTGOING DOCUMENTS (FOR RECORDS)</a></li>
</ul>
</div>
</td>
</tr>
<!--
</td>
</tr>
</table>
-->
<?php
}
?>
<?php
	if($_SESSION["department"]=="OGM"){
?>
<!--
<hr style='color:rgb(213,233,237);visibility:hidden;' >
-->
	<!--
	<table width=100%  style='border: 1px solid white'>
	<tr>
	<td  style='border: 1px solid white'>
	-->
	<tr>
	<td colspan=2>
<div class="masthead" align=center>
<ul class="nav nav-justified">

	<li <?php if($_GET['pp']=="3"){ echo "class='active'"; } ?>><a id="GM"  style='border-right:1px solid white' href="receiveDocument.php?pp=3&dNL=10#GM">OGM Page</a></li>
	</ul>
	</div>
	<!--
	</td>
	</tr>
	</table>
	-->
	</td>
	</tr>
	<?php
	}
	?>
<!--</td>-->
</table>
<br>




<?php

?>
