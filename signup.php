<?php
###################################
#########登入使用者的部分##########
###################################

$account = isset($_POST["account"])?$_POST["account"]:"";
$passwd = isset($_POST["passwd"])?$_POST["passwd"]:"";
if ($account != "")
{
	include ("configure.php");
	$link = new PDO('mysql:host='.$hostname.';dbname='.$database.';charset=utf8', $username, $password);
	$query = "SELECT * FROM `user`";
	$result = $link->query($query);

	$temp = 0;

	foreach ($result as $row)
	{
		
		$acc = $row["account"];
		$pass = $row["passwd"];
		if ($acc == $account)
		{
			if ($pass == $passwd)
			{
				$temp = 1;
				break;
			}
		}
	}
}
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>登入</title>
	<meta name="keywords" content=" MySQL, PHP 期末報告">
	<meta name="description" content=" 這是「PHP網路程式設計」期末報告">
	<link rel=stylesheet type="text/css" href="mystyle.css">
	
	
	<style type="text/css">
		body {
			background-color: #4F4F4F;
		}
	</style>
	<script>
		
	</script>
</head>
<body>
	<form method = "POST" action="">
		<center>
			<table>
				<tr>
					<td><span style="color:white; display:block;">帳號　</td><th><input style="width:8cm; text-align:center;" type="text" name='account'></span></th>
				</tr>
				<tr>
					<td><span style="color:white; display:block;">密碼　</td><th><input style="width:8cm; text-align:center;" type="password" name='passwd'></span></th>
				</tr>
				<tr>
					<td colspan=2><?php
		if ($account != "")
		{
			if ($temp == 0)
				echo "<span style='color:red; text-align:right'>登入失敗 </span>";
			else
			{
				header("location: userpage.php?account=$account");
			}
		}
	?><button style="float: right;" type="submit" formaction="createuser.php">創建帳號</button><button type="submit" formaction='index.php' style="float:right;" >取消</button><button style="float: right;" type="submit" formaction='#'>登入</td>
				</tr>
			</table>
		</center>
	</form>
</body>
</html>

