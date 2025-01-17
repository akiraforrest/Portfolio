<?php

//データベース接続情報を格納
include("config.php");

try{

    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
   //ページング機能として総件数を取得
   $sql = "SELECT"
   ." Count(nt.seq_no) count"
   ." FROM s23083024_news_tbl nt"
   ." where nt.delete_ku = '0'";    //削除されていないデータのみ表示
$stmt = $dbh->prepare($sql);
$stmt->execute();
$result = $stmt->fetch();
$count = $result[count];

    $sql = "select"
        ." nt.seq_no"
        .",nt.title_kj"
        .",nt.insert_at"
        .",nft.folder_name"
        .",nft.file_name"
        ." from s23083024_news_tbl nt"
        ." left join s23083024_news_fileuploads_tbl nft"
        ." on nt.seq_no = nft.news_no"
        ." and nft.delete_ku = '0'"
        ." where nt.delete_ku = '0'"
        ." order by nt.seq_no desc;";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    $count = $stmt->rowCount();
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }

}catch (PDOException $e){
    echo($e->getMessage());
    die();
}

?>

<html>
<body>
<h1>ニュース一覧</h1>
<a href="newsAdd_v2.php">新規登録</a><br><br>
<table border=1>
    <tr><th>id</th><th>日付</th><th>タイトル</th><th>画像</th></tr>
    <?php foreach($data as $row): ?>
    <tr>
        <td><?php echo $row['seq_no'];?></td>
        <td>
            <?php
                $Date = date($row['insert_at']); 
                echo date('Y.m.d', strtotime($Date));
            ?> 
        </td>
        <td><a href="newsArticle.php?seq_no=<?php echo $row['seq_no'];?>"><?php echo $row['title_kj'];?></a></td>
        <td>
            <?php
                $imgFilePath = "uploads/".$row['folder_name']."/".$row['file_name'];
                if(isset($row['file_name']) && file_exists($imgFilePath)){
                    echo "<img src='".$imgFilePath."'>";
                }
            ?>
        </td>
     </tr>
    <?php endforeach; ?>
</table>
</body>
</html>