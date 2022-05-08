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

  if(isset($session_user)){
    $user_id = $_SESSION['user'];
    $board_id = $_POST['board_id'];
    $content = $_POST['comment_content'];
    $username = $session_user;

    $query = $db->prepare("INSERT INTO comment(username,content,user_id,board_id) VALUES(?,?,?,?);");
    $query->bind_param("ssii",$username,$content,$user_id,$board_id);
    $query->execute();
    $query->close();

    echo('<script> document.location.href="/board.php?id='.$board_id.'";</script>');

  } else {
    echo('<script>alert("You must login!"); document.location.href="/board.php?id='.$board_id.'";</script>');
  }
?>