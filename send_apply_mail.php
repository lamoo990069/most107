<?php 

function SendEmail($email,$subject,$body){

	include("PHPMailer/class.phpmailer.php"); //匯入PHPMailer類別 
	mb_internal_encoding('UTF-8');   


	$mail= new PHPMailer(); //建立新物件        
	$mail->IsSMTP(); //設定使用SMTP方式寄信        
	$mail->SMTPAuth = true; //設定SMTP需要驗證        
	$mail->SMTPSecure = "ssl"; // Gmail的SMTP主機需要使用SSL連線   
	$mail->Host = "smtp.gmail.com"; //Gamil的SMTP主機        
	$mail->Port = 465;  //Gamil的SMTP主機的SMTP埠位為465埠。        
	$mail->CharSet = "utf8"; //設定郵件編碼        

	$mail->Username = "ytntcu1210@gmail.com";
	$mail->Password = "qqlatneefjvvxmdf";   

	$mail->From = "ytntcu1210@gmail.com"; //設定寄件者信箱          
	$mail->FromName = "107年度應用科學教育學門成果發表暨研討會"; //設定寄件者姓名        

	$mail->Subject = $subject; //設定郵件標題        
	$mail->Body = $body; //設定郵件內容        
	$mail->IsHTML(true); //設定郵件內容為HTML        
	$mail->AddAddress($email, "107年度應用科學教育學門成果發表暨研討會"); //設定收件者郵件及名稱  


	if(!$mail->Send()) {        
	echo "Mailer Error: " . $mail->ErrorInfo;        
	}
	else
		echo "確認信已寄出"."<br>";

}
?>