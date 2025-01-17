<?php
session_start();

//データベース接続情報を格納
include("config.php");

$txt_user = "";
$txt_email = "";
$txt_pass = "";
$hid_mode = "";

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    //POSTデータの取得
    $txt_user = $_POST['txt_user'];
    $txt_email = $_POST['txt_email'];
    $txt_pass = $_POST['txt_pass'];
    $hid_mode = $_POST['hid_mode'];

    if($hid_mode == "1"){

      $err = "";

      if($txt_user == ""){
          $err .= "【ユーザー名】";
      }
      if($txt_email == ""){
          $err .= "【メールアドレス】";
      }
      if($txt_pass == ""){
          $err .= "【パスワード】";
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
          }
      }else{
          echo $err."を修正してください。";
      }
    }else if($hid_mode == "9"){
      $err = "";

      if($txt_email == ""){
          $err .= "【メールアドレス】";
      }
      if($txt_pass == ""){
          $err .= "【パスワード】";
      }

      if($err == ""){
          try{
              $dbh = new PDO($dsn, $user, $password);
              $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
              $sql = "select"
                      ." um.user_no"
                      .",um.user_kj"
                      .",um.password"
                      ." from s23083024_user_mst um"
                      ." where um.email = :email"
                      ." and um.delete_ku = '0'";
              $stmt = $dbh->prepare($sql);
              $stmt->bindValue(':email', $txt_email , PDO::PARAM_STR);
              $stmt->execute();
              $result = $stmt->fetch();
              if(password_verify($txt_pass, $result['password'])){
                  //変数をセッションに登録
                  $_SESSION['user_no'] = $result['user_no'];
                  $_SESSION['user_kj'] = $result['user_kj'];
                  header("Location:user_list.php");
              }else{
                  echo "ログイン認証に失敗しました";
              } 
          }catch (PDOException $e){
              echo($e->getMessage());
              die();
          }
      }else{
          echo $err."を修正してください。";
      }
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
  <link rel="stylesheet" href="css/login.css">
  <script>

	function btn_signup(){
		const container = document.getElementById('container');
		container.classList.add("right-panel-active");
	};

	function btn_signin(){
		const container = document.getElementById('container');
		container.classList.remove("right-panel-active");
	};

  </script>
</head>
<body>

<div class="container" id="container">
  <div class="form-container sign-up-container">
    <form method="post">
      <h1>アカウント作成</h1>
	  <input type="hidden" name="hid_mode" value="1" />
      <input type="text" placeholder="Name" name="txt_user" />
      <input type="email" placeholder="Email" name="txt_email" />
      <input type="password" placeholder="Password" name="txt_pass" />
      <button type="submit">サインアップ</button>
    </form>
  </div>
  <div class="form-container sign-in-container">
    <form method="post">
      <h1>サインイン</h1>
	  <input type="hidden" name="hid_mode" value="9" />
      <input type="email" placeholder="Email" name="txt_email" />
      <input type="password" placeholder="Password" name="txt_pass" />
      <button>サインイン</button>
    </form>
  </div>
  <div class="overlay-container">
    <div class="overlay">
      <div class="overlay-panel overlay-left">
        <h1>おかえりなさい!</h1>
        <p>個人情報を使ってログインしてください。</p>
        <button class="ghost" id="signIn" onclick="btn_signin();">サインイン</button>
      </div>
      <div class="overlay-panel overlay-right">
        <h1>ユーザー登録</h1>
        <p>個人情報を入力して始めましょう。</p>
        <button class="ghost" id="signUp" onclick="btn_signup();">サインアップ</button>
      </div>
    </div>
  </div>
</div>
</body>
</html>