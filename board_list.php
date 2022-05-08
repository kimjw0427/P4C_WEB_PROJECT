<?php
    include_once("db.php");
    session_start();

    if(isset($_SESSION['user'])){
        $id = $_SESSION['user'];
        $query = $db->prepare("SELECT username FROM users WHERE id=?;");
        $query->bind_param("i",$id);
        $query->execute();
        $res = $query->get_result();
        $query->close();

        $data = $res->fetch_assoc();
        $session_user = $data['username'];
    }

    if(isset($_GET['order'])){
      if($_GET['order']=='full'){
        $query = $db->prepare("SELECT * FROM board WHERE LOCATE(?, title) > 0 or LOCATE(?, content) > 0 LIMIT 20;");
        $query->bind_param("ss",$_GET['search_content'],$_GET['search_content']);
        $query->execute();
        $res = $query->get_result();
        $query->close();
      } else if($_GET['order']=='title') {
        $query = $db->prepare("SELECT * FROM board WHERE LOCATE(?, title) > 0 LIMIT 20;");
        $query->bind_param("s",$_GET['search_content']);
        $query->execute();
        $res = $query->get_result();
        $query->close();
      } else if($_GET['order']=='content') {
        $query = $db->prepare("SELECT * FROM board WHERE LOCATE(?, content) > 0 LIMIT 20;");
        $query->bind_param("s",$_GET['search_content']);
        $query->execute();
        $res = $query->get_result();
        $query->close();
      }
      
      

    } else {
      $query = $db->prepare("SELECT * FROM board LIMIT 20;");
      $query->execute();
      $res = $query->get_result();
      $query->close();
    }

?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link href='https://fonts.googleapis.com/css?family=Press Start 2P' rel='stylesheet'>
    <link rel="stylesheet" href="ex/bg.css?ver=0.1">
    <link rel="stylesheet" href="ex/text.css">
    <meta charset="utf-8">
    <title>NAME</title>
    <script src="ex/menu.js"></script>
  </head>
  <body bgcolor="#222222">

    <div class="context" id="context_move" style="margin-left: -400px;">

        <a class="login_title">Boards List</a>
        <div class="context_bar"></div>

        <br>

        <form action="board_list.php" id="myForm" method="get">
          <div class="search_box">
            <select name="order" form="myForm">
              <option value="full">제목+내용</option>
              <option value="title">제목</option>
              <option value="content">내용</option>
            </select>
            <input class="search_input_box" type="text" name="search_content">
            <input type="submit" id="btn_search" value="Search">
          </div>
        </form>

        <?php
            $list_html = '';
            while($data = $res->fetch_array()){
                $board_title = '<a class="board_list_title" onclick="javascript:location.href=\'/board.php?id='.$data[id].'\'">'.$data['title'].'</a>';
                $board_username = '<div></div><a class="board_list_other">'.$data['username'].'</a>';
                $board_view = '<a class="board_list_other">'.$data['view'].' Views'.'</a>';
                $list_html = '<div class="board_box">'.$board_title.$board_username.$board_view.'</div>'.$list_html;
            }
            echo($list_html)
        ?>

    <?php
        include 'menu.php';
    ?>
  </body>
</html>