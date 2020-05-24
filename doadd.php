<?php 

include("global.php");

	  $link = mysqli_connect($HOST,$USER,
                          $PASS,$DB)
        or die("無法開啟MySQL資料庫連接!<br/>");
	  mysqli_query($link, 'SET NAMES utf8');

$temp_name = $_POST['username'];
$getDate= date("Y-m-d");

$sql = "INSERT INTO `registered` VALUES ( NULL ,'$_POST[username]','$_POST[password]', '$_POST[name]', '$_POST[sex]', '$_POST[birthday]','$_POST[tel]', '$_POST[email]', '$_POST[addr]', '$getDate')";  //新增資料


mysqli_query($link, $sql) or die ("無法新增" . mysqli_error()); 


mysqli_close($link); 	//關閉資料庫連結
header('Location: dologout.php');
exit(); 
?>