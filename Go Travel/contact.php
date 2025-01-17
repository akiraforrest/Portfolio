<?php

include("config.php");

session_start();

if (!isset($_SESSION['user_no'])) {
    header("Location: Login.php");
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>問い合わせ</title>

    <!--Icon-->
    <link rel="icon" href="img/logo.ico">

    <!---------cssの記述---------->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/contact.css" rel="stylesheet">
    

    <!---------Scriptの記述---------->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script language="javascript" type="text/javascript">
        function user_api() {
            url = "user.php";
            $.getJSON(url, (data) => {
                var avatarUrl = data["user_avatar"];
                
                document.getElementById("headerUserInfoAvatar").innerHTML = "<img src='" + avatarUrl + "' alt='User Avatar'>";
                document.getElementById("headerUserInfoName").innerHTML = data["user_name"];
            });
        }
    </script>
</head>
<body onload="user_api()">
    <!---------↓header/ヘッダ↓---------->
    <header>
        <div class="headerLogo">
            <img src="img/logo.png">
        </div>
        <div class="headerMeau">
            <a href="place.php">観光地おすすめ</a>
            <a href="postShow.php">旅行先シェア</a>
            <a href="Mypage.php">Mypage</a>
        </div>
        <div class="headerUser">
            <div class="headerUserWelcome" id="headerUserWelcome"></div>
            <div class="headerUserInfo">
                <div class="headerUserInfoAvatar" id="headerUserInfoAvatar"></div>
                <div class="headerUserInfoName" id="headerUserInfoName"></div>
            </div>
        </div>
        <div class="headerLogout">
            <img src="img/logout.png" alt="logout" onclick="LogoutCheck()">
        </div>
    </header>
    <!---------↑header/ヘッダ↑---------->

    <main>
        <div class="page">
            <div class="pageTitle">お問い合わせ</div>
            <div class="pageLogo">
                <img src="img/logo.png">
            </div>
            <div class="pageInfo">
                <h2>電話番号：xxx-xxxx-xxxx</h2>
                <h2>メール：gotravelstaff@tsb.com</h2>
            </div>
            <div class="pagety">
                <h1>ご連絡ありがとうございます。</h1>
                <h1>折り返し担当者より連絡させていただきます。</h1>
            </div>
        </div>
    </main>
    
    <!---------↓footer/フッター↓---------->
    <footer>
        <div class="footerMeau">
            <a href="termsOfService.php">利用規約</a>
            <a href="contact.php">お問い合わせ</a>
        </div>
        <div class="footerText">
            <p>©2023 TSB GoTravel. All right reserved</p>
        </div>
    </footer>
    <!---------↑footer/フッター↑---------->

    <script>
        //ユーザーへのようこそテキスト
        var hour = new Date().getHours();
    
        var welcomeText = document.getElementById('headerUserWelcome');
    
        if (hour >= 5 && hour < 10) {
            welcomeText.innerHTML = '<b>おはようございます</b>';
        } else if (hour >= 10 && hour < 20) {
            welcomeText.innerHTML = '<b>こんにちは</b>';
        } else {
            welcomeText.innerHTML = '<b>こんばんは</b>';
        }


        //ログアウト確認
        function LogoutCheck(){
            var LogoutCheck = confirm("ログアウトしてよろしいですか");

            if (LogoutCheck) {
                window.location.href = "logout.php";
            } else {}
        }
    </script>

</body>
</html>
