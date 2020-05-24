<?php 

require("send_apply_mail.php");

//連接到資料庫
include("global.php");

	  $link = mysqli_connect($HOST,$USER,
                          $PASS,$DB)
        or die("無法開啟MySQL資料庫連接!<br/>");
	  mysqli_query($link, 'SET NAMES utf8');

//取得user_id
$user = $_GET['user'];

//轉換表單值
if(isset($_POST['cater'])){
	$cater = $_POST['cater'];
	$all_cater = implode (",", $cater);
}
else{
	$all_cater = null;
}
//----
if(isset($_POST['shuttle']) && $_POST['shuttle'] != ""){
	$shuttle = $_POST['shuttle'];
	$all_shuttle = implode (",", $shuttle);
}
else{
	$all_shuttle = null;
}
//----
if(isset($_POST['dinner']) && $_POST['dinner']!=""){
	$dinner = $_POST['dinner'];
	if($dinner == "不參加")
		$dinner = "N";
	else if($dinner == "參加" || $dinner == "繳費參加")
		$dinner = "Y";
}
else{
	echo '<script language="JavaScript">;alert("請選擇是否參加晚宴!");history.go(-1);</script>;';
	exit();
}



//執行查詢
$sql = "INSERT INTO `application` VALUES ( NULL,'$user', '$_POST[name]','$_POST[sex]','$_POST[affiliation]','$_POST[department]','$_POST[position]','$_POST[phone]','$_POST[email]','$_POST[accommodation]','$_POST[diet]','$all_cater','$_POST[conducter]','$dinner','$all_shuttle','$_POST[parking]')";


mysqli_query($link, $sql) or die ("無法新增" . mysqli_error($link)); 
$inserted = mysqli_insert_id($link);

//mysqli_close($link); 	//關閉資料庫連結

//***********
function DoContant($apply_id ,$link){
	$sql2 = "SELECT * FROM `application` WHERE `apply_id` = $apply_id";
	
	$result = mysqli_query($link, $sql2);
	$row = mysqli_fetch_assoc($result);
	$row2 = Trans($row);

	$contant = "報名ID：".$row["apply_id"]."<br>"."姓名職稱：".$row['name'] . "  ".$row["position"]."<br>"."性別：".$row['sex']."<br>"."校系別：".$row['affiliation'].$row['department']."<br>"."計畫主持人：".$row2['conducter']."<br>"."行動電話：".$row['phone']."<br>"."Email：".$row['email']."<br>"."住宿：".$row2['accommodation']."<br>"."午餐：(".$row['diet'].") 9/".$row2['cater']."<br>"."參加晚宴：".$row2['dinner']."<br>"."高鐵站接駁：".$row2['shuttle']."<br>"."停車需求：".$row2['parking']."<br>";
	
	return $contant;
	
}

function Trans($row){
	if($row['conducter'] == "N")
		$row['conducter'] = "否";
	else if($row['conducter'] == "Y")
		$row['conducter'] = "是";
	
	if($row['dinner'] == "N")
		$row['dinner'] = "否";
	else if($row['dinner'] == "Y")
		$row['dinner'] = "是";
	
	if($row['accommodation'] == "Y")
		$row['accommodation'] = "是";
	else if($row['accommodation'] == "N")
		$row['accommodation'] = "否";
	
	if($row['cater'] == "")
		$row['cater'] = "無";
	
	if($row['shuttle'] == "")
		$row['shuttle'] = "無";
	else{
		if($row['shuttle'] == "15")
			$row['shuttle'] = "去程(前往國資圖)";
		else if($row['shuttle'] == "16")
			$row['shuttle'] = "回程(前往高鐵站)";
		else
			$row['shuttle'] = "來回";
	}
	if($row['parking'] == "Y")
		$row['parking'] = "是";
	else if($row['parking'] == "N")
		$row['parking'] = "否";
	
	
	return $row;

}

if($inserted != null){
	SendEmail($_POST['email'] ,"報名成功確認信" ,DoContant($inserted,$link));
}

echo "您是第" . $inserted . "位報名者";
header("refresh:2;url=index.php");