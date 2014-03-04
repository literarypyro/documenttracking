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
<LINK href="css/program design 3.css" rel="stylesheet" type="text/css">
<title>Login</title>
<body style="background-image:url('body background.jpg');">
<br><br><br>
<form action='submit.php' method='post'>
<table id='cssTable' align=center style='border: 1px solid gray'>
<tr>
   <th colspan=2><h2>Login</h2></th>		
</tr>
<tr>
   <td>Username</td><td><input type=text name='username' /></td> 		
</tr>
<tr>
   <td>Password</td><td><input type=password name='password' /></td> 		
</tr>
<tr>
   <td align=center colspan=2><input  type=submit value='Submit' /></td>	
</tr>
<tr><td colspan=2>&nbsp;</td></tr></table><br>
<table id='cssTable' align=center style='border: 1px solid gray'>
<tr><th colspan=2>For new account:</th></tr><tr><th colspan=2><h3><a style="color: #ffcc35;" href='createAccount.php'>
 Create a new Account 
</a></h3></th></tr>
</table>
</form>
<!--
Program is undergoing modifications.  All functions are currently disabled.
-->