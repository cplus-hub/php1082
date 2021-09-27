<?php
###################################
##########修改圖片的部分###########
###################################
include ("configure.php");
$link = new PDO('mysql:host='.$hostname.';dbname='.$database.';charset=utf8', $username, $password);
session_start();
$url = $_SESSION['url'];
$name = isset($_GET['name'])?$_GET['name']:$_SESSION['name'];

@$temp = isset($_GET['temp'])?$_GET['temp']:$_SESSION['temp'];
if ($temp == 0)
{
	$query = "SELECT * FROM `picture` WHERE `url` = '$url' AND `name` = '$name' ;";
	$result = $link -> query($query);
	foreach ($result as $row)
	{
		$name = $row['name'];
		$role = $row['role'];
		$groupname = $row['groupname'];
		$wwrod = $row['wwrod'];
	}
}
$ID = $_SESSION['ID'];

$picname = isset($_GET['picname'])?$_GET['picname']:$name;
$role = isset($_GET['role'])?$_GET['role']:$role;
$groupname = isset($_GET['groupname'])?$_GET['groupname']:$groupname;
$wwrod = isset($_GET['wwrod'])?$_GET['wwrod']:$wwrod;

if ($name != "" or $role != "" or $groupname != "")
	if ($name == "" or $role == "" or $groupname == "")
		$temp = -1;
	else
		$temp = 1;
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>修改<?php echo $name; ?></title>
	<meta name="keywords" content=" MySQL, PHP 期末報告">
	<meta name="description" content=" 這是「PHP網路程式設計」期末報告">
	<link rel=stylesheet type="text/css" href="mystyle.css">
	
	
	<style type="text/css">
		/*超連結去底線*/
		a{text-decoration:none;}
		body {
			font-family:Microsoft JhengHei;
			background-color: #4F4F4F;
		}
	</style>
</head>
<body>
		<center>
			<div style="margin-top:100px;"><img src="<?php echo $url; ?>" width="300"></div>
		</center>
	<div align="center" style="margin-top:30;">
		<form method="GET" action=''><input type='hidden' value='<?php echo $temp+1;?>' name = 'temp'>
			<table>
				<tr>
					<td><span style="color:white; text-align: left; display:block;">圖片名稱<span style="color:red">*</span>　</td><th><input style="width:12cm; text-align:center;" type="text" name='picname' value='<?php echo $picname;?>'></span></th>
				</tr>
				<tr>
					<td><span style="color:white; text-align: left; display:block;">角色名稱<span style="color:red">*</span></td>　<th><input style="width:12cm; text-align:center;" type="text" name='role' value='<?php echo $role;?>'></span></th>
				</tr>
				<tr>
					<td><span style="color:white; text-align: left; display:block;">群組<span style="color:red">*</span></td>　<th><input style="width:12cm; text-align:center;" type="text" name='groupname' value='<?php echo $groupname;?>'></span></th>
				</tr>
				<tr>
					<td><span style="color:white; text-align: left; display:block;">作者的話</td>　<th><textarea style="width:12cm; text-align:center;" name='wwrod'><?php echo $wwrod;?></textarea></th>
				</tr>
				<tr>
					<td colspan=2><?php if ($temp == -1) echo "<span style='color:red; text-align:right'>請完整輸入紅標資訊 </span>" ;?>
					<a href= "picture.php" style="display:block; color:white;float:right;" >　關閉</a>
					<button type="submit" formaction="alter.php" style="display:block;font-family:Microsoft JhengHei;font-size:15px; background-color:#4f4f4f; color:white; float:right; border:3px">修改</button></td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>

<?php	
	if ($temp == 1)
	{
		$query = "UPDATE `picture` SET `name`='$picname',`role`='$role', `groupname` = '$groupname', `wwrod` = '$wwrod' WHERE `ID` = $ID";
		$link -> exec($query);
		if (isset($_GET['picname']))
			header("location:picture.php");
	}
?>