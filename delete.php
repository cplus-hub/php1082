<?php
###################################
##########刪除圖片的部分###########
###################################
include ("configure.php");
$link = new PDO('mysql:host='.$hostname.';dbname='.$database.';charset=utf8', $username, $password);
session_start();
$url = $_SESSION['url'];
$name = $_SESSION['name'];
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>刪除<?php echo $name; ?></title>
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
	<form method="POST" action="">
		<center>
			<div style="margin-top:100px; color:white; ">
				<div> <img src="<?php echo $url; ?>" width="300">
				</div><br><?php echo "
				圖片名稱：$name"
				?>
				<br><br><input value="<?php echo $url;?>" name="delurl" type='hidden'>
			<button type="submit" style="display:inline;font-size:17px; background-color:#4f4f4f; color:white; border:3px">刪除</button>　
			<a href="picture.php" style="display:inline; color:white; ">取消</a>
			</div>
		</center>
	</form>
</body>
</html>

<?php	
	if (isset($_POST['delurl']))
	{
		$query = "DELETE FROM `picture` WHERE `url` = '$url' AND `name` = '$name';";
		$link -> exec($query);
		$query = "DELETE FROM `text` WHERE `url` = '$url'";
		$link -> exec($query);
		header("location:userpage.php");
	}

?>