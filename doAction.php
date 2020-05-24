<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>上傳結果</title>
</head>
<body>

    <nav>
        <h2>科技部研討會報名PHP測試</h2>
    </nav>
    <div id="content">

<?php
/**
 * 表單接收頁面
 */
require("send_apply_mail.php");
// 網頁編碼宣告（防止產生亂碼）
header('content-type:text/html;charset=utf-8');
// 封裝好的 PHP 多檔案上傳 function
//include_once 'upload.func.php';
// 重新建構上傳檔案 array 格式
$files = getFiles();

if(isset($_POST['project_num']) && $_POST['project_num'] != "" && $_POST['project_num'] != NULL)
	$ProNum = $_POST['project_num'];
else{
	echo '<script language="JavaScript">;alert("請確認計畫編號!");history.go(-1);</script>;';
	exit();
}
	

$id = $_GET['id'];
$user = $_POST['info01'];
$email = $_POST['info02'];
$suc = false;


$j = 1;
$NameList[] = "";
// 依上傳檔案數執行
foreach ($files as $fileInfo) {
    // 呼叫封裝好的 function

	$res = uploadFile($fileInfo ,$j ,$id."_".$user);
 
    // 顯示檔案上傳訊息
    echo $j."）".$res['mes'] . '<br>';
	
 
    // 上傳成功，將實際儲存檔名存入 array（以便存入資料庫）
    if (!empty($res['dest'])) {
        array_push($NameList,$fileInfo['name']);
        $uploadFiles[] = $res['dest'];
        $suc = true;
    }
    else
        array_push($NameList,"");

	$j++;
	
}


if($suc == true)
    DoSendMail($ProNum,$user,$email,$NameList);
else{
    if(!isset($res['dest']))$res['dest']="";
    if(!FileExists(iconv("UTF-8", "big5", $res['dest']))){
        echo '<script language="JavaScript">
            alert("上傳失敗!");</script>';
    }
}

header("refresh:4;url=index.php"); 
//print_r($uploadFiles);


function getFiles() {
    $i = 0;  // 遞增 array 數量
 
    foreach ($_FILES as $file) {
        // string 型態，表示上傳單一檔案
        if (is_string($file['name'])) {
            $files[$i] = $file;
            $i++;
        }
        // array 型態，表示上傳多個檔案
        elseif (is_array($file['name'])) {
            foreach ($file['name'] as $key => $value) {
                $files[$i]['name'] = $file['name'][$key];
                $files[$i]['type'] = $file['type'][$key];
                $files[$i]['tmp_name'] = $file['tmp_name'][$key];
                $files[$i]['error'] = $file['error'][$key];
                $files[$i]['size'] = $file['size'][$key];
                $i++;
            }
        }
    }
 
    return $files;
}
 
