<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="css.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>首頁</title>
</head>

<header id="header">
    <nav>
        <h2>科技部研討會報名PHP測試</h2>
    </nav>
        </header>

<style>
input{
	/* border:0; */
  background-color:#6182a0;
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
<body>
    <div id="content">
        <form class="container">
        <h4 style="text-align: center;">功能：</h4>


        <?php 

            session_start();
            if($_SESSION["login"] == NULL){
                $user = "";
                }
            else{
                $user = $_SESSION["login"];
                //echo "您好,".$user."號使用者";
                }

            
            
            
            if($user == ""){?>
                <!--<span>
                <a href="login.php"><input type="button" value="請登入" name="login" style="width:150px;height:50px;">
                    </a>
                    </span>
                    <span><a href="signup.php"><input type="button" value="註冊" name="signup" style="width:150px;height:50px;">

                    </a> 
                </span> -->
                <div style="text-align: center;">
                    <a class="button" href="login.php" style="color:#FFF;">請登入</a>
                    &nbsp;&nbsp;
                    <a class="button" href="signup.php" style="color:#FFF;">註冊</a>
                </div>


                
            <?php } else{?>

                <div class="flex">
                    <div class="item"><a class="button" href="dologout.php" style="color:#FFF;">登出</a></div>
                    <div class="item"><a class="button" href="apply.php" style="color:#FFF;">線上報名</a></div>
                    <div class="item"><a class="button" href="upload.php" style="color:#FFF;">檔案上傳</a></div>
                </div>
 
            <?php } ?>
        </form>
    </div>
</body>
</html>