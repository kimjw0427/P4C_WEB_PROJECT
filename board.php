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

  if(isset($_GET['id'])){
    $id = $_GET['id'];
    $query = $db->prepare("SELECT * FROM board WHERE id=?;");
    $query->bind_param("i",$id);
    $query->execute();
    $res = $query->get_result();
    $query->close();

    $data = $res->fetch_assoc();
    $board_username = $data['username'];
    $board_title = $data['title'];
    $board_content = $data['content'];
    $board_time = $data['date'];
    $board_recm = $data['recm'];

    $query = $db->prepare("SELECT * FROM file_db WHERE board_id=?;");
    $query->bind_param("i",$_GET['id']);
    $query->execute();
    $res = $query->get_result();
    $query->close();
    $data = $res->fetch_assoc();

    if(isset($data['file_name'])){
      $file = True;
    }


    $ip = $_SERVER['REMOTE_ADDR'];
    $query = $db->prepare("SELECT date FROM view_limit WHERE board_id=? and ip=?;");
    $query->bind_param("is",$id,$ip);
    $query->execute();
    $res = $query->get_result();
    $query->close();
  
    $data = $res->fetch_assoc();
    if(isset($data['date'])){
      $p_date = $data['date'];
      $limit_time = date("Y-m-d H:i:s",strtotime("-1 hours"));
      if(strtotime($p_date) < strtotime($limit_time)){
        $time = date("Y-m-d H:i:s");
        $query = $db->prepare("UPDATE view_limit SET date=? WHERE board_id=? and ip=?;");
        $query->bind_param("sis",$time,$id,$ip);
        $query->execute();
        $query->close();


        $query = $db->prepare("SELECT * FROM board WHERE id=?;");
        $query->bind_param("i",$id);
        $query->execute();
        $res = $query->get_result();
        $query->close();
    
        $data = $res->fetch_assoc();
        $p_view = $data['view']+1;

        $query = $db->prepare("UPDATE board SET view=? WHERE id=?;");
        $query->bind_param("ii",$p_view,$id);
        $query->execute();
        $query->close();
      }

    } else {
      $time = date("Y-m-d H:i:s");

      $query = $db->prepare("INSERT INTO view_limit(ip,board_id,date) VALUES(?,?,?);");
      $query->bind_param("sis",$ip,$id,$time);
      $query->execute();
      $query->close();

      $query = $db->prepare("SELECT * FROM board WHERE id=?;");
      $query->bind_param("i",$id);
      $query->execute();
      $res = $query->get_result();
      $query->close();
  
      $data = $res->fetch_assoc();
      $p_view = $data['view'] + 1;

      $query = $db->prepare("UPDATE board SET view=? WHERE id=?;");
      $query->bind_param("ii",$p_view,$id);
      $query->execute();
      $query->close();
    }

    $query = $db->prepare("SELECT * FROM comment WHERE board_id=? LIMIT 20;");
    $query->bind_param("i",$id);
    $query->execute();
    $res = $query->get_result();
    $query->close();

  }

  
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link href='https://fonts.googleapis.com/css?family=Press Start 2P' rel='stylesheet'>
    <link rel="stylesheet" href="ex/bg.css">
    <link rel="stylesheet" href="ex/text.css">
    <meta charset="utf-8">
    <title>NAME</title>
    <script src="ex/menu.js"></script>
  </head>
  <body bgcolor="#222222">

    <div class="context" id="context_move" style="margin-left: -400px;">

      <a class="title"><?php echo htmlspecialchars($board_title.' ');?></a>
      <a class='date'><?php echo htmlspecialchars($board_time);?></a>
      <div class="context_bar"></div>

      <a class="board_username"><?php echo htmlspecialchars($board_username);?></a>

      <br>

      <p><?php echo htmlspecialchars($board_content);?></p>

      <?php
        echo("<p class='board_recm' onclick='javascript:location.href=\"recommand.php?id=".$id."\"'>추천 :".$board_recm."<p>");
      ?>

      <br>
      <div class="context_bar2"></div>
      <br>

      <form action="comment.php" method="post">
        <div class="grid_comment">
          <div></div>
          <textarea class="input_comment" type="text" name="comment_content"></textarea>
          <?php
            echo('<input type="hidden" name="board_id" value="'.$_GET['id'].'"/>');
          ?>
          <input type="submit" id="btn_comment" value="Submit">
        </div>
      </form>

      <br>
      <br>

      <?php
            $list_html = '';
            while($data = $res->fetch_array()){
                $comment_title = '<a class="comment_list_title">'.$data['content'].'</a>';
                $comment_username = '<div></div><a class="comment_list_other">'.$data['username'].'</a>';
                $list_html = '<div class="comment_box">'.$comment_title.$comment_username.'</div>'.$list_html;
            }
            echo($list_html)
        ?>

      <?php
        include 'menu.php';
    ?>
  </body>
</html>
