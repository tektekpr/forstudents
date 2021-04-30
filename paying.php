<?php
require 'session.php';
require 'dbconnect.php';
$u_id = "";

$st_created_at = date("Y/m/d H:i:s");
if (isset($_POST['card']) && isset($_POST['date']) && isset($_POST['sec'])) {
    try{
        //格納処理
        $st_id = $_SESSION['carts'];
        $u_id = $_SESSION['u_ID'];
        //SQL実行
        foreach($st_id as $st){
            $stmt = $db->prepare("insert into ownedstamp(u_id, st_id, st_created_at) value(?, ?, ?)");
            $stmt->execute([$u_id, $st ,$st_created_at]);    
        }
        $_SESSION['carts'] = '';
        header('Location: payfin.php');
    
    }catch(PDOException $error){
        //エラー時の処理を書く
         echo $error->getMessage();
         echo $error->getCode();
        if(isset($error)){
            //ここに表示させたいメッセージを入力する
            $_SESSION['s_error'] = '同じアイテムを再度購入することはできません';
            header('Location: shopcart.php');
            exit;
        }
    }
}else{
    header('Location: pay.php');
}