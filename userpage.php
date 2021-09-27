<?php
###################################
#############使用者頁面############
#############篩選群組圖片##########
#############新增圖片##############
###################################

include ("configure.php");
$link = new PDO('mysql:host='.$hostname.';dbname='.$database.';charset=utf8', $username, $password);
session_start();
$_SESSION['surch'] = isset($_SESSION['surch'])?$_SESSION['surch']:0;
$_SESSION['filter'] = isset($_SESSION['filter'])?$_SESSION['filter']:NULL;
$link = new PDO('mysql:host='.$hostname.';dbname='.$database.';charset=utf8', $username, $password);

/*Table 格數*/
if (isset($_GET['num']))
	$_SESSION['num'] = $_GET['num'];
elseif (!isset($_SESSION['num']))
	$_SESSION['num'] = 6;
else
	$_SESSION['num'] = $_SESSION['num'] ;

/*確認使用者*/
if (isset($_GET['account']))
{
	$account = $_GET['account'];
	$_SESSION['account'] = $_GET['account'];
	$query = "SELECT * FROM `user` WHERE `account` = '$account';";
	$result = $link->query($query);
	foreach($result as $row)
	{
		$name = $row['name'];
	}
}
elseif (isset($_SESSION['account']))
{
	$account = $_SESSION['account'];
	$query = "SELECT * FROM `user` WHERE `account` = '$account';";
	$result = $link->query($query);
	foreach($result as $row)
	{
		$name = $row['name'];
	}
}
else
{
	header("location:error.php");
}

/*清除選取圖片*/
$i =  1;
if (isset($_GET['role']))
{
	$_SESSION['filter'] = $_GET['role'];
	$_SESSION['surch'] = 1;
	while(isset($_SESSION["file$i"]))
	{
		unset($_SESSION["file$i"]);
		$i++;
	}
}
elseif (isset($_GET['groupname']))
{
	if ($_GET['groupname'] == "all")
	{
		$_SESSION['surch'] = 0;
		while(isset($_SESSION["file$i"]))
		{
			unset($_SESSION["file$i"]);
			$i++;
		}
	}
	else
	{
		$_SESSION['filter'] = $_GET['groupname'];
		$_SESSION['surch'] = 2;
		while(isset($_SESSION["file$i"]))
		{
			unset($_SESSION["file$i"]);
			$i++;
		}
	}
}
/*全部圖片*/
elseif ($_SESSION['filter'] == NULL)
{
	$_SESSION['filter'] = "all";
	$_SESSION['surch'] = 0;
}
?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title><?php echo $name;?>的小屋</title>
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
		
		/*一些背景*/
		body {
			font-size:24;
			color: #FFF;
			background-color: #4f4f4f;
			text-align: center;
		}
		.divleft {
			display:inline;
			width: 200px;
			margin-left: 150px;
			margin-top: 20px;
		}
		.divmediate {margin-top: 20px; width:auto;}
		.divtop {position: absolute; display:table; width: auto; margin-top: 50px; }
		.divout {width:auto; }
		
		div {font-family:Microsoft JhengHei; color: #fff width:auto; }
		/*圖片大小*/
		img.img6{width:150; height:150;}
		img.img5{width:175; height:175;}
		img.img4{width:200; height:200;}
		img.img3{width:250; height:225;}
		img.img2{width:350;	height:250;}
		img.img1{width:600;}
		
		/*字型大小*/
		div.div6{font-size:20; margin-left:16;}
		div.div5{font-size:20; margin-left:20;}
		div.div4{font-size:20; margin-left:20;}
		div.div3{font-size:23; margin-left:20;}
		div.div2{font-size:28; margin-left:35;}
		div.div1{font-size:35; margin-left:50;}
		ul li{
			list-style-type:none;
			list-style:none;
		}
		input {
			display:inline;
			margin-left:-5;
			height:35;
		}
		.select {
			color:white;
			text-align-left:right;
			padding-left:23px;
			direction:ltr;
			background: #4f4f4f;
		}
	</style>
</head>
<body>
	<div class="divtop" id="menu" style="right:125;  width:auto; font-family:Microsoft JhengHei;">
		<ul>
			<li><a href="userpage.php">首頁</a></li>
			<li><a>上傳檔案</a>
				<ul>
					<li><a href="upfile.php" >單一檔案</a></li>
					<li><a href="upfile2.php" >多個檔案</a></li>
				</ul>
			</li>
			<li><a>格數</a>
				<ul>
					<?php 	
					for ($i=1; $i<=6; $i++)
					{	
						echo "<li><a href='userpage.php?num=$i'>$i</a></li>"; 
					}
					?>
				</ul>
			</li>
			<li> <a href="userpage.php">設定</a>
				<ul>
					<li><a href='index.php'>登出</a></li>
				</ul>
			</li>
		</ul>
	</div>
	<br><br><br><br><br>
	<!--左方列表-->
	<div class="divleft" style="float:left;">
		<ul style="text-align:left; margin-left:0px">
			<li><a style='color:white' href='userpage.php?groupname=all'>全部</a><hr></li>
			<?php

				$query = "SELECT * FROM `picture` GROUP BY `groupname`";
				$result = $link->query($query);
				foreach ($result as $row)
				{
					$groupname = $row['groupname'];
					echo "<li><a style='color:white' href='userpage.php?groupname=$groupname'>$groupname</a><ul style='margin-left:30px'>";
					$query = "SELECT `role` FROM `picture` WHERE `groupname` LIKE '$groupname' GROUP BY `role`";
					$result1 = $link->query($query);
					foreach ($result1 as $row1)
					{
						$role = $row1["role"];
						echo "<li><div style='text-align:right; line-height:35px;'><a style='color:white; text-align:right;' href='userpage.php?role=$role'>$role</a></div></li>";
					}
					echo "</ul><hr></li>";
				}
			?>
			
		</ul>
	</div>
	<div class="divmediate">
		<table align="center" border="1">
			<?php
				//選擇圖片
				$filter = $_SESSION['filter'];
				if ($_SESSION['surch'] == 1)
				{
					$query = "SELECT * FROM `picture` WHERE `role` = '$filter' ;" ;
				}
				elseif ($_SESSION['surch'] == 2)
				{
					$query = "SELECT * FROM `picture` WHERE `groupname` = '$filter' ;";
				}
				elseif ($_SESSION['surch'] == 0)
				{
					$query = "SELECT * FROM `picture` ;";
				}
				$result = $link->query($query);
				$num = $_SESSION['num'];
				while (1)
				{
					echo "<tr>";
					$i = 1;
					$j = 1;
					foreach ($result as $row)
					{
						$_SESSION["file$j"] = $row["url"];
						$url = $row["url"];
						$name =$row["name"];
						echo "<td><img class='img$num' src='$url'><hr><div class='div$num'><a style='color:white'  href='picture.php?url=".substr($url,-100,100)."&account=$account' target=\"_parent\">$name</a></div></td>" ;
						if (++$i == $num+1)
						{
							$i = 1;
							echo "</tr>";
						}
						$j++;
					}
					if (next($result)==NULL)
						break;
				}
			?>
		</table>
	</div>
</body>
</html>
