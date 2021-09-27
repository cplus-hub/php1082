<?php
###################################
##############錯誤頁面#############
###################################
?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>請登入</title>
	<meta name="keywords" content=" MySQL, PHP 期末報告">
	<meta name="description" content=" 這是「PHP網路程式設計」期末報告">
	<link rel=stylesheet type="text/css" href="mystyle.css">
	<style type="text/css">
		body {
			background-color: #4F4F4F;
			text-align:center;
			color:white;
		}
	</style>
</head>
<body>
	<form>
		請先登入使用者<br><br><br>
		<button type="submit" formaction="signup.php">登入</button><br><br>
		<button type="submit" formaction="index.php">回首頁</button>
	</form>
</body>
</html>
