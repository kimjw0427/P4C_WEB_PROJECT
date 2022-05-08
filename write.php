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

  if(!isset($session_user)){
      echo("<script> document.location.href='/index.php'; alert('You are not logged in!'); </script>");
  }

  if(isset($session_user) and isset($_POST['title']) and isset($_POST['content'])){
    $title = $_POST['title'];
    $content = $_POST['content'];
    $time = date("Y-m-d H:i:s");


    $query3 = $db->prepare("INSERT INTO board(username,title,content,date) VALUES(?,?,?,?);");
    $query3->bind_param("ssss",$session_user,$title,$content,$time);
    $query3->execute();
    $query3->close();

    echo("<script> document.location.href='/index.php';</script>");

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

        <a class="login_title">WRITE</a>
        <div class="context_bar"></div>

        <br>

        <form action="write.php" id="WriteUpload" method="post">
            <div class="grid_write">
                <div></div><div></div>
                <a class="input_context">TITLE </a>
                <input class="input_title" type="text" name="title">
                <div></div><div></div>
                <div class="grid_content">
                    <div></div>
                    <textarea class="input_content" type="text" name="content"></textarea>
                </div>
            </div>
        </form>
        <form action="upload.php" id="FileUpload" method="post" target="hidden_iframe" enctype="multipart/form-data">
          File upload:
          <input type="file" name="uploadfile">
        </form>

        <br>
        <input type="submit" id="btn_write" onclick="document.getElementById('WriteUpload').submit();document.getElementById('FileUpload').submit();" value="Submit">
        <iframe name="hidden_iframe" style="display:none;"></iframe>
    </div>

    <?php
        include 'menu.php';
    ?>
  </body>
</html>