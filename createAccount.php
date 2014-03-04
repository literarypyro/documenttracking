<?php
session_start();
?>
<?php
$_SESSION['page']="createAccount.php";
require("db_page.php");
require('header_2.php');

//require('title.php');

require("functions/form functions.php");
$db=retrieveRecordsDb();
?>
<!--
<LINK href="css/program design 3.css" rel="stylesheet" type="text/css">
-->
	<link href="dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="justified-nav.css" rel="stylesheet">	
	<style type='text/css'>
	.container {
		margin-left:30%;
		float:left;
	}
</style>
<title>Create New Account</title>
<!-- style='background-image:url("body background.jpg");' -->
<body >
<br>
<br>
<div class='container'>
<div class='well col-lg-6'>
<form action='submit.php' method='post'>
<legend>Create New Account</legend>
<table id=cssTable align=center cellpadding=2>
<tr>
	<td><label class='control-label'>First Name</label></td>
	<td><input type=text name='firstName' size=40 ></td>
</tr>
<tr>
	<td><label class='control-label'>Last Name</label></td>
	<td><input type=text name='lastName' size=40 ></td>
</tr>

<tr>
	<td><label class='control-label'>Enter Department</label></td>
	<td>
	<?php retrieveDepartmentListHTML($db,"","department"); ?>
	</td>
</tr>


<tr>
	<td><label class='control-label'>Username</label></td>
	<td><input type=text name='userName' size=40 ></td>
</tr>
<tr>
	<td><label class='control-label'>Password</label></td>
	<td><input type=password name='password' size=40 ></td>
</tr>
<tr>
	<td><label class='control-label'>Retype Password</label></td>
	<td><input type=password name='repassword' size=40 ></td>
</tr>
<tr>
	<td><label class='control-label'>Security Phrase</label></td>
	<td><input type=text name='phrase' size=40 value='login' ></td>
</tr>
<tr>
	<td colspan=2><label class='control-label'>Please enter the security phrase that was given to you</label></td>
</tr>
<tr>
	<td colspan=2 align=center><input class='btn btn-primary' type=submit value='Submit' /></td>
</tr>
<tr>
<td colspan=2 id='exception' align=center> <b><a href='login.php'>Go back to Login Page</a></b></td>
</tr>
</table>
</form>
</body>
</div>
</div>