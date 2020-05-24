<?php 
	


	session_start();
	if($_SESSION["login"] == NULL){
		echo '<script language="JavaScript">;alert("請登入!");</script>;';
		header("location:index.php");
		exit();
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
   
   $sql = "SELECT * FROM `registered` WHERE `member_id` = '$user'";
	
   
   $result = mysqli_query($link, $sql);
	$row = mysqli_fetch_assoc($result);
	$name = $row['name'];
	$email = $row['email'];
	
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>檔案上傳</title>
</head>

<header id="header">
	<nav>
        <h2>科技部研討會報名PHP測試</h2>
    </nav>
        </header>


<body>
<div id="content">
	<div id="check" style="display:block">
		<form action="upload.php?id=<?php echo $user ?>" method="post">
			輸入計畫編號
			<label>MOST-</label>
			<input type="text" name="T1" maxlength="3" size="3" onKeyUp="next(this,'T2')">-  
			<input type="text" name="T2" maxlength="4" size="4" onKeyUp="next(this,'T3')">-  
			<input type="text" name="T3" maxlength="1" size="1" onKeyUp="next(this,'T4')">- 
			<input type="text" name="T4" maxlength="3" size="3" onKeyUp="next(this,'T5')">-
			<input type="text" name="T5" maxlength="3" size="3" onKeyUp="next(this,'T6')">-
			<input type="text" name="T6" maxlength="3" size="3" onKeyUp="next(this,'B1')">  
			<input type="submit" class="button" value="送出" name="B1"> 

		</form>
	</div>
	
	<div id="info" style="font-size: 11pt;">	
		<span>
		<?php 
			if(isset($_POST["T1"])&&isset($_POST["T2"])&&isset($_POST["T3"])&&isset($_POST["T4"])&&isset($_POST["T5"])){
				$pro_num = $_POST["T1"]."-".$_POST["T2"]."-".$_POST["T3"]."-".$_POST["T4"]."-".$_POST["T5"]."-".$_POST["T6"];

			
			$str="SELECT * FROM `project` WHERE `project_num` = '$pro_num'";
			$check =mysqli_query($link,$str);
			$total_records = mysqli_num_rows($check);
			if($total_records>0){
				while($rowcheck = mysqli_fetch_assoc($check)){
					echo 		"計畫編號：".$rowcheck['project_num']."<br>"."計畫名稱：".$rowcheck['project_name']."<br>計畫主持人：".$rowcheck['project_presenter'];
					
				} 
				echo '</br></br><button onClick="check();javascript:this.style.display=\'none\'" class="button" >確認計畫無誤，開始上傳</button>';

			}
			else{ 
				echo "查無此計畫編號!";
				$pro_num = "";
			}
		}
		?>
		</span>
	
		
	</div>

	<div id="files" style="display: none">
	<hr>
		<form action="doAction.php?id=<?php echo $user ?>" method="post" enctype="multipart/form-data">
			
				<h5>檔案上傳(大小請在15MB內)</br>海報發表上傳摘要即可</h5>
				
		
			<table>
			<tr>
				<td>
					<input type="file" name="myFile[]" style="display: block;margin-bottom: 5px;">
				</td>
				<td>
					<label>計畫摘要(doc、docx)</label>
				</td>
			</tr>
			<tr>
				<td>
					<input type="file" name="myFile[]" style="display: block;margin-bottom: 5px;">
				</td>
				<td>
					<label>計畫成果報告(doc、docx)</label>
				</td>
			</tr>    <tr>
				<td>
					<input type="file" name="myFile[]" style="display: block;margin-bottom: 5px;">
				</td>
				<td>
					<label>計畫成果報告(pdf)</label>
				</td>
			</tr>    <tr>
				<td>
					<input type="file" name="myFile[]" style="display: block;margin-bottom: 5px;">
				</td>
				<td>
					<label>計畫報告投影片(ppt、pptx)</label>
				</td>
			</tr>
			</table>
			
			<input type="hidden" name="MAX_FILE_SIZE" value="15728640">
			<input type="hidden" name="project_num" value="<?php echo $pro_num ?>">
		
			<!-- 使用 html 5 實現單一上傳框可多選檔案方式，須新增 multiple 元素 -->
			<!-- <input type="file" name="myFile[]" id="" accept="image/jpeg,image/jpg,image/gif,image/png" multiple> -->
			<input type="hidden" name="info01" value="<?php echo $name ?>">
			<input type="hidden" name="info02" value="<?php echo $email ?>">
		
			<br><input type="submit" class="button" value="上傳檔案">
		</form>
	</div>

</div>
<div id="project">
		<h5>計畫對照表</h5>
		<ul style="list-style: none">
			<?php
			$project="SELECT * FROM `project`";
			$project_list =mysqli_query($link,$project);
			while($list = mysqli_fetch_assoc($project_list)){
				echo"<li>".$list['project_presenter']." / ".$list['project_num']." / ".$list['project_name'];					
			}
			?> 
		</ul>
</div>
 
<script>
	function check(){
		document.getElementById("files").style.display = "block";
		document.getElementById("check").style.display = "none";
	}
	function next(obj,next) {  
	    if (obj.value.length == obj.maxLength)  
	        obj.form.elements[next].focus();      
	}
</script>
	

</body>
<style type="text/css">
	label{
		font-size: 11pt;
	}
</style>

</html>