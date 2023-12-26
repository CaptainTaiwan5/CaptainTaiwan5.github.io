<?php
session_start();
echo '<a href="logout.php">登出</a>  <br><br>';
if($_SESSION['username']!=null){

}
else{
	echo "<script>alert('您尚未登入'); 
	location.href = 'account.php';</script>";
}
header('Content-Type: text/html; charset=utf-8');
include("mysql.inc.php");

if ( !empty($_POST['number']) && !empty(['name']) && !empty(['price']) && !empty(['instock'])){
  //更新 id 參數所指定編號的記錄
  $sql="UPDATE instruments
        SET 產品名稱 = '{$_POST['name']}',價錢 = '{$_POST['price']}',是否庫存 = '{$_POST['instock']}'
        WHERE 產品編號 = '{$_POST['number']}' ";
  mysqli_query($conn, $sql);
}

//取得被更新的記錄筆數
$rowUpdated=mysqli_affected_rows($conn);

//如果更新的筆數大於 0, 則顯示成功, 若否, 便顯示失敗
if ($rowUpdated >0){
  echo "資料更新成功";
}
else {
  echo "更新失敗, 或者您輸入的資料與原本相同";
}
?>
<p><a href="instrumentsList.php">回系統首頁</a></p>
