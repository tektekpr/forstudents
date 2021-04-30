<?php
//本来はissetチェックが必要
session_start();

$carts = $_GET['sid'];
// カート初期化
$cart = [];
// カート存在チェック
if(isset($_SESSION['carts'])){
    //あれば一度引っこ抜く
    $cart = $_SESSION['carts'];
    print_r($cart);
}
if( in_array($carts,$cart)){
    //なければ削除
    $ct[] = $carts;
    $cart = array_diff($cart,$ct);
    $cart = array_values($cart);
}
// $cart[] = $_GET['sid'];

//セッション領域の上書き
$_SESSION['carts'] = $cart;

header('Location: shopcart.php');