<?php 
//檢查登入狀態
session_start();

	if($_SESSION["login"] == NULL)
	{
		echo '<script language="JavaScript">;alert("請登入!");</script>;';
		header("location:index.php");
		exit();
	}
	else
	{
		$user = $_SESSION["login"];
	}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>報名</title>
</head>

<header id="header">
    <nav>
        <h2>科技部研討會報名PHP測試</h2>
    </nav>
</header>

<body>

<script>
  tp=new Array();
  tp[1]=["參加", "不參加"];	
  tp[2]=["繳費參加", "不參加"];	


  function renew(index)
  {
    for(var i=0;i<tp[index].length;i++)
      document.getElementById("s1").options[i]=new Option(tp[index][i], tp[index][i]);	// 設定新選項
    document.getElementById("s1").length=tp[index].length;	// 刪除多餘的選項
  }
      
  var fileds = ["name","sex","affiliction","department","position","phone","email","accommodation","diet","cater","conducter","dinner","shuttle"];
      
  //資料檢查
  function datacheck()
  {
    for(var i=0;i<14;i++){
      if (document.form1.fileds[i].value == ""){
        alert("欄位不得為空白！");
        
        return false;
      }
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
<form class="container"  action="doapply.php?user=<?php echo $user ?>" method="POST" enctype="multipart/form-data" name="form1" id="form1" >

  <table >
	  <tr ><td><h4>基本資料</h4></td><td></td></tr>
    <tr>
      <td width="170"> 姓名</td>
      <td width="330">
      <input name="name" type="text" id="name" required/></td>
    </tr>
    <tr>
      <td>性別</td>
      <td>
          
           <input name="sex" type="radio" id="sex_0" 
           value="男" checked="checked" />男         
            <input name="sex" type="radio" value="女" id="sex_1" />女
          <br>
     </td>
    </tr>
    <tr>
      <td>學校</td>
      <td>
      <input name="affiliation" type="text" id="affiliation" required/></td>
    </tr>
     <tr>
      <td>系別</td>
      <td>
      <input name="department" type="text" id="department" required/></td>
    </tr>
    <tr>
      <td>職稱</td>
      <td>
      <input name="position" type="text" id="position" required/></td>
    </tr>
	<tr>
	  <td>身分別</td>
		<td>
		
		<select style="width:150px;" size=1 name="conducter" onChange="renew(this.selectedIndex);" required>
		<option disabled selected value> 請選擇 </option>
		<option value="Y">主持人
		<option value="N">非主持人
		</select>
		
			
		
		
          <br> 
		
		</td>
	</tr>
    <tr>
      <td>行動電話</td>
      <td>
      <input name="phone" type="text" id="phone" required/></td>
    </tr>
    <tr>
      <td>EMAIL</td>
      <td>
      <input name="email" type="email" id="email" required/></td>
    </tr>
	  <tr><td><br><h4>活動調查</h4></td><td></td></tr>
	<tr>
      <td>住宿需求調查</td>
      <td>          
           <input name="accommodation" type="radio" 
           value="Y" required/>是         
           <input name="accommodation" type="radio" value="N" />否
          
     </td>
    </tr>
      <td>葷素</td>
      <td>
         
		 <input name="diet" type="radio"  value="葷" required />葷         
         <input name="diet" type="radio" value="素" />素
          <br>
		 <br>
     </td>
    </tr>
	<tr>
      <td><lable>用餐需求</lable></td>
		<td>
			<ul>
　				<li><input name="cater[]" type="checkbox"
           value="15" checked="checked" />11/15中午</li>
　			<li><input name="cater[]" type="checkbox"
           value="16" checked="checked" />11/16中午</li>
			</ul>
			<br>
		</td>
	</tr>
	<tr>
	<tr>
      <td>是否參加晚宴</td>
      <td>
	<select style="width:150px;" id="s1" size=1 name="dinner">
		<option value="">請先選取身分
	</select>
		  <br><label style="font-size: 9pt;">非計畫主持人參加晚宴僅保留座位，入場需付850元(不包含10%服務費)</label>
	</td>
    </tr>
	<tr>
	</tr>
	  <tr><td><br><h4>交通調查</h4></td><td></td></tr>
	<tr>	
      <td><lable>高鐵接駁需求</lable><br><lable style="font-size: 9pt;">(若無須接駁則皆不勾選)</lable></td>
		<td>
			<ul>
　				<li><input id="s01" name="shuttle[]" type="checkbox"
           value="15" />11/15去程(由高鐵站往國資圖)</li>
　				<li><input name="shuttle[]" type="checkbox"
           value="16" />11/16回程(由國資圖往高鐵站)</li>
			</ul>
		</td>
	</tr>
<tr>
		
      <td><br><lable>國立公共資訊圖書館地下停車場停車需求</lable></td>
		<td>
			<br><input name="parking" type="radio"
           value="Y" checked="checked"/>是
				<input name="parking" type="radio"
           value="N"  />否
			
		</td>
	</tr>

  </table>
  <br><br><p>
     <input class="button" type="submit" name="button2" id="button2" value="報名" />
     <span>　</span>
     <input type="button" class="button" value="上一頁" onclick="history.back()">
	
  </p>
</form>

</div>

</body>
<style type="text/css">

	tr td{
		height: 32px;
		
	}
	ul{
		margin:0; padding:0;
		font-size: 0pt;
		letter-spacing: -1px;
    	word-spacing: -1px;
	}
	ul li{
		list-style-type: none;
    	height: 30px;
    	font-size: 16px;
    	letter-spacing: normal;
    	word-spacing: normal;
    
	}
	td{
		vertical-align: top;
	}
	
	
	</style>
</html>