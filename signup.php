<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>註冊</title>
</head>

<header id="header">
    <nav>
        <h2>科技部研討會報名PHP測試</h2>
    </nav>
</header>


<body>

<script>
	
	function datacheck()
{
   if (document.form1.name.value == ""){
      alert("姓名欄位不得為空白！");
      return false;
   }
   if (document.form1.email.value == ""){
      alert("Email欄位不得為空白！");
      return false;
   }
   if (document.form1.password.value == ""){
      alert("密碼欄位不得為空白！");
      return false;
   }
	
	emailRule = /^\w+((-\w+)|(\.\w+))*\@[A-Za-z0-9]+((\.|-)[A-Za-z0-9]+)*\.[A-Za-z]+$/;
   if (document.form1.email.value.search(emailRule)== -1){
      alert("Email格式錯誤！");
      return false;
   }	

   return true;
}
	
</script>
  
  
<div id="content">
<form class="container"  action="dosignup.php" method="POST" enctype="multipart/form-data" name="form1" id="form1" onsubmit="return datacheck();">

  </br>
  <p><img src="http://120.108.221.200/images/title_06_18.png" width="146" height="45" /></p>
	<h3 class="font_text01" >註冊</h3>
  <table width="500">
      <tr>
      <td class="font_text01">姓名</td>
      <td>
      <input name="name" type="text" id="name" /></td>
    </tr>
	  <tr>
      <td class="font_text01">電子郵件</td>
      <td>
      <input name="email" type="text" id="email" /></td>
    </tr>
    <tr>
      <td class="font_text01">密碼</td>
      <td>
      <input name="password" type="text" id="password" /></td>
    </tr>
    </table><br />
  
  <p>
     <input type="submit" name="button2" id="button2" class="button" value="註冊" />
	&nbsp;&nbsp;
	<a class="button" style="color:#FFF;" href="index.php">上一頁</a>
  </p>
</form>
</div>
</body>
</html>