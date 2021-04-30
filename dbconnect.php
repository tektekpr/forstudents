<?php
$db = "";
try{
  $db = new PDO('mysql:dbname=hew2020_90031;host=127.0.0.1;charset=utf8','hew2020_90031','');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
  echo 'db接続エラー: '.$e->getMessage() . PHP_EOL;
}
