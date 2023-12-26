<?php
session_start();
echo '<a href="logout.php">登出</a>  <br><br>';
echo '<a href="select.php">回前頁</a>  <br><br>';
if($_SESSION['username']!=null){

}
else{
	echo "<script>alert('您尚未登入'); 
	location.href = 'account.php';</script>";
}
include("mysql.inc.php");
$perpage=25;  // 每頁顯示 25 筆
$sql="SELECT count(學生編號) FROM students";
$result=mysqli_query($conn, $sql);
$count=7 ;
//取得查詢結果的筆數
$totalrow=mysqli_fetch_array($result)[0];
$totalpage=ceil($totalrow/$perpage);  // 計算總頁數

//如果網頁表單的所有欄位都不是空字串
if (!empty($_POST['number']) && !empty($_POST['name']) ){
  //將所有欄位值新增至 【students】 資料表
  $sql="INSERT students (學生編號,學生姓名,電話,生日,學習科目,是否仍在學,備註)
        VALUES ('{$_POST['number']}' ,'{$_POST['name']}','{$_POST['phone']}','{$_POST['birthday']}','{$_POST['subject']}','{$_POST['atschool']}','{$_POST['another']}')";
  mysqli_query($conn, $sql);
}

// 根據 $_GET['page'] 參數值決定從第幾頁開始顯示
// 代表頁次的變數 $page 由 1 起算
if(empty($_GET['page']) || !is_numeric($_GET['page']) ||  $_GET['page']<1 || $_GET['page']>$totalpage ) 
	$page=1;
else 
	$page=$_GET['page'];

// 根據 $_GET['order'] 參數值決定排序方式
if(empty($_GET['order']) || !is_numeric($_GET['order']) || $_GET['order']<1 || $_GET['order']>6) {
	$field='學生編號'; // SQL 查詢時的排序參數 
	$order=0;          // 建立頁次連結時使用的參數
}
else if($_GET['order']==1) {
	$field='學生姓名';
	$order=1;
}
else if($_GET['order']==2) {
    $field='電話';
	$order=2;
}
else if($_GET['order']==3) {
    $field='生日';
	$order=3;
}
else if($_GET['order']==4) {
    $field='學習科目';
	$order=4;
}
else if($_GET['order']==5) {
    $field='是否仍在學';
	$order=5;
}
else if($_GET['order']==6) {
    $field='備註';
	$order=6;
}


// 設定查詢 LIMIT 子句的第 1 個參數
$start=($page-1)*$perpage;  	
	
//查詢【students】資料表的記錄
$sql = "SELECT * FROM students ORDER BY $field "."LIMIT $start, $perpage";
echo '<br>';

$result=mysqli_query($conn, $sql);

//取得查詢結果
while($row=mysqli_fetch_array($result)) 
	$data[]=$row;
?>
<!DOCTYPE html>
<html>
<head>
  <title>8度學生資料表</title>
  <meta charset="UTF-8">
  <style>
    table {border:1px solid black; width:1000;text-align:center}
	.grey {background-color:lightgrey}
	#h1,#h3 {width:11%}
  </style>
</head>
<body align="center">
  <form method="post" action="<?php $_SERVER["PHP_SELF"] ?>">
	學生編號: <input name="number" style="width: 73px">
    學生姓名: <input name="name" style="width: 73px">
	電話: <input name="phone" style="width: 73px">
	生日: <input name="birthday" style="width: 73px">
	學習科目: <input name="subject" style="width: 73px">
	是否仍在學: <input name="atschool" style="width: 73px">
	備註: <input name="another" style="width: 73px">
    <input name="submit" type="submit" value="新增">
  </form>
<p>目前資料筆數：<?php echo $totalrow;?> </p>
<table align="center">
<tr>
<th id="h1"><a href="<?php $_SERVER['PHP_SELF']?>?order=0">學生編號</a></th>
<th id="h3"><a href="<?php $_SERVER['PHP_SELF']?>?order=1">學生姓名</a></th>
<th id="h3"><a href="<?php $_SERVER['PHP_SELF']?>?order=2">電話</a></th>
<th id="h3"><a href="<?php $_SERVER['PHP_SELF']?>?order=3">生日</a></th>
<th id="h3"><a href="<?php $_SERVER['PHP_SELF']?>?order=4">學習科目</a></th>
<th id="h3"><a href="<?php $_SERVER['PHP_SELF']?>?order=5">是否仍在學</a></th>
<th id="h3"><a href="<?php $_SERVER['PHP_SELF']?>?order=6">備註</a></th>
<?php
// 用迴圈輸出目前頁次的資料
if($page == $totalpage){
	if(($totalrow % $perpage)!=0){
		$count = $totalrow -$start;
	}else{
			$count =$perpage;
	}
}else{
	$count = $perpage;
}

for($i=0;$i<$count;$i++){
  if($i%2==0) echo '<tr class="grey">';  // 雙數行加灰底
  else echo '<tr>';
  echo "<td>{$data[$i]['學生編號']}</td>";
  echo "<td>{$data[$i]['學生姓名']}</td>";
  echo "<td>{$data[$i]['電話']}</td>";
  echo "<td>{$data[$i]['生日']}</td>";
  echo "<td>{$data[$i]['學習科目']}</td>";
  echo "<td>{$data[$i]['是否仍在學']}</td>";
  echo "<td>{$data[$i]['備註']}</td>";
  echo "<td><a href='studentsEdit.php?edit={$data[$i]['學生編號']}'>編輯</a></td>";
  echo "<td><a href='studentsDel.php?del={$data[$i]['學生編號']}'>刪除</a></td></tr>";
  echo '</tr>';
}
echo '</table>';

// 輸出直接跳頁的連線
for($i=1;$i<=$totalpage;$i++){
  if($i!=1) echo "&nbsp;";
  if($i==$page) echo $i;
  else
    echo sprintf('<a href="%s?page=%d&order=%d">%d</a>',
                 $_SERVER['PHP_SELF'], $i , $order, $i);  
}
?>
</body>
</html>