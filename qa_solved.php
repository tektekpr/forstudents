<?php
require 'dbconnect.php';
require 'session.php';
/*$dsn = 'mysql:host=localhost;dbname=ph24;charset=utf8mb4';
$db_user = 'root';
$db_password = '';
*/
try{
    //DB接続オブジェクト
    //PDO…PHP Data Object
    //$pdo = new PDO($dsn, $db_user, $db_password);
    //let logo = getElementById('id');

    //PDOの設定変更
    /*$pdo->setAttribute(
        PDO::ATTR_ERRMODE,
        PDO::ERRMODE_EXCEPTION
    );
    $pdo->setAttribute(
        PDO::ATTR_EMULATE_PREPARES,
        false
    );*/

    //SQL文作成
    // $sql = "SELECT id, password FROM kadai05_users WHERE id=:id";
    $def = $_GET['id'];
    $sql = "UPDATE `qa` SET `q_solved_at` = CURRENT_TIMESTAMP WHERE `qa`.`q_id` = $def";
    //$sql = "SELECT * FROM qa where q_solved_at IS NULL";

    //プリペアードステートメントの設定と取得
    $prestmt = $db->prepare($sql);

    //SQL実行
    $prestmt->execute();

    //抽出結果取得
    $gc = $prestmt->fetchALL(PDO::FETCH_ASSOC);
}catch(PDOException $error){
    //エラー時の処理を書く
    // echo $error->getMessage();
    // echo $error->getCode();
    if($gc['g_id'] === ""){
        //ここに表示させたいメッセージを入力する
        // $_SESSION['error'] = '質問は投稿されていません';
        // unset($_SESSION['error']);
    }
    header('location: qa_list.php');
}