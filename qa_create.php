<?php

require 'dbconnect.php';
require 'session.php';

$u_ID = "";
$q_title = "";
$q_body = "";
$q_count = 0;
$q_answer_count = 0;
$q_created_at = date("Y/m/d H:i:s");
$q_updated_at = date("Y/m/d H:i:s");
//直叩き対策
if(empty($_POST)){
    header('Location: qa.php');
    exit();
}else{
    //格納処理
    $u_ID = $_SESSION['u_ID'];
    $q_title = $_POST['q_title'];
    $q_body = $_POST['q_body'];
}
//格納処理
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
    /*$sql = "INSERT INTO qa (u_id, q_title, q_body, q_count, q_answer_count, q_created_at, q_updated_at) VALUES (u_id=:u_ID, q_title=:q_title, q_body=:q_body, q_count=:q_count, q_answer_count=:q_answer_count, q_created_at=:q_created_at, q_updated_at=:q_updated_at)";

    //プリペアードステートメントの設定と取得
    $prestmt = $db->prepare($sql);

    //値の設定
    $prestmt->bindValue(':u_ID', $u_ID);//登録
    $prestmt->bindValue(':q_title', $q_title);//登録
    $prestmt->bindValue(':q_body', $q_body);//登録
    $prestmt->bindValue(':q_count', $q_count);//登録
    $prestmt->bindValue(':q_answer_count', $q_answer_count);//登録
    $prestmt->bindValue(':q_created_at', $q_created_at);//登録
    $prestmt->bindValue(':q_updated_at', $q_updated_at);//登録

    //SQL実行
    $prestmt->execute();*/
    $stmt = $db->prepare("insert into qa(u_id, q_title, q_body, q_count, q_answer_count, q_created_at, q_updated_at) value(?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$u_ID,$q_title,$q_body,$q_count,$q_answer_count,$q_created_at,$q_updated_at]);

}catch(PDOException $error){
    //エラー時の処理を書く
     //echo $error->getMessage();
     //echo $error->getCode();
    if(isset($error)){
        //ここに表示させたいメッセージを入力する
        $_SESSION['error'] = '投稿がうまく行きませんでした';
        header('Location: qa_create_form.php');
        exit;
    }
}

//無事終わったら質問作成画面へ
$_SESSION['message'] = '投稿完了しました';
header('Location: qa_create_form.php');
?>