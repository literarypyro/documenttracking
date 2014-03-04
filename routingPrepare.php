<?php
session_start();
?>
<?php
/** Enter Routing Source 
*
* There are two parts when generating a new Routing Action of
* a Document.  The first part, which is provided in this page,
* specifies the origin officer and the origin office, as well as the time 
* the action was made.
*
* @author Patrick Simon Silva
* @version 2.0
* @package routingPrepare
*/

?>
	<!-- style="background-image:url('body background.jpg');"-->
	<body>
	<?php
	require("db_page.php");
	require("title.php");
		//require("header.php");
?>
<!--
<LINK href="css/program design.css" rel="stylesheet" type="text/css">
-->
	<link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="justified-nav.css" rel="stylesheet">	

<?php
require("functions/form functions.php");
$month=date("m");
$monthLabel=date("M");
$year=date("Y");
$_SESSION['page']='routingPrepare.php';


?>
<link rel="stylesheet" href="css/humanity/jquery-ui-1.10.4.custom.css" />
<script type='text/javascript' src="js/jquery-1.10.2.js"></script>
<script type='text/javascript'  src="js/jquery-ui-1.10.4.custom.min.js"></script>
<script language='javascript'>
$(document).ready(function(){
	$('#receive_date').datepicker();

});

</script>
<div align=right>

<a href='routing report.php'>Go Back to Routing Slip</a></div>
<div class='well col-md-4' align=center>
<form action="submit.php" method=post>
<!--
id='csstable'
-->
<legend>ROUTING ORIGIN</legend>

<table  align=center >
<tr>
<td><label class='control-label' ><b>From:</b></label> </td>
<td>&nbsp;</td>
</tr>
<tr>
<td><label class='control-label' >Officer Name</label></td>
<td>
<?php 
$db=retrieveRecordsDb();
retrieveOfficerListHTML($db,"from_name");  // retrieved from functions/form functions
?>
</td>
</tr>
	<tr><td colspan=2><label class='control-label' >(If Other)</label></td></tr>
	<tr>
	<td><label class='control-label' >Name</label></td>
	<td>
	<input type='text' id='alterOfficer' name='alterOfficer' />
	</td>

	</tr>
	<tr>
	<td><label class='control-label' >Position</label></td>
	<td>
	<input type='text' id='alterPosition' name='alterPosition' />
	</td>

	</tr>
<tr>
<td><label class='control-label' >
Action/Request Time:</label>
</td>
<td>
<div class='form-inline'>
<div class='form-group'>
<input type='text' name='receive_date' id='receive_date' class='form-control' />


</div>

</div>
</td>
</tr>
<tr>
<td>&nbsp;
</td>
<td>
<div class='form-inline'>

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
<td align=center colspan=3><input type=hidden name='from' value='from' /><input class='btn btn-primary' type=submit value="Click here for the next step" /></td>
</tr>

</table>

</form>
</div>
