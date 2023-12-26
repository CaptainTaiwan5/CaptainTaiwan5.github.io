<?php
session_start();
echo '<a href="logout.php">登出</a>  <br><br>';
if($_SESSION['username']!=null){
	
}
else{
	echo "<script>alert('您尚未登入'); 
	location.href = 'account.php';</script>";
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>選單</title>
  <meta charset="UTF-8">
  <style>
    table {border:1px solid black; width:1000px;text-align:center}
	.grey {background-color:lightgrey}
	#h1,#h3 {width:20%}
  </style>
</head>
<body align="center">
	<input type="button" value="學生資料表" onclick="location.href='studentsList.php'" style="width:120px;height:40px;font-size:20px;"></br></br>
	<input type="button" value="教師資料表" onclick="location.href='teachersList.php'" style="width:120px;height:40px;font-size:20px;"></br></br>
	<input type="button" value="產品資料表" onclick="location.href='instrumentsList.php'" style="width:120px;height:40px;font-size:20px;"></br></br>
	<input type="button" value="留言資料表" onclick="location.href='guestbookList.php'" style="width:120px;height:40px;font-size:20px;"></br></br>
</body>
</html> 