<?php
session_start();
?>

	<body>
	<?php	
		//require("header.jpg");
		require("title.php");
		require("db_page.php");
?>

	<title>Records Officer Page</title>
<?php
echo '<div align="right" width=100%><a href="logout.php">Log Out</a></div>';
echo "<br>";

echo "<div align=left width=100%><a href='receiveDocument.php'>Switch to Division Page</a></div>";
?>
<table border=1 width=100%>
<tr>
<th colspan=7><h2><font color=red>RECORDS OFFICER</font></h2></th>
</tr>

</table>
<style type='text/css'>

td {
border: 1px solid gray;

background-color: #95cbe9;


}

th {
border: 1px solid gray;
background-color:#00cc66;
color: #bd2031;

}

#viewlink {
background-color: white;


}

#exception td{
border: 1px solid white;

}



</style>
<br>
<?php
require("documentManagement.php");
require("userManagement.php");
require("backupAccount.php");
?>