<?php
session_start();

if (isset($_SESSION['user_no']) == false) {
    header("Location:login.php");
}

//データベース接続情報を格納
include("config.php");

if($_SERVER['REQUEST_METHOD'] === 'GET'){

    //GETデータの取得
    $get_user_no = $_GET['user_no'];

    if($get_user_no == ""){
        header('Location: user_list.php');
        exit();
    }

    try{

        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
        $sql = "select"
                ." um.user_kj"
                .",um.email"
                ." from s23083024_user_mst um"
                ." where um.user_no = :user_no";
        $stmt = $dbh->prepare($sql);
        $stmt->bindValue(':user_no', $get_user_no , PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch();
    }catch (PDOException $e){
        echo($e->getMessage());
        die();
    }
}

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

        if($txt_pass == ""){
            $sql = "update s23083024_user_mst set"
                    ." user_kj = :user_kj"
                    .",email = :email"
                    .",update_at = now()"
                    ." where user_no = :user_no;";
            
        } else {
            $sql = "update s23083024_user_mst set"
                    ." user_kj = :user_kj"
                    .",email = :email"
                    .",password = :password"
                    .",update_at = now()"
                    ." where user_no = :user_no;";
        }
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try{
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':user_no', $hid_user_no , PDO::PARAM_INT);
            $stmt->bindValue(':user_kj', $txt_user, PDO::PARAM_STR);
            $stmt->bindValue(':email', $txt_email, PDO::PARAM_STR);
            if($txt_pass != ""){
                $stmt->bindValue(':password', password_hash($txt_pass, PASSWORD_DEFAULT), PDO::PARAM_STR);
            }
            $stmt->execute();

            header("Location:user_list.php");
        } catch(Exception $e){
            echo "データの書き込みに失敗しました。". $e->getMessage();
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
		  <div class="mypage-main-midashi">会員情報変更</div>
		  <div class="mypage-main-text">
			  
			<form method="POST" action="" accept-charset="UTF-8">
				<input type="hidden" name="hid_user_no" value="<?php echo $get_user_no; ?>" />

				<div class="input-formarea-field">
					<label>名前</label>
					<div><input type="text" name="txt_user" value="<?php echo $result['user_kj']; ?>"></div>
				</div>
				<div class="input-formarea-field">
					<label>メールアドレス</label>
					<div><input type="text" name="txt_email" value="<?php echo $result['email']; ?>"></div>
				</div>
				<div class="input-formarea-field">
					<label for="team">パスワード</label>
					<div><input type="password" name="txt_pass"></div>
				</div>
				<button class="blue-button" type="submit">変更する</button>
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