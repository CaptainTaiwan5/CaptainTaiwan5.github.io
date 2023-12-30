<?php
session_start();
echo '<a href="logout.php">登出</a>  <br><br>';
if($_SESSION['username']!=null){

}
else{
	echo "<script>alert('您尚未登入'); 
	location.href = 'account.php';</script>";
}
include("mysql.inc.php");

//如果以 GET 方式傳遞過來的 edit 參數不是空字串
if (!empty($_GET['edit'])){
  //查詢 edit 參數所指定編號的記錄, 從資料庫將原有的資料取出
  $sql="SELECT * FROM instruments WHERE 產品編號 = '{$_GET['edit']}' ";
  $result=mysqli_query($conn, $sql);
  //將查詢到的資料放在 $row 陣列
  $row=mysqli_fetch_array($result);
}
else {
  //如果沒有 edit 參數, 表示此為錯誤執行, 所以轉向回主頁面
  header("Location:instrumentsList.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>8度產品資料表-修改</title>
</head>
<body>
  <!--定義一個編輯資料的表單, 並且將編輯好的資料
      傳遞給 teachersUpdate.php 進行處理 -->
  <form method="post" action="instrumentsUpdate.php">
    產品編號: <?php echo $row['產品編號'];?>
	產品名稱: <input name="name" value="<?php echo $row['產品名稱'];?>" style="width: 73px">
	價錢: <input name="price" value="<?php echo $row['價錢'];?>" style="width: 73px">
	是否庫存: <input name="instock" value="<?php echo $row['是否庫存'];?>" style="width: 73px">
    <!--將編號設定於隱藏的 <input> 標籤,
        以便將編號數字傳遞給 3-3.php -->
    <input name="number" type="hidden" value="<?php echo $row['產品編號'];?>">
    <input name="submit" type="submit" value="送出">
  </form>
  <p><a href="instrumentsList.php">回系統首頁</a></p>
</body>
</html>