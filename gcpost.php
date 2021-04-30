<?php
require 'dbconnect.php';
require 'session.php';

$u_ID = "";
$gt_talk = "";
$gt_created_at = date("Y/m/d H:i:s");

//直叩き対策
if(empty($_POST)){
    header('Location: gc.php');
    exit();
}else{
    //格納処理
    $g_id = $_POST['id'];
    $u_ID = $_SESSION['u_ID'];
    $gt_talk = $_POST['gt_body'];
}
//格納処理
try{
    
    //SQL実行
    $stmt = $db->prepare("insert into gctalk(g_id, u_id, gt_talk, gt_created_at) value(?, ?, ?, ?)");
    $stmt->execute([$g_id, $u_ID,$gt_talk,$gt_created_at]);

}catch(PDOException $error){
    //エラー時の処理を書く
     //echo $error->getMessage();
     //echo $error->getCode();
    if(isset($error)){
        //ここに表示させたいメッセージを入力する
        $_SESSION['error'] = '投稿がうまく行きませんでした';
        header('Location: gc.php');
        exit;
    }
}

//無事終わったら質問作成画面へ
$_SESSION['message'] = '投稿完了しました';
header("Location: gc.php?g_id=$g_id");
