<?php
  require 'session.php';

/*$user_id=16;
$t_q_id=1;
$t_id=0;
if (isset($_POST['t_id'])) {
  $t_id=$_POST['t_id'];
}
if (isset($_POST['t_q_id'])) {
  $t_q_id=$_POST['t_q_id'];
}*/

 ?>
 <script type="text/javascript">
 //選択肢追加
  var cnt=[2,2,2,2,2,2,2,2,2,2];
  function choice_plus(i){
    if(cnt[i-1]<=10){
       var div1 = document.getElementById("t_plus" + i);
       var p1 = document.createElement("p");
       var text1 = document.createTextNode(cnt[i-1]);
       var input1 = document.createElement("input");
       input1.setAttribute("class","t tt");
       input1.setAttribute("type","text");
       input1.setAttribute("name","text"+ i + "-" +cnt[i-1]);
       p1.appendChild(text1);
       p1.appendChild(input1);
       div1.appendChild(p1);
      //回答番号追加
       var select1 = document.getElementById("select" + i);
       var option1 = document.createElement("option");
       var text2 = document.createTextNode(cnt[i-1]);
       option1.setAttribute("value",cnt[i-1]);
       option1.appendChild(text2);
       select1.appendChild(option1);

       var s_cnt = document.getElementById("s_cnt" + i);
       s_cnt.setAttribute("value",cnt[i-1]);

       if(cnt[i-1]==10){
         div2 = document.getElementById("t_choice" + i).remove();
       }
       cnt[i-1]+=1;
    }
  }
   //問題追加
  function change($i){
    //console.log("hello");
    var change = document.querySelector('.openout');
    change.className = 'hideout';
    var change2 = document.getElementById($i);
    change2.className = 'openout';
  }
 </script>
 <script type="text/javascript">
    var q_cnt =2;
    function q_plus(){
      if(q_cnt<=10){
        var q_plus = document.getElementById("q_plus");
        //element.id = "q_plus " + q_cnt;
        //div作成
        var div = document.createElement("div");
        div.setAttribute("id",q_cnt);
        div.setAttribute("class","hideout");
        //問題内容作成
        var p1 = document.createElement("h3");
        var text1 = document.createTextNode("問題" + q_cnt);
        var input1 = document.createElement("textarea");
        input1.setAttribute("type","text");
        input1.setAttribute("name","t_body"+q_cnt);
        input1.setAttribute("maxlength","255");
        input1.setAttribute("required","required");
        p1.appendChild(text1);
        div.appendChild(p1);
        div.appendChild(input1);
        //選択肢作成
        var p2 = document.createElement("h3");
        var text2 = document.createTextNode("選択肢");
        var div2 = document.createElement("div");
        div2.setAttribute("class","t_choice");
        div2.setAttribute("id","t_plus" + q_cnt);
        var p3 = document.createElement("p");
        var text3 = document.createTextNode("1");
        var input3 = document.createElement("input");
        input3.setAttribute("class","t tt");
        input3.setAttribute("type","text");
        input3.setAttribute("name","text"+q_cnt+"-1");
        input3.setAttribute("maxlength","255");
        input3.setAttribute("required","required");
        p2.appendChild(text2);
        p3.appendChild(text3);
        p3.appendChild(input3);
        div2.appendChild(p3);
        div.appendChild(p2);
        div.appendChild(div2);
        //選択肢追加
        var p4 = document.createElement("button");
        p4.setAttribute("id","t_choice" + q_cnt);
        p4.setAttribute("onclick","choice_plus(" + q_cnt + ")");
        var text4 = document.createTextNode("選択肢を追加する");
        p4.appendChild(text4);
        div.appendChild(p4);
        //hidden
        var input_c = document.createElement("input");
        input_c.setAttribute("type","hidden");
        input_c.setAttribute("name","s_cnt" + q_cnt);
        input_c.setAttribute("value","1");
        input_c.setAttribute("id","s_cnt" + q_cnt);
        div.appendChild(input_c);
        //回答作成
        var p5 = document.createElement("h3");
        var text5 = document.createTextNode("回答");
        var select = document.createElement("select");
        select.setAttribute("class","t_ans");
        select.setAttribute("name","t_answer" + q_cnt);
        select.setAttribute("id","select" + q_cnt);
        var option = document.createElement("option");
        var text5a = document.createTextNode("1");
        select.setAttribute("value","1");
        option.appendChild(text5a);
        select.appendChild(option);
        p5.appendChild(text5);
        div.appendChild(p5);
        div.appendChild(select);
        //解説作成
        var p6 = document.createElement("h3");
        var text6 = document.createTextNode("解説");
        var textarea2 = document.createElement("textarea");
        textarea2.setAttribute("name","t_answer_body" + q_cnt);
        textarea2.setAttribute("rows","4");
        textarea2.setAttribute("cols","80");
        textarea2.setAttribute("maxlength","255");
        textarea2.setAttribute("required","required");
        p6.appendChild(text6);
        div.appendChild(p6);
        div.appendChild(textarea2);

        //選択欄表示
        var divs = document.getElementById("change");
        var as = document.createElement("a");
        var texts = document.createTextNode(q_cnt);
        as.setAttribute("class","change");
        as.setAttribute("href","#");
        as.setAttribute("onclick","change(" + q_cnt + ")");
        as.appendChild(texts);
        divs.appendChild(as);
        
        var cnt = document.getElementById("cnt");
        cnt.setAttribute("value",q_cnt);
        //すべてを表示
        q_plus.appendChild(div);
        change(q_cnt);
        //問題追加の終了
        if(q_cnt==10){
          div2 = document.getElementById("div2").remove();
        }
        q_cnt+=1;

      }

    }
 </script>
<!DOCTYPE html>
<html lang="ja" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="robots" content="none,noindex,nofollow">

    <title>TAMARIBA | テスト作成</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="css/qa_create_form.css"> -->
    <link rel="stylesheet" href="css/testnewmake.css">
  </head>

  <body>
    <?php include('header.php');?>
    <div class="wrapper">
      <div class="title_menu">
          <h2>テスト作成</h2>
          <p><a href="test_list.php">テスト管理</a></p>
          <p style="right:160px;"><a href="testserch.php">テスト一覧</a></p>
      </div>
      <main>
        <p style="margin-bottom: 20px;">あなたの知識を皆さんの勉強に役立てましょう！</p>
        <form action="testmakepost.php" method='post'>
          <h3>テスト名</h3><input type="text" class="t" name="t_title" maxlength="50" required>
          <div id="q_plus">
            <div id="1" class="openout">
              <h3>問題1</h3><textarea type="text" name="t_body1" maxlength="255" required></textarea>
              <h3>選択肢</h3>
              <div class="t_choice" id="t_plus1">
                <p>1<input type="text" class="t tt" name="text1-1" maxlength="100" required></p>
              </div>
              <button id="t_choice1" onclick="choice_plus(1);">選択肢を追加する</button>
              <input type="hidden" name="s_cnt1" value="1" id="s_cnt1">
              <h3>回答</h3>
              <select class="t_ans" name="t_answer1" id="select1">
                <option value="1">1</option>
              </select>
              <h3>解説</h3>
              <textarea name="t_answer_body1" rows="4" cols="80" maxlength="255" required></textarea>
            </div>
          </div>
          <div id="change"><a href="#" onclick="change(1)" class="change">1</a></div>
          <button id="div2" onclick="q_plus()">問題を追加する</button>
          <button type="submit">問題作成を終了する</button>
          <input type="hidden" name="cnt" value="1" id="cnt">
        </form>
      </main>
    </div>
    <?php include('footer.html'); ?>

  </body>
</html>
