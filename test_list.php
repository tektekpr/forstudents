<?php
  require 'session.php';
  require 'dbconnect.php';

  $sql = "";
  $test_res = "";
  $data = "";
  $sort = "0";
  
  $u_ID_box = $_SESSION['u_ID'];
  

  // SQL文を作成
  $sql = "SELECT * FROM test WHERE t_deleted_at IS NULL AND t_createuser = $u_ID_box";
  // クエリ実行（データを取得）
  $test_res = $db->query($sql);

  $data = $test_res->fetchAll();
  //全体の展開
  #print_r($data);

  //print($data[0][2]);
  $data=array_reverse($data);

  if (isset($_POST['sort'])) {
    $sort=$_POST['sort'];
    if($sort==1){
      $data=array_reverse($data);
    }
  }
  
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="robots" content="none,noindex,nofollow">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/testserch.css">
    <link rel="stylesheet" href="css/qa_list.css">
    <title>TAMARIBA | テスト管理</title>
</head>
<script>
    function pardon(abc) {
        var result = confirm('選択したテストを削除します。よろしいですか？');

        if(result) {
            location.href = "test_delete.php?id=" + abc;
        }
        else {
            alert('キャンセルしました');
        }
    }
    </script>
<body>
  <?php include('header.php');?>
    <div class="wrapper">
      <div class="title_menu">
            <h2>テスト管理</h2>
            <p><a href="testnewmake.php">テスト作成</a></p>
            <p style="right:160px;"><a href="test_list.php">テスト管理</a></p>
        </div>

      <!-- 検索欄と検索ボタン -->
      <!-- <form class="search" action="" method=""> -->
          <!-- <input type="search" name="search" placeholder="検索欄"> -->
          <!-- <input type="submit" name="submit" value="検索"> -->
      <!-- </form> -->
      <form class="sort" action="testserch.php" method="post">
          <select class="" name="sort">
            <?php
              #ソート内容の取得


              #取得結果による現在のソート
              if ($sort==1) {
                echo '<option value="1">古い順</option><option value="0">新しい順</option>';
              }
              elseif($sort==0){
                echo '<option value="0">新しい順</option><option value="1">古い順</option>';
              }
            ?>

          </select>
          <input type="submit" value="ソートする">
        </form>
      <main>
        <!-- 下記表示欄の表示順を変更 -->

        <?php
        foreach($data as $datas){?>
          <div class="qa_box_wrapper">
            <div class="qa_box1">
              <a href="testlook.php?id=<?php echo $datas['t_id'] ?>">
                <h3><?php echo $datas['t_title'];  ?></h3>
              </a>
              <div class="option">
                <p onclick="pardon(<?php echo $datas['t_id'] ?>)">削除</p>
              </div>
            </div>
          <!-- 他に表示させたい内容がるなら上のh2をコピーして値を変えてください -->
          </div>
        <?php } ?>
      </main>
    </div>
    <?php include('footer.html'); ?>
</body>
</html>