/**
 * string uploadFile(array $files, array $allowExt, number $maxSize, boolean $flag, string $uploadPath) PHP 多檔案上傳
 *
 * @param files 透過 $_FILES 取得的 HTTP 檔案上傳的項目陣列
 * @param allowExt 允許上傳檔案的擴展名，預設 'jpeg', 'jpg', 'gif', 'png'
 * @param maxsize 上傳檔案容量大小限制，預設 2097152（2M * 1024 * 1024 = 2097152byte）
 * @param flag 檢查是否為真實的圖片類型（只允許上傳圖片的話），true（預設）檢查；false 不檢查
 * @param uploadPath 存放檔案的目錄，預設 uploads
 *
 * @return 回傳存放目錄 + md5 產生的檔案名稱 + 擴展名
 */function uploadFile($fileInfo, $j, $user, $allowExt = array('doc','docx','pdf','ppt','pptx'), $maxSize = 15728640, $flag = false, $uploadPath = 'upload') {
    // 存放錯誤訊息
    $res = array();
 	$temp = $uploadPath .'/'.$_POST['project_num'];
    // 取得上傳檔案的擴展名
    $ext = pathinfo($fileInfo['name'], PATHINFO_EXTENSION); 
 
    //uniName為新的檔案名稱
	$uniName = '('. $j .')'.$fileInfo['name'];
    $destination = $uploadPath .'/'.$_POST['project_num']."/" . $uniName;
     
    // 判斷是否有錯誤
    if ($fileInfo['error'] > 0) {
        // 匹配的錯誤代碼
        switch ($fileInfo['error']) {
            case 1:
                $res['mes'] = $fileInfo['name'] . ' 上傳的檔案超過了 php.ini 中 upload_max_filesize 允許上傳檔案容量的最大值';
                break;
            case 2:
                $res['mes'] = $fileInfo['name'] . ' 上傳檔案的大小超過了 HTML 表單中 MAX_FILE_SIZE 選項指定的值';
                break;
            case 3:
                $res['mes'] = $fileInfo['name'] . ' 檔案只有部分被上傳';
                break;
            case 4:
                $res['mes'] = $fileInfo['name'] . ' 無選擇檔案';
                break;
            case 6:
                $res['mes'] = $fileInfo['name'] . ' 找不到臨時目錄';
                break;
            case 7:
                $res['mes'] = $fileInfo['name'] . ' 檔案寫入失敗';
                break;
            case 8:
                $res['mes'] = $fileInfo['name'] . ' 上傳的文件被 PHP 擴展程式中斷';
                break;
        }
 
        // 直接 return 無需在往下執行
        return $res;
    }
 
    // 檢查檔案是否是通過 HTTP POST 上傳的
    if (!is_uploaded_file($fileInfo['tmp_name']))
        $res['mes'] = $fileInfo['name'] . ' 檔案不是通過 HTTP POST 方式上傳的';
     
    // 檢查上傳檔案是否為允許的擴展名
    if (!is_array($allowExt))  // 判斷參數是否為陣列
        $res['mes'] = $fileInfo['name'] . ' 檔案類型型態必須為 array';
    else {
        if (!in_array($ext, $allowExt))  // 檢查陣列中是否有允許的擴展名
            $res['mes'] = $fileInfo['name'] . ' 非法檔案類型';
    }
 
    // 檢查上傳檔案的容量大小是否符合規範
    if ($fileInfo['size'] > $maxSize)
        $res['mes'] = $fileInfo['name'] . ' 上傳檔案容量超過限制';
 
    // 檢查是否為圖片類型
    if ($flag && !@getimagesize($fileInfo['tmp_name']))
        $res['mes'] = $fileInfo['name'] . ' 不是真正的圖片類型';
 
    // array 有值表示上述其中一項檢查有誤，直接 return 無需在往下執行
    if (!empty($res)){
        return $res;
    }
    else {
		//檢查檔案是否存在
		if(file_exists(iconv("UTF-8", "big5", $destination)))
			echo '<script language="JavaScript">
			 var msg = "是否覆蓋舊檔?\n\n請確認！"; 
 				if (confirm(msg)==true){ 
 					alert("覆蓋成功！"); 
 				}else{ 
 					history.go(-1);
 				} 
			</script>';
		
        // 檢查指定目錄是否存在，不存在就建立目錄
        else if (!file_exists($temp))
            @mkdir(iconv("UTF-8", "big5", $temp),0777,true);
         
        // 將檔案從臨時目錄移至指定目錄
        if (!@move_uploaded_file($fileInfo['tmp_name'],iconv("UTF-8", "big5", $destination)))  // 如果移動檔案失敗
            $res['mes'] = $fileInfo['name'] . ' 檔案移動失敗';
 
        $res['mes'] = $fileInfo['name']." 上傳成功！";
        $res['dest'] = $destination;
 
        return $res;
    }
}

function FileExists($path){
	if(file_exists($path)){
		return true;
	}	
	else{
		return false;
		//exit();
	}
		
}

function DoSendMail($ProNum,$user,$email,$NameList){
	SendEmail($email ,"檔案上傳確認信" ,$user."老師 您好，
	我們已收到您計畫編號為 ".$ProNum." 的檔案如下：<br>1）".$NameList[1]."<br>2）".$NameList[2]."<br>3）".$NameList[3]."<br>4）".$NameList[4]."<br>");
	
}
?>

</div>
    
</body>
</html>
