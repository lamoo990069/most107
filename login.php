<?php
session_start();  // 啟用交談期
$username = "";  $password = "";
	  
// 取得表單欄位值
	
if ( isset($_POST["Username"]) )
   $username = $_POST["Username"];
if ( isset($_POST["Password"]) )
   $password = $_POST["Password"];

	
// 檢查是否輸入使用者名稱和密碼
if ($username != "" && $password != "") {
	
   // 建立MySQL的資料庫連接 
	include("global.php");
	$link = mysqli_connect($HOST,$USER,
                          $PASS,$DB)
        or die("無法開啟MySQL資料庫連接!<br/>");
	
   mysqli_query($link, 'SET NAMES utf8'); 
   
   $sql = "SELECT * FROM `registered` WHERE `email`='$username' AND `password` = '$password'";
	
   
   $result = mysqli_query($link, $sql);
   $total_records = mysqli_num_rows($result);
	while ($row = mysqli_fetch_assoc($result)) {
    $id = $row['member_id'];
	}
	
   // 是否有查詢到使用者記錄
   if ( $total_records > 0 ) {
      // 成功登入, 指定Session變數
      $_SESSION["login"] = $id;
	  echo $id;
      header("Location:index.php");
	  exit(); 
	  
   } else {  // 登入失敗
      echo "<center><font color='red'>";
      echo "使用者帳號或密碼錯誤!<br/>";
      echo "</font>";
      $_SESSION["login"] = false;
   }

   	mysqli_close($link);  // 關閉資料庫連接  
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登入頁面</title>
</head>

<header id="header">
    <nav>
        <h2>科技部研討會報名PHP測試</h2>
    </nav>
        </header>

<style>
input{
	/* border:0; */
  background-color:#c3d9ec;
  color:#fff;
  border-radius:10px;
  cursor:pointer;}

input:hover{
  color:#003C9D;
  background-color:#fff;
  border:2px #003C9D solid;
}

.font_text01 {
    font-size: 14px;
    line-height: 24px;
    color: #1F4262;
    font-family: "微軟正黑體";
}
</style>
<form class="container" action="login.php" method="post"  align="center">
<div id="content">
	<table align="center" width="250px">
 	<tr>
		<td><font size="2">使用者信箱:</font></td>
   		<td><input type="text" name="Username" 
             size="15" maxlength="60"/>
   		</td>
	</tr>
 	<tr>
		<td><font size="2">使用者密碼:</font></td>
   		<td><input type="password" name="Password"
              size="15" maxlength="30"/>			  
 		</td>
	</tr>
</table>
</br>
 <table align="center" width="250px">
 	<tr align="center">
		<td><a class="button" href="signup.php" style="color:#FFF;" >註冊</a></td>
		<td>
   		<input style="color:#FFF;" type="submit" class="button" value="登入"/>
   		</td>
	</tr> 		
	</table>
	
</form>
</div>
</html>
