<?php
session_start();

if (isset($_SESSION['user_no']) == false) {
    header("Location:login.php");
}

//データベース接続情報を格納
include("config.php");

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    //POSTデータの取得
    $hid_user_no = $_POST['hid_user_no']; //削除される対象のuser_no

    if($hid_user_no !== ""){

        //UPDATE文（更新）
        $sql = "update s23083024_user_mst set"
        ." delete_ku = '1'"
        ." where user_no = :user_no;";
        $dbh = new PDO($dsn, $user, $password);
        $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try{
            $stmt = $dbh->prepare($sql);
            $stmt->bindValue(':user_no', $hid_user_no, PDO::PARAM_INT);
            $stmt->execute();
        }catch (PDOException $e){
            echo($e->getMessage());
            die();
        }
    }
}
try{
    $dbh = new PDO($dsn, $user, $password);
    $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    //一覧取得
    $sql = "select"
            ." um.user_no"
            .",um.user_kj"
            .",um.email"
            .",um.delete_ku"
            .",um.insert_at"
            .",um.update_at"
            ." from s23083024_user_mst um"
            ." where um.delete_ku = '0'" //削除されていないデータのみ表示
            ." order by um.user_no desc;";
    $stmt = $dbh->prepare($sql);
    $stmt->execute();

    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        $data[] = $row;
    }
}catch (PDOException $e){
    echo($e->getMessage());
    die();
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

	<script type="text/javascript">

	document.getElementById('hid_user_no').value = "";

	function MJ_UPD(argUSER_NO){
		document.location.href="user_edit.php?user_no="+argUSER_NO;
	}
	function MJ_DEL(argUSER_NO){
		document.getElementById('hid_user_no').value = argUSER_NO;
		document.fr01.submit();
	}

	</script>
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
		  <div class="mypage-main-midashi">会員一覧</div>
		  <div class="mypage-main-text">

			<div class="mypage-main-text-button">
				<a href="user_add.php" class="white-button">+ 会員アカウントを追加する</a>
			</div>
			<div class="mypage-main-text-grid">
                <form name="fr01" action="" method="POST">
                    <input type="hidden" id="hid_user_no" name="hid_user_no" value="">
                    <table class="table-datalist">
                        <tbody>
                            <tr class="table-datalist-heading">
                                <th>名前</th>
                                <th>メール</th>
                                <th></th>
                            </tr>
                            <?php foreach($data as $row): ?>
                                <tr>
                                    <td data-label="名前"><?php echo $row['user_kj']; ?></td>
                                    <td class="table-datalist-h" data-label="メール"><?php echo $row['email']; ?></td>
                                    <td>
                                        <a href="javascript:" class="white-button list-button" onclick="MJ_UPD(<?php echo $row['user_no']; ?>);">編集</a><a href="javascript:" class="white-button list-button" onclick="MJ_DEL(<?php echo $row['user_no']; ?>);">削除</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </form>
			</div>
		
		  </div>
		
	  </div>
	  <!-- /mypage-main -->
  </main>
  <!-- /main -->
	
  <!-- footer -->
  <?php include("inc_footer.php");?>
  <!-- /footer -->

  <script src="js/script.js"></script>
<!-- /wrapper -->
</div>
</body>
</html>