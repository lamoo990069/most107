<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>註冊</title>
</head>
<body>

    <nav>
        <h2>科技部研討會報名PHP測試</h2>
    </nav>
    <div id="content">

<?php 
require("send_apply_mail.php");
include("global.php");

	  $link = mysqli_connect($HOST,$USER,
                          $PASS,$DB)
        or die("無法開啟MySQL資料庫連接!<br/>");
	  mysqli_query($link, 'SET NAMES utf8');

if(isset($_POST['email']) && isset($_POST['password'])&& isset($_POST['name']) ){
	$email = $_POST['email'];
	$password = $_POST['password'];
	$name = $_POST['name'];
}
else{
	echo '<script language="JavaScript">;alert("資料輸入有誤!");history.go(-1);</script>;';
	exit();
}

$sql0 = "SELECT * FROM `registered` WHERE `email`='$email'";
$result0 = mysqli_query($link, $sql0);
$total_records = mysqli_num_rows($result0);

	if($total_records != 0){
		echo '<script language="JavaScript">;alert("此帳號已被註冊!");history.go(-1);</script>;';
		exit();	
		mysqli_free_result($result0);
	}
	
$sql = "INSERT INTO `registered` VALUES ( NULL,'$_POST[name]','$_POST[email]','$_POST[password]')";

mysqli_query($link, $sql) or die ("無法新增" . mysqli_error()); 


mysqli_close($link); 	//關閉資料庫連結

//include("sendmail01.php");
	echo $name ."，您已註冊成功"."<br>";
		echo "帳號：".$email."<br>";
		echo "密碼：" . $password."<br>"; 
		echo "<br>"."系統已同步發至您的信箱!";

	
//***********
SendEmail($email ,"107年度應用科學教育學門研討會網站註冊成功信" ,$name."您好，感謝您的註冊。"."<br>"."登入資訊如下："."<br>"."帳號：".$email."<br>"."密碼：".$password."<br>"."<hr>"."107年度應用科學教育學門成果發表暨研討會(http://most.ntcu.edu.tw/)");      
      
header("refresh:2;url=login.php");
?>

</div>
    
	</body>
	</html>