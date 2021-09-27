<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
###################################
###############顯示圖片############
###################################

include ("configure.php");
session_start();
$link = new PDO('mysql:host='.$hostname.';dbname='.$database.';charset=utf8', $username, $password);

if (isset($_GET['account']))
{
	$_SESSION['user'] = $_GET['account'];
	$user = $_SESSION['user'];
}
elseif (isset($_SESSION['user']))
{
	$user = $_SESSION['user'];
	$url = $_SESSION['url'];
	$name = $_SESSION['name'];
}
if (isset($_GET['user']))
{
	$user = $_GET['user'];
	if ($user == 0)
	{
		unset($_SESSION['user']);
		unset($_SESSION['account']);
	}
}
if (isset($_GET['url']))
	$url = $_GET['url'];
	$query = "SELECT `picture`.*, `user`.`account` AS 'account'  FROM `picture`, `user` WHERE  `url` LIKE '%$url%' AND `picture`.`uploader` = `user`.`name` ";
	$result = $link -> query($query);
	foreach ($result as $row)
	{
		$_SESSION['ID'] = $row['ID'];
		$db_account = $row['account'];
		$uploader = $row['uploader'];
		$url = $row['url'];
		$_SESSION['url'] = $row['url'];
		$name = $row['name'];
		$wwrod = $row['wwrod'];
		$_SESSION['name'] = $row['name'];
		break;
	}
