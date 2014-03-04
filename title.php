<?php
ini_set("date.timezone","Asia/Kuala_Lumpur");
?>
<style type='text/css'>

h1{ 
	color: #444; 
	font: 25px Verdana; 
	-webkit-font-smoothing: antialiased; 
	text-shadow: 0px 1px black; 
	margin: 10px 0 2px 0; 
	padding: 5px 0 6px 0; 
}
.one_heading {
	border-bottom: 1px solid #FBCC2A; 


}
.exception {
	border-bottom: 1px solid #FBCC2A; 


}
h2.except {
	color: #444; 
	font: 20px Verdana; 
	-webkit-font-smoothing: antialiased; 
	text-shadow: 0px 1px black; 
	margin: 10px 0 2px 0; 
	padding: 5px 0 6px 0; 
}

.exception td {
//	border:1px solid white;

}
</style>
<link href="dist/css/bootstrap.css" rel="stylesheet">

<div class='well'>
<?php
$sql="select * from department where department_code='".$_SESSION['department']."'";
$db=retrieveRecordsDb();

//turnOfTheYear($db);

$rs=$db->query($sql);
$row=$rs->fetch_assoc();

?>
<table class='exception' width=100% style=''>
<tr>
<td width=5%>
<!--
<img src='mrt-logo.png' style='width:100%;height:100%;' />
-->
<img src='mrt-logo.png' style='width:130px;height:80px;' />

</td><td valign=center width=55%><font style='font-size:25px;'><h2><b>Document Tracking System</b></h2></font>
</td>
<td width=40% align=right valign=center>
<font style='font-size:25px;'><b><?php echo strtoupper($row['department_name']); ?></b></font>


</td>
</tr>
</table>
<div class='one_heading'>
</div>
	<table width=100% >
	<tr>
<td style='' align=left width="50%">
	<em><?php echo $mainPageMessage; ?></em>
</td>
<td style='' align="right" width=50%>	
<font style='font-size:20px;'><b>
	<?php echo "Hello, ".$_SESSION['name']."!"; ?>
	</b></font></td>

</tr>
</table>
</div>
<hr>
