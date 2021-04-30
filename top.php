<?php
  require 'session.php';
 ?>
<!DOCTYPE html>
<html lang="ja">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="robots" content="none,noindex,nofollow">

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/top.css">
    <title>TAMARIBA | トップ</title>
  </head>
  <body>
    <?php include('header.php'); ?>
    <div class="wrapper">
      <div class="top_img">
        <div class="top_img_txt">
            <p>あなたの学びに快適さを</p>
        </div>
      </div>
      <main>
        <h2 class="main_title">ようこそTAMARIBAへ</h2>
        <p class="top_text">TAMARIBAはあなたの学校生活を様々な機能でサポートします。<br>ここではあなたの学校生活に役立つ3つの機能を紹介します！</p>
        <div class="image_logo_groupe">
          <p class="image_logo"><img src="images/gc.svg" alt="gc"></p>
          <p class="image_logo"><img src="images/test.svg" alt="test"></p>
          <p class="image_logo"><img src="images/qa.svg" alt="qa"></p>
        </div>

        <h2>グループチャット</h2>
        <p class="image_logo"><img src="images/gc.svg" alt="gc"></p>
        <p class="top_text">グループチャットでは学校内外問わず日本中の学生とコミュニケーションをとれます。役立つ勉強のアドバイスをしあったり、部活の話をしたり、趣味の話に夢中になったり...ここにはたくさんの人間との出会いが満ち溢れています！</p>
        <p class="a_button"><a href="gcsearch.php">グループチャットへ移動する</a></p>
        <h2>テスト</h2>
        <p class="image_logo"><img src="images/test.svg" alt="test"></p>
        <p class="top_text">テストではたくさんの学生たちが作った様々な問題に挑戦できます。あるいはあなた自身が出題者になることもできます。あなたの勉強や知識を蓄えることに活用してみてください。ここで得た知識があなたの役に立つこともあるかもしれません。</p>
        <p class="a_button"><a href="testserch.php">テストへ移動する</a></p>
        <h2>質問掲示板</h2>
        <p class="image_logo"><img src="images/qa.svg" alt="qa"></p>
        <p class="top_text">質問掲示板ではあなたの悩みを解決する手助けができます。課題の分からないところからちょっとした悩みまで、様々なことを誰かが解決してくれます。また悩みを持った学生の手助けをあなたがすることもできます。あなたの知識を人のために役立てましょう！</p>
        <p class="a_button"><a href="qa.php">質問掲示板へ移動する</a></p>
      </main>
    </div>
    <?php include('footer.html'); ?>
  </body>
</html>
