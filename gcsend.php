<?php
require 'dbconnect.php';
require 'session.php';

$u_ID = "";
$gc_title = "";
$gc_body = "";
$gc_created_at = date("Y/m/d H:i:s");

//直叩き対策
if(empty($_POST)){
    header('Location: gc.php');
    exit();
}else{
    //格納処理
    $u_ID = $_SESSION['u_ID'];
    $gc_title = $_POST['gc_title'];
    $gc_body = $_POST['gc_body'];
}
//格納処理
try{
    
    //SQL実行
    $stmt = $db->prepare("insert into gc(u_id, g_title, g_about, g_created_at) value(?, ?, ?, ?)");
    $stmt->execute([$u_ID,$gc_title,$gc_body,$gc_created_at]);

}catch(PDOException $error){
    //エラー時の処理を書く
     //echo $error->getMessage();
     //echo $error->getCode();
    if(isset($error)){
        //ここに表示させたいメッセージを入力する
        $_SESSION['error'] = '投稿がうまく行きませんでした';
        header('Location: gccreate.php');
        exit;
    }
}

//無事終わったら質問作成画面へ
$_SESSION['message'] = '投稿完了しました';
header('Location: gccreate.php');
?>