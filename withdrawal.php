<?php
    require 'dbconnect.php';
    session_start();

    try {
        $login_user = $_SESSION['user_name'];
        $u_deleted = date("Y/m/d H:i:s");
        $stmt = $db->prepare("update users set u_deleted_at = ? 
        WHERE u_username = ? ");
        $stmt->execute([$u_deleted, $login_user]);
        
        header('Location: logout.php');
      } catch (\Exception $e) {
      }   