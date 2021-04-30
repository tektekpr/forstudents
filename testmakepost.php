<?php
    require 'session.php';
    require 'dbconnect.php';

    $cnt = '';
    $u_ID = '';
    $t_title = '';
    $t_count = 0;
    $t_created_at = date("Y/m/d H:i:s");

    $t_q_id = [];
    $t_body = [];
    $t_answer = [];
    $t_answer_body = [];
    $s_cnt = [];

    $t_a_id = [[]];
    $t_ch_body = [[]];


    if(empty($_POST)){
        //header('Location: testserch.php');
        //exit();
    }else{
        $cnt = $_POST['cnt'];
        $u_ID = $_SESSION['u_ID'];
        $t_title = $_POST['t_title'];
        for ($i=1; $i <= $cnt ; $i++) { 
            $s_cnt[$i] = $_POST['s_cnt'.$i];
            $t_q_id[$i] = $i;
            $t_body[$i] = $_POST['t_body'.$i];
            $t_answer[$i] = $_POST['t_answer'.$i];
            $t_answer_body[$i] = $_POST['t_answer_body'.$i];
            for ($j=1; $j <= $s_cnt[$i]; $j++) { 
                $t_a_id[$i][$j] = $j;
                $t_ch_body[$i][$j] = $_POST['text'.$i.'-'.$j];
            }
        }
    }
    print_r($s_cnt);


    try {
        //testへの登録
        $stmt = $db->prepare("insert into test(t_createuser,t_title , t_count, t_created_at) value(?, ?, ?, ?)");
        $stmt->execute([$u_ID,$t_title,$t_count,$t_created_at]);

        //t_id取得
        $stmt = $db->prepare('select t_id from test where t_createuser = ? AND t_created_at = ?');
        $stmt->execute([$u_ID,$t_created_at]);
        $t_id = $stmt->fetch(PDO::FETCH_ASSOC);
        echo $t_id['t_id'];

        //testQuestionへの登録
        for ($i=0; $i < $cnt; $i++) { 
            $stmt = $db->prepare("insert into testQuestion(t_id, t_q_id, t_body, t_answer, t_answer_body) value(?, ?, ?, ?, ?)");
            $stmt->execute([$t_id['t_id'],$t_q_id[$i+1],$t_body[$i+1],$t_answer[$i+1],$t_answer_body[$i+1]]);
            for ($j=0; $j < $s_cnt[$i+1]; $j++) { 
                $stmt = $db->prepare("insert into testChoice(t_id, t_q_id, t_a_id, t_ch_body) value(?, ?, ?, ?)");
                $stmt->execute([$t_id['t_id'],$t_q_id[$i+1],$t_a_id[$i+1][$j+1],$t_ch_body[$i+1][$j+1]]);
            }
        }
        

    } catch (PDOException $error) {
        echo $error;
    }

    header('Location: testserch.php')

?>