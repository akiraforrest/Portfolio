<?php
session_start();

if (isset($_SESSION['user_no']) == false) {
    header("Location:login.php");
}

//データベース接続情報を格納
include("config.php");

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    //POSTデータの取得
    $hid_user_no = $_POST['hid_user_no'];
    $txt_user = $_POST['txt_user'];
    $txt_email = $_POST['txt_email'];
    $txt_pass = $_POST['txt_pass'];

    $err = "";

    if($txt_user == ""){
        $err .= "【名前】";
    }
    if($txt_email == ""){
        $err .= "【メールアドレス】";
    }

    if($err == ""){

        $sql = "insert into s23083024_user_mst("
                ."user_kj"
                .",email"
                .",password"
                .",delete_ku"
                .",insert_at"
                .",update_at"
                .") values ("
                .":user_kj"
                .",:email"
                .",:password"
                .",'0'"
                .",now()"
                .",now()"
                .");";
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_kj', $txt_user, PDO::PARAM_STR);
        $stmt->bindValue(':email', $txt_email, PDO::PARAM_STR);
        $stmt->bindValue(':password', password_hash($txt_pass, PASSWORD_DEFAULT), PDO::PARAM_STR);
        if(!$stmt->execute()){
            return "データの書き込みに失敗しました。";
        }else{
            echo "登録完了しました";

            mb_language("Japanese");
            mb_internal_encoding("UTF-8");
            $to = $txt_email;
            $title = "会員登録完了";
            $content = $txt_user."さん、会員登録ができました。";

            $header = "MIME-Version: 1.0\n";
            $header .= "Content-Transfer-Encoding: 7bit\n";
            $header .= "Content-Type: text/plain; charset=ISO-2022-JP\n";
            $header .= "Message-Id: <" . md5(uniqid(microtime())) . "@test.com>\n";
            $header .= "from: test@test.com\n";
            $header .= "Reply-To: test@test.com\n";
            $header .= "Return-Path: test@test.com\n";
            $header .= "X-Mailer: PHP/". phpversion();

            if(mb_send_mail($to, $title, $content, $header)){
                echo "メールを送信しました";
            } else {
                echo "メールの送信に失敗しました";
            }
            header("Location:user_list.php");
        }
    }else{
        echo $err."を修正してください。";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Responsive Web Design</title>
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0">
  <meta name="keywords" content="">
  <meta name="description" content="">
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/index.css">
</head>
<body>
<!-- wrapper -->
<div class="wrapper">
  <!-- header -->
  <?php include("inc_header.php");?>
  <!-- /header -->
	
  <!-- main -->
  <main>
	  <!-- mypage-menu -->
	  		<?php include("inc_menu.php");?>
	  <!-- /mypage-menu -->
	  <!-- mypage-main -->
	  <div class="mypage-main">
		  <div class="mypage-main-midashi">お知らせ追加</div>
		  <div class="mypage-main-text">
			  
			<form method="POST" action="" accept-charset="UTF-8">
				<input type="hidden" name="hid_user_no" value="" />

				<div class="input-formarea-field">
					<label>名前</label>
					<div><input type="text" name="txt_user" value"></div>
				</div>
				<div class="input-formarea-field">
					<label>メールアドレス</label>
					<div><input type="text" name="txt_email" value=""></div>
				</div>
				<div class="input-formarea-field">
					<label for="team">パスワード</label>
					<div><input type="password" name="txt_pass"></div>
				</div>
				<button class="blue-button" type="submit">追加する</button>
			</form>
		
	  </div>
	  <!-- /mypage-main -->
  </main>
  <!-- /main -->
	
  <!-- footer -->
  <footer>
	  <div class="footer-box">
		  <div class="footer-box-dat">
			  <div class="footer-box-dat-logo"><a href="/"><img src="img/TSUNAGOON-Logo.png" alt="TSUNAGOON（ツナグーン）"></a></div>
			  <div class="footer-box-dat-copyright">
				  copyright ©2020 WELL FIELD corpolation. All rights reserved. 
			  </div>				
		  </div>
	  
	  </div>
	
  </footer>
  <!-- /footer -->

  <script src="js/script.js"></script>
<!-- /wrapper -->
</div>
</body>
</html>