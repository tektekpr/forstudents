<?php
function h($s){
  return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

session_start();
//ログイン済みの場合
if (isset($_SESSION['user_name'])) {
  $user =  'ようこそ' .  h($_SESSION['user_name']) . "さん";
}else{
  header('Location: index.html');
}
?>