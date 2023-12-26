<?php
session_start(); 
if(isset($_POST['submit'])){
//連接資料庫
//只要此頁面上有用到連接MySQL就要include它

$id = $_POST['account'];
$pw = $_POST['password'];

//搜尋資料庫資料
$sql = "SELECT * FROM users where account = '$id'";
$dbServer = "localhost";
$dbUser = "root";
$dbPass = "";
$dbName = "";

//連線資料庫伺服器
$conn = @mysqli_connect($dbServer, $dbUser, $dbPass, $dbName);
$result = mysqli_query($conn,$sql);
$row = @mysqli_fetch_row($result);

//判斷帳號與密碼是否為空白
//以及MySQL資料庫裡是否有這個會員
if($id != null && $pw != null && $row[0] == $id && $row[1] == $pw)
{
        //將帳號寫入session，方便驗證使用者身份
        $_SESSION['username'] = $id;
        echo "<script>alert('登入成功'); location.href = 'select.php';</script>";
}
else
{
        echo "<script>alert('輸入錯誤'); location.href = 'account.php';</script>";
}

}
?>

<!DOCTYPE html>
<html>
<head>
  <title>帳號登入</title>
  <meta charset="UTF-8">
  <style>
    table {border:1px solid black; width:1000px;text-align:center}
	.grey {background-color:pink}
	#h1,#h3 {width:20%}
  </style>
</head>
<body align="center">
<img src="images/8.jpg" width="25%" height="25%">
  <form method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
	帳號: <input name="account" style="width: 73px"></br></br>
    密碼: <input name="password" type="password" style="width: 73px"></br></br>
    <input name="submit" type="submit" value="確定"></br></br></br></br>
	<b>我們用音樂成就品格</b></br></br>
	<b>就算穿著素白T-shirt 仍然散發出不平凡的氣質</b>
  </form>
</body>
</html>