/*刪除、新增留言*/
if (isset($_POST['delid']))
{
	$delid = $_POST['delid'];
	$del = "DELETE FROM `text` WHERE `ID` = $delid";
	$link -> exec($del);
}
elseif (isset($_POST['text']))
{
	$text = $_POST['text'];
	$query = "INSERT INTO `text`(`text`, `writer`, `url`) VALUES('$text', '$user', '$url')";
	$link -> exec($query);
	header("location:picture.php");
}
$name = $_SESSION['name'];
/*圖片上下頁*/
$i=1;
while(isset($_SESSION["file$i"]))
{
	if ($url == $_SESSION["file$i"])
	{
		$up = $i-1;
		$ptr = $i;
		$down = $i+1;
	}
	$i++;
}
$i = 1;
while(isset($_SESSION["file$i"]))
{
	$tail = $i;
	$i++;
}
if ($user != '0')
{
	$query = "SELECT * FROM `user` WHERE `account` = '$user'";
	$result = $link -> query($query);
	foreach ($result as $row)
		$accname = $row['name'];
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $name ;?></title>
	<meta name="keywords" content=" MySQL, PHP 期末報告">
	<meta name="description" content=" 這是「PHP網路程式設計」期末報告">
	<link rel=stylesheet type="text/css" href="mystyle.css">
	<script language="JavaScript" type="text/JavaScript">
	function MM_openBrWindow(theURL,winName,features) { //v2.0
		window.open(theURL,winName,features);
	}
	</script>
	<style type="text/css">
	/*超連結去底線*/
	a{text-decoration:none;}
	a:hover{text-decoration:underline;}
	
	body {
		font-size: 24px;
		color: #FFF;
		background-color: #4f4f4f;
		text-align: center;
	}
	.divleft {
		width: 200px;
		margin-left: 100px;
		margin-top: 20px;
	}
	.divmediate {
		margin-left: 300px;
		margin-top: 100px;

	}
	.divtop {
		position: relative;
		display:table;
		border: 1px solid black;
		width: auto;
		margin-top: 50px;
	}
	.divout {
		width:auto;
	}
	div {
		font-family:Microsoft JhengHei; color: #fff width:auto;
	}
	.row{
     overflow: hidden; 
	}
	.row [class*="col-"]{
			margin-bottom: 0px;
			padding-bottom: 0px;
	}
	</style>
</head>

<body><!--if ($_SESSION['account']==$user) echo else echo "index.php" ; -->
	<div>
		<div class='row'>
			<div style="float:left; margin-top:50px; "><span>
				<a href="<?php if (isset($_GET['account']) || isset($_SESSION['account'])) echo "userpage.php"; else echo "index.php"; ?>" style="display:inline; color:white; margin-left:300px;">回首頁
				</a>
				<?php 
				
				if (isset($_SESSION['account']) and $_SESSION['account'] == $db_account){
				echo "<a href='delete.php' style='display:inline; color:white;'>刪除
				</a>
				<a href='alter.php' style='display:inline; color:white;'>修改
				</a>" ;
				}?></span>
			</div>
			
			<div style = 'height:300px; line-height:30px; float:right; margin-top:100px; margin-right:200px;'><br>
				名稱：<?php echo $name; ?> 　上傳者：<?php echo $uploader; ?><br><br>
				<div style="float:left;">作者的話：</div><br><div style='font-size:25px'><?php echo nl2br($wwrod); ?></div></div>
			
			
			
			<div class="divmediate" style="width:600px; border-color:#CED1DB; border-style:solid; border-width:3px; padding:5px;">
				<img src="<?php echo $url; ?>" width="600">
			</div>
			
			<div style='border-radius:50px;  float:left; border-color:#CED1DB; border-style:solid; border-width:3px; margin-left: 300px; text-align:center; line-height:200%; '>
				<a href="picture.php?url=<?php if ($ptr==1) echo substr($_SESSION["file$tail"],-100,100); else echo substr($_SESSION["file$up"],-100,100) ;?>&<?php if (isset($_GET['user'])) echo "user=".$user; elseif (isset($_SESSION["account"])) echo "account=".$_SESSION["account"];?>" style="display:block; color:white;">上一張
				</a>
			</div>
			
			<div style='border-radius:50px; float:left; border-color:#CED1DB; border-style:solid; border-width:3px; margin-left: 460px; text-align: center; line-height:200%'>
				<a href="picture.php?url=<?php if ($ptr==$tail) echo substr($_SESSION["file1"],-100,100); else echo substr($_SESSION["file$down"],-100,100) ;?>&<?php if (isset($_GET['user'])) echo "user=".$user; elseif (isset($_SESSION["account"])) echo "account=".$_SESSION["account"];?>" style="display:block; color:white; ">下一張
				</a>
			</div>

		</div>
		<!--留言區-->
		<div style='margin-left:200px'>
			<form method='POST' action="">
				<table width="1200" align="left" cellpadding="3" cellspacing="0" border="1" height="10">
					<tr style="font-size:20px" align='center' bgcolor="silver"><td width='60'>使用者</td><td width="400">留言內容 </td><th width='150px'>時間</th><?php if (isset($user)) echo "<th width='70'>刪除</th>" ?></tr>
					<?php
						$query = "SELECT `text`.`ID`, `text`, `time`,  `user`.`name`  FROM `text`, `picture`, `user` WHERE `picture`.`name` = '$name' and `text`.`url` = '$url' and `text`.`url` = `picture`.`url` and `text`.`writer` = `user`.`account` ORDER BY `time`" ;
						$result = $link -> query($query);
						foreach ($result as $row)
						{
							$id = $row['ID'];
							$writer = $row['name'];
							$text = $row['text'];
							$time = $row['time'];
							echo "<tr><th><div style='font-size:16px'>$writer</div></th><td>$text</td><th style='font-size:15px;'>$time</th>";
							if (isset($accname) and $writer == $accname)
								echo "<th><button type='submit' name='delid' value='$id' style='background-color:#4f4f4f;border:0px white none; color:white; font-size:15px; display:block' forcmation='picture.php'>刪除</button></th></tr>";
							else
								echo "<th></th></tr>";
						}
						if (!isset($_GET['user']))
								echo "<tr><td  colspan='2'><textarea name='text' style='background-color:#4f4f4f;color:white; text-align:center; font-size:18px; width:980px;height:50px;'></textarea></td><td colspan=2><button style='background-color:#4f4f4f;border:0px white none; color:white; font-size:15px; display:block' type='submit' forcmation='picture.php'>留言</button></td></tr>";
						else
							echo "<tr><td colspan='3'>訪客無留言功能，<a href='signup.php' style='color:white; '>登入</a>後才可留言</td></tr>";
					?>
				</table>
			</form>
		</div>
	</div>
</body>
</html>
