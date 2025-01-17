<?php

//データベース接続情報を格納
include("config.php");

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    //新しい番号を保存するための変数
    $newid = "";

    //POSTデータの取得
    $txt_title_kj = $_POST['txt_title_kj'];
    $txt_article_kj = $_POST['txt_article_kj'];

    $err = "";

    if($txt_title_kj == ""){
        $err .= "【件名】";
    }
    if($txt_article_kj == ""){
        $err .= "【内容】";
    }

    if($err == ""){

        $sql = "insert into s23083024_news_tbl("
                ."title_kj"
                .",article_kj"
                .",delete_ku"
                .",insert_at"
                .",update_at"
                .") values ("
                .":title_kj"
                .",:article_kj"
                .",'0'"
                .",now()"
                .",now()"
                .");";
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try{
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':title_kj', $txt_title_kj, PDO::PARAM_STR);
            $stmt->bindValue(':article_kj', $txt_article_kj, PDO::PARAM_STR);
            $stmt->execute();
            //$dbh->lastInsertId()は、最後に登録した番号を取得
            $newid = $dbh->lastInsertId();
        } catch(Exception $e){
            echo "データの書き込みに失敗しました。". $e->getMessage();
        }

        if(isset($newid)){
            //フォルダ名を日付＋ランダム文字列（４桁）で生成する//
            if(isset($_FILES['up_file'])){
                //ASCIIコードによる文字変換は65がA、90がZとなります。
                $folder = date(ymd).chr(mt_rand(65,90)).chr(mt_rand(65,90)).chr(mt_rand(65,90)).chr(mt_rand(65,90));
                mkdir('uploads/'.$folder);
            }

            $save = 'uploads/'.$folder.'/'.basename($_FILES['up_file']['name']);
        
            //move_uploaded_fileで、一時ファイルを保存先ディレクトリに移動させる
            if(move_uploaded_file($_FILES['up_file']['tmp_name'], $save)){
                $sql = "insert into s23083024_news_fileuploads_tbl("
                    ."news_no"
                    .",folder_name"
                    .",file_name"
                    .",delete_ku"
                    .",insert_at"
                    .",update_at"
                    .") values ("
                    .":news_no"
                    .",:folder_name"
                    .",:file_name"
                    .",'0'"
                    .",now()"
                    .",now()"
                    .");";
                $dbh = new PDO($dsn, $user, $password);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                try{
                    $stmt = $dbh->prepare($sql);
                    $stmt->bindValue(':news_no', $newid, PDO::PARAM_INT);
                    $stmt->bindValue(':folder_name', $folder, PDO::PARAM_STR);
                    $stmt->bindValue(':file_name', basename($_FILES['up_file']['name'], PDO::PARAM_STR));
                    $stmt->execute();
                } catch(Exception $e){
                    echo "データの書き込みに失敗しました。". $e->getMessage();
                }

                header("Location:newslist_v2.php");

            }else{
                echo 'アップロード失敗！';
            }
        }
    }else{
        echo $err."を修正してください。";
    }
}
?>

<html>
<body>
<h1>ニュース登録</h1>
<form action="newsAdd_v2.php" method="POST" enctype="multipart/form-data">
    件名<br>
    <input type="text" name="txt_title_kj" /><br>
    内容<br>
    <textarea name="txt_article_kj" style="width:300px;height:150px;"></textarea><br>
    画像<br>
    <input type="file" name="up_file"><br><br>
    <input type="submit" value="投稿">
</form>
</body>
</html>
