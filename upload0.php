<?php 

	session_start();
	if($_SESSION["login"] == NULL){
		echo '<script language="JavaScript">;alert("請登入!");history.go(-1);</script>;';
		header("location:login.php");
		}
	else{
		$user = $_SESSION["login"];
		//echo "您好,".$user;
		}
	
	include("global.php");
	$link = mysqli_connect($HOST,$USER,
                          $PASS,$DB)
        or die("無法開啟MySQL資料庫連接!<br/>");
	
   mysqli_query($link, 'SET NAMES utf8'); 
   
   $sql = "SELECT * FROM `registered` WHERE `member_id` = $user";
	
   
   $result = mysqli_query($link, $sql);
	$row = mysqli_fetch_assoc($result);
	//$info = array($row['name'],$row['email']);
	$name = $row['name'];
	$email = $row['email'];
	
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>上傳壓縮檔案</title>
</head>
<style>
.button {
    display: inline-block;
    text-align: center;
    vertical-align: middle;
    padding: 5px 10px;
    border: 1px solid #4b74a6;
    border-radius: 8px;
    background: #7bbeff;
    background: -webkit-gradient(linear, left top, left bottom, from(#7bbeff), to(#4b74a6));
    background: -moz-linear-gradient(top, #7bbeff, #4b74a6);
    background: linear-gradient(to bottom, #7bbeff, #4b74a6);
/*     -webkit-box-shadow: #80c6ff -0px 0px 17px 0px;
    -moz-box-shadow: #80c6ff -0px 0px 17px 0px; 
    box-shadow: #80c6ff -0px 0px 17px 0px;*/
    text-shadow: #365377 1px 1px 2px;
    font: normal normal bold 15px 微軟正黑體;
    color: #ffffff;
    text-decoration: none;
}
.button:hover,
.button:focus {
    border: 1px solid ##6ba5ed;
    background: #94e4ff;
    background: -webkit-gradient(linear, left top, left bottom, from(#94e4ff), to(#5a8bc7));
    background: -moz-linear-gradient(top, #94e4ff, #5a8bc7);
    background: linear-gradient(to bottom, #94e4ff, #5a8bc7);
    color: #ffffff;
    text-decoration: none;
}
.button:active {
    background: #4b74a6;
    background: -webkit-gradient(linear, left top, left bottom, from(#4b74a6), to(#4b74a6));
    background: -moz-linear-gradient(top, #4b74a6, #4b74a6);
    background: linear-gradient(to bottom, #4b74a6, #4b74a6);
}
.button:before{
    /* content:  "\0000a0"; */
    display: inline-block;
    height: 24px;
    width: 24px;
    line-height: 24px;
    margin: 0 4px -6px -4px;
    position: relative;
    top: 3px;
    left: 0px;
    background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAA7EAAAOxAGVKw4bAAAEyElEQVRIia2Va2xTZRjHf+fSrbRbYTh3010YY0Ecg8UoIETJ5APRDAYqfFliMqIJIpcgiSFZREOMH4xRol8MJCgYYzSBqENuMcIYlxmGLhtzA9Z1967b2q7t2p6257x+OGdQjSEu8UmenJw37/n/n///fc77KMwx6isoWFvI6ifmkyuniI1rxOaK8dC4tC//uBi7Ioy+MyJw6UOt8/PNV7/bntlYaMf+vxBc2F34vZgZFiI8JER4WIioV4jRy6Lv2JbeT2pZ98/98pwZhAAtaGUAZnxgy6F8yweVr7/73q8nXnE0pm9X567BgEQIdAMQJqHJjHPJBvXl3frRYPiwb895mgGUucI3rBDbyueHl0naFGS6QE+BHgM9DqkotgUlUnFWZEPbjd4vh2aIKtW5ZD1XREW3n4BZ3sNj06LkNqevc1mkqwXJfY7MhY+APQdSUUjFITlDdmGpMz9w1fjmlvaL8tlm9jUdbDi94/lHG1+rkVZvLJ5eoM2IaE8Av+nB32NtKetddparKmo8rpFy/4azsAhsDkjFTDUCpITv8WNnh76QTm7lcMPeXU04S028RIDkpJuhwUHP9NhQq7t/9OLxNtF6pg+PpTAXKFuaS+UbT7HjxSXUFpcX4Fi3E3TdKkmgjXexcc/pFWo0QRK/G2Tn/YJtOaWUL1xURo1RVpMKNtS9OsTw6Mi98KS35fadiYtHr9B6aZBb+8/z82CIQ++4vPsc2iBIDvPQdci021icS4l628c9ERxAyi4GYTxwRRZmE8uCjNxCyvMeq0A2KlbUTjdu3e412tu7Lqx7P/TSp9c5tHE56wsM/0rQTAJDgqk2ZAVZvTpMT8Q/QXZewCSQhNlbae1nPoRpkAx2yS9nTIUqzTdCsmteD7K2El0zwf3doA2AAmq3l2GfPxTK1vwuMB6AK2ngzKoxEKN38d0YJzxjdlzTC1Q9syZ/E8Y06EkI3QPNDzKkkhhqzCA4FdQGFwe6q8jKBRRThSxM/PtKdPQ+D972KKMaoa86+OhoA7X1dTnH5+dlOtD6IDaBeQAQ9cFIiEkVSPijuImPVWF4weEEuwMkG8hSWoPqiDxw1KgY4yLYtFp5u3yRrVJRk5C4a9prs0xLwEA/oevDeFSA8QjdqGxCFUAE9AikAFk2U5FAAtUFOTmw6klKEEkQCVNlpln4bMZuQ4ePlnAcnwrQ4eV3AUgq5u2kYlajGlZaa4qVkpVYf4ZhgRuQ6oTREVInOjgCGCrA5X7uxDRwuCwAmykTAWSlrSkWUfodLCwCDZLXwOeGZg9fn/2TFqztdI0x7AsTKivAhQ3ENPjbTVtzykBZDuSnkchpCjQQ/RBphUAcrvho2f8TB60STYKETnAihKfMRrUYg4luGBFEFZAjHuxON2QVQeZSkAsAO4gU6JMQvQPTg5AQ0Ozh1IEf2WsYeGcFzs6D1PQUbr2Lat8E9KfwHjjHTv8M8bfWsmtNEbX5fhxqG6jzQLE6mRREkhi3/PQcu8mR5k6+BUJpBj4YOCMxusaD1P8RpevN0+wYmOImYOw+RWuWnWV1VdSuKuHpXCcFGSpyWCPUO0HPD51c7vVyDfDxsOu+rppnP67npCODCv59lMqmObisdDDHiSgDGXP54L/EX5ztNQw3UOoSAAAAAElFTkSuQmCC") no-repeat left center transparent;
    background-size: 100% 100%;
}
.font_text01 {
    font-size: 14px;
    line-height: 24px;
    color: #1F4262;
    font-family: "微軟正黑體";
}
</style>

<body style="background-color:#FFFFFF;">
     <p><img src="http://120.108.221.200/images/title_07_18.png" width="146" height="45" /></p>
<form action="doAction.php?id=<?php echo $user ?>" method="post" enctype="multipart/form-data">
	
	<h3 class="font_text01">上傳壓縮檔  (檔案大小請小於10MB)</h3>
    <!-- 限制上傳檔案的最大值 -->
    <input type="hidden" name="MAX_FILE_SIZE" value="10485760" >
	<span class="font_text01">
	計畫編號：</span>
      <input name="project_num" type="text" id="project_num" /></br>
 
    <!-- accept 限制上傳檔案類型accept="image/jpeg,image/jpg,image/gif,image/png" 。多檔案上傳 name 的屬性值須定義為 array -->
	
    <input type="file" name="myFile[]" style="display: block;margin-bottom: 5px;">
    <input type="file" name="myFile[]"  style="display: block;margin-bottom: 5px;">
    <input type="file" name="myFile[]" style="display: block;margin-bottom: 5px;">
    <input type="file" name="myFile[]" style="display: block;margin-bottom: 5px;">
 
    <!-- 使用 html 5 實現單一上傳框可多選檔案方式，須新增 multiple 元素 -->
    <!-- <input type="file" name="myFile[]" id="" accept="image/jpeg,image/jpg,image/gif,image/png" multiple> -->
	<input type="hidden" name="info01" value="<?php echo $name ?>">
	<input type="hidden" name="info02" value="<?php echo $email ?>">
 
    <br><input type="submit" class="button" value="上傳檔案">
</form>
 
</body>
<style type="text/css">
	body{
		background: #FFF;
		margin-left: 20px;
	}
</style>

</html>