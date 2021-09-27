<?php
###################################
#########上傳單張圖片##############
###################################
include ("configure.php");
session_start();
$link = new PDO('mysql:host='.$hostname.';dbname='.$database.';charset=utf8', $username, $password);
$account = $_SESSION['account'];
$browser = isset($_GET["browser"])?$_GET["browser"]:"";
$url = isset($_GET["url"])?$_GET["url"]:"";
if ($browser != "" and $url !="")
{
	$query = ("INSERT INTO `webpage`(`name`, `url`) VALUES ('".$browser."','".$url."')");
	$link->exec($query);
	echo '<script>window.close();</script>';
}

/*上傳者*/
$query = "SELECT `name` FROM `user` WHERE `account` = '$account'; ";
$result = $link -> query($query);
foreach ($result as $row)
	$username = $row['name'];

$picname = isset($_GET['picname'])?$_GET['picname']:"";
$url = isset($_GET['url'])?$_GET['url']:"";
$role = isset($_GET['role'])?$_GET['role']:"";
$group = isset($_GET['group'])?$_GET['group']:"";
$wword = isset($_GET['wword'])?$_GET['wword']:"";
$temp = 0;
if ($url != "" or $picname != "" or $group != "")
	if ($url == "" or $picname == "" or $group == "")
		$temp = -1;
	else
		$temp = 1;
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>上傳圖片</title>
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
	<div align="center" style="margin-top:30;">
		<form enctype="multipart/form-data">
			<table>
				<tr>
					<td><span style="color:white; text-align: left; display:block;">圖片名稱<span style="color:red">*</span>　</td><th><input style="width:12cm; text-align:center;" type="text" name='picname'></span></th>
				</tr>
				<tr>
					<td><span style="color:white; text-align: left; display:block;">網址列<span style="color:red">*</span></td>　<th><input style="width:12cm; text-align:center;" type="text" name='url'></span></th>
				</tr>
				<tr>
					<td><span style="color:white; text-align: left; display:block;">角色名稱<span style="color:red">*</span></td>　<th><input style="width:12cm; text-align:center;" type="text" name='role'></span></th>
				</tr>
				<tr>
					<td><span style="color:white; text-align: left; display:block;">群組<span style="color:red">*</span></td>　<th><input style="width:12cm; text-align:center;" type="text" name='group'></span></th>
				</tr>
				<tr>
					<td><span style="color:white; text-align: left; display:block;">作者的話</td>　<th><textarea style="width:12cm; text-align:center;" name='wword'></textarea></th>
				</tr>
				<tr>
					<input type='hidden' value='<?php echo $username; ?>' name = 'name';>
					<td colspan=2><?php if ($temp == -1) echo "<span style='color:red; text-align:right'>請完整輸入紅標資訊 </span>"; elseif($temp == 1) echo "<span style='color:red; text-align:right'>上傳成功！ </span>";?>
					<a href= "userpage.php?account=<?php echo $account;?>" style="display:block; color:white;float:right;" >　關閉</a>
					<button type="submit" formaction="upfile.php" style="display:block;font-family:Microsoft JhengHei;font-size:15px; background-color:#4f4f4f; color:white; float:right; border:3px">新增</button></td>
				</tr>
			</table>
		</form>
	</div>
</body>
</html>
<?php
		
	if ($temp == 1)
	{
		$query = ("INSERT INTO `picture`(`name`, `url`, `role`, `groupname`, `wwrod`, `uploader` ) VALUES ('$picname', '$url', '$role', '$group', '$wword', '$username' )");
		$result = $link->exec($query);
	}
	?>