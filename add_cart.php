<?php
//本来はissetチェックが必要
session_start();
//カート初期化
$cart = [];
//カート存在チェック
if(!empty($_SESSION['carts'])){
    //あれば一度引っこ抜く
    $cart = $_SESSION['carts'];
}
$new_cart = $_GET['select'];

//カートに追加
if( in_array($new_cart,$cart)){
    
}else{
    array_push($cart,$new_cart);
}
// $cart[] = $_GET['sid'];

//セッション領域の上書き
$_SESSION['carts'] = $cart;

header('Location: shopcart.php');