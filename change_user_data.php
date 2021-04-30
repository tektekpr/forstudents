<?php
    require 'dbconnect.php';
    require 'session.php';

    function Logout(){
        $output = '';
        if (isset($_SESSION["EMAIL"])) {
        $output = 'Logoutしました。';
        } else {
            $output = 'SessionがTimeoutしました。';
            }
        //セッション変数のクリア
        $_SESSION = array();
        //セッションクッキーも削除
        if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
        }
        //セッションクリア
        @session_destroy();

        echo $output;

        header('Location: index.html');
        exit();
    }

    $error1 = '';
    $error2 = '';
    $error3 = '';
    $error4 = '';
    $error5 = '';

    $login_user = $_SESSION['user_name'];

    $stmt = $db->prepare('select * from Users where u_username = ?');
    $stmt->execute([$_SESSION['user_name']]);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    //ユーザー名変更処理
    if(isset($_POST['username'])){
        try {
            $username = $_POST['username'];
            /*$sql  = 'update users SET u_username = :USERNAME where u_username = :LOGINUSER';
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':USERNAME', $username, PDO::PARAM_STR);
            $stmt->bindParam(':LOGINUSER', $loginuser, PDO::PARAM_STR);
      
            $stmt->execute();*/
            $stmt = $db->prepare("update users set u_username = ? 
            WHERE u_username = ? ");
            $stmt->execute([$username, $login_user]);
            $error1 = "変更完了";

            /*セッション情報変更*/
            $_SESSION['user_name'] = $username;

            //header('Location: login.php');
          } catch (\Exception $e) {
            $error1 = '登録済みのユーザー名です。';
          }
          
    }

    if(isset($_POST['email'])){
          //POSTのValidate。
        if (!$email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $error2 = '入力された値が不正です。';
            //return false;
        }else{     
            try {
                $mail = $_POST['email'];
                $stmt = $db->prepare("update users set u_mail = ? 
                WHERE u_username = ? ");
                $stmt->execute([$mail, $login_user]);
                //ログアウト処理
                Logout();

                //header('Location: login.php');
              } catch (\Exception $e) {
                $error2 = '登録済みのユーザー名です。';
              }   
        }
    }

    if(isset($_POST['password'])){
        //パスワードの正規表現
        if (preg_match('/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,100}+\z/i', $_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            try {
                $mail = $_POST['password'];
                $stmt = $db->prepare("update users set u_password = ? 
                WHERE u_username = ? ");
                $stmt->execute([$password, $login_user]);
                //ログアウト処理
                Logout();

                //header('Location: login.php');
              } catch (\Exception $e) {
                $error3 = 'エラーが発生しました';
              }   
        } else {
            $error3 = 'パスワードは半角英数字をそれぞれ1文字以上含んだ8文字以上で設定してください。';
            //return false;
        }
    }

    if(isset($_POST['club'])){
        try {
            $club = $_POST['club'];
            $stmt = $db->prepare("update users set u_club = ? 
            WHERE u_username = ? ");
            $stmt->execute([$club, $login_user]);
            
            $error4 = '変更完了';
            //header('Location: login.php');
          } catch (\Exception $e) {
            $error4 = 'エラーが発生しました';
          }   
    }

    if(isset($_POST['comment'])){
        try {
            $comment = $_POST['comment'];
            $stmt = $db->prepare("update users set u_comment = ? 
            WHERE u_username = ? ");
            $stmt->execute([$comment, $login_user]);
            
            $error5 = '変更完了';
            //header('Location: login.php');
          } catch (\Exception $e) {
            $error5 = 'エラーが発生しました';
          }   
    }

    if (empty($row['u_club'])) {
        $row['u_club'] = "未記入";
    }
    if (empty($row['u_comment'])) {
        $row['u_comment'] = "未記入";
    }


?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- ctrl + / -->
    <!-- meta キャッシュ削除　作業用のため消してください -->
    <meta http-equiv="Cache-Control" content="no-cache">
    <meta name="robots" content="none,noindex,nofollow">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/change_user_data.css">
    <title>TAMARIBA | 登録情報・プロフィールの変更</title>
</head>
<body>
    <?php include('header.php'); ?>
    <div class="wrapper">
        <h2>登録情報・プロフィールの変更</h2>
        <p class="subtitle">ユーザー名、メールアドレス及びパスワードの変更を行った場合一度ログアウトされます。</p>
        <div class="form_wrapper">
            <div class="inner_change">
                <h3>ユーザー名</h3>
                <div class="inner_form">
                    <p class="form_text"><?php echo $row['u_username']; ?></p>
                    <form action="change_user_data.php" method="post">
                        <input class="textbox" type="text" maxlength="50" name="username" required>
                        <input class="button" type="submit" value="保存">

                    </form>
                </div>
                <?php echo "<p class='error'>".$error1."</p>";?>
            </div>
            <div class="inner_change">
                <h3>メールアドレス</h3>
                <div class="inner_form">
                    <p class="form_text"><?php echo $row['u_mail']; ?></p>
                    <form action="change_user_data.php" method="post">
                        <input class="textbox" type="email" name="email" required>
                        <input class="button" type="submit" value="保存">

                    </form>
                </div>
                <?php echo "<p class='error'>".$error2."</p>";?>
            </div>
            <div class="inner_change">
                <h3>パスワード</h3>
                <div class="inner_form">
                    <p>パスワードは定期的な変更を推奨します。</p>
                    <form action="change_user_data.php" method="post">
                        <input class="textbox" type="password" name="password" required>
                        <input class="button" type="submit" value="保存">

                    </form>
                </div>
                <?php echo "<p class='error'>".$error3."</p>";?>
            </div>
            <div class="inner_change">
                <h3>所属部活編集</h3>
                <div class="inner_form">
                    <p class="form_text"><?php echo $row['u_club']; ?></p>
                    <form action="change_user_data.php" method="post">
                        <input class="textbox" type="text" maxlength="50" name="club" required>
                        <input class="button" type="submit" value="保存">

                    </form>
                </div>   
                <?php echo "<p class='error'>".$error4."</p>";?>           
            </div>
            <div class="inner_change">
                <h3>コメント編集</h3>
                <div class="inner_form">
                    <p class="form_text"><?php echo $row['u_comment']; ?></p>
                    <form action="change_user_data.php" method="post">
                        <input class="textbox" type="text" maxlength="140" name="comment">
                        <input class="button" type="submit" value="保存">

                    </form>
                </div>  
                <?php echo "<p class='error'>".$error5."</p>";?>              
            </div>
        </div>
    </div>
    <?php include('footer.html'); ?>
</body>
</html>