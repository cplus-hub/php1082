<?php
###################################
##########新增使用者的部分#########
###################################
include ("configure.php");
$link = new PDO('mysql:host='.$hostname.';dbname='.$database.';charset=utf8', $username, $password);
$name = isset($_POST["name"])?$_POST["name"]:"";
$account = isset($_POST["account"])?$_POST["account"]:"";
$passwd = isset($_POST["passwd"])?$_POST["passwd"]:"";
$temp = 0;
if ($name != "" or $account != "" or $passwd != "")
{
	if ($name == "" or $account == "" or $passwd == "")
	{
		$temp = -1;
	}
	else
	{
		$query = "SELECT * FROM `user`";
		$result = $link->query($query);
		foreach ($result as $row)
		{
			$acc = $row["account"];
			$pass = $row["passwd"];
			if ($acc == $account)
			{
				$temp=-2;
				break;
			}
			else
				$temp = 1;
		}
	}
}

?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>新增使用者</title>
	<meta name="keywords" content=" MySQL, PHP 期末報告">
	<meta name="description" content=" 這是「PHP網路程式設計」期末報告">
	<link rel=stylesheet type="text/css" href="mystyle.css">
	
	
	<style type="text/css">
		body {
			background-color: #4F4F4F;
		}
	</style>
</head>
<body>
	<form method="POST" action="">
		<center>
			<table>
				<tr>
					<td><span style="color:white; display:block;">使用者暱稱　</td><th><input style="width:8cm; text-align:center;" type="text" name='name'></span></th>
				</tr>
				<tr>
					<td><span style="color:white; display:block;">使用者帳號　</td><th><input style="width:8cm; text-align:center;" type="text" name='account'></span></th>
				</tr>
				<tr>
					<td><span style="color:white; display:block;">使用者密碼　</td><th><input style="width:8cm; text-align:center;" type="password" name='passwd'></span></th>
				</tr>
				<tr>
					<td colspan=2><?php
			if ($temp == 0)
				echo "";
			elseif ($temp == -1)
				echo "<span style='color:red; text-align:right'>請輸入完整資訊 </span>";
			elseif ($temp == -2)
				echo "<span style='color:red; text-align:right'>已有相同帳號 </span>";
			else
			{
				session_start();
				$query = ("INSERT INTO `user`(`name`, `account`, `passwd`) VALUES ('".$name."', '".$account."', '".$passwd."')");
				$result = $link->exec($query);
				header("location: userpage.php?account=$account");
			}
	?><input type="button" onclick="location='index.php'" style="float:right;" VALUE="取消" ><input style="float: right;" type="submit" value="創立"></td>
				</tr>
			</table>
		</center>
	</form>
</body>
</html>

