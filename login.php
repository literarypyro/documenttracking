<?php
session_start();
?>
<?php
//Clear all previous sessions
//session_destroy();
?>
<?php
$_SESSION['page']="login.php";
require("header.php");
?>
<style type='text/css'>

h1{ 
	color: #444; 
	font: 17px Verdana; 
	-webkit-font-smoothing: antialiased; 
	text-shadow: 0px 1px black; 
	border-bottom: 1px solid #FBCC2A; 
	margin: 10px 0 2px 0; 
	padding: 5px 0 6px 0; 
}
</style>
<LINK href="css/program design 3.css" rel="stylesheet" type="text/css">
<title>Login</title>
<!--style="background-image:url('body background.jpg');"-->
<body>
<h1>DOTC-MRT3 Document Tracking System</h1>
<code style="height:250px; ">
	<div style="float:left;" align="left">
		<img src="mrt-logo.png">
	</div>
	<div style="float:right;" align="right">
		<form action="submit.php" method="post">
		<table>
			<tr><th colspan=2>Log-in to the System</th></tr>
			<tr>
				<td align="right">username : </td>
				<td><input type='text' name='username' style="width:300px; font-family:verdana;" /></td>
			</tr>
			<tr>
				<td align="right">password : </td>
				<td><input type='password' name='password' style="width:300px; font-family:verdana;" /></td>
			</tr>
			<tr>
				<td colspan=2 align="right"><input type=submit value='Submit' />
			</tr>
		</table>
		</form>
		<table align=center >
		<!--style="color: #ffcc35;"-->
		<tr><th colspan=2>For new account:</th></tr><tr><th colspan=2><a  href='createAccount.php'>
		 Create a new Account 
		</a></th></tr>
		</table>		
	</div>
</code>

<style>
	body{ background-image:url(images/page-bg.png); width:800px; height:auto; margin-left:auto; margin-right:auto; margin-top:60px; font-family: verdana; }
	code{ background-color: #f9f9f9; border: 1px solid #D0D0D0;  display: block; margin: 14px 0 14px 0; padding: 12px 10px 12px 10px; font-family:verdana;}

	input{ height:30px; font-weight:bold; font-size:18px; width:200px; font-family:courier; border: 1px solid #C6C6C6; width:250px; text-align:center;}	
	
	input[type=text] { border: solid 1px #85b1de; font-size: 15px; font-family:verdana; padding:3px; }
	input[type=text]:hover{ background:#F0F0F0; }
	input[type=text]:focus{ background:#F9F9F9; border: solid 1px #373737; }

	input[type=password]{ background:#F9F9F9; border: solid 1px #736357; }
	input[type=password]:hover{ background:#F0F0F0; }
	input[type=button]:hover{ background:GOLD; }

	.r{ text-align:right; }
	.c{ text-align:center; }
	.f10{ font-size:11px; }

	input[type=submit]:hover{ background:gold; }
	
	

</style>
</body>
<!--
Program is undergoing modifications.  All functions are currently disabled.
-->