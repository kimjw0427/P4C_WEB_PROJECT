<?php
  include_once("db.php");
  session_start();

  if(isset($_POST['username']) and isset($_POST['password'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = $db->prepare("SELECT id FROM users WHERE username=? and password=?;");
    $query->bind_param("ss",$username,$password);
    $query->execute();
    $res = $query->get_result();
    $query->close();

    $data = $res->fetch_assoc();
    if(isset($data['id'])){
      $query2 = $db->prepare("SELECT * FROM verify WHERE username=?;");
      $query2->bind_param("s",$username);
      $query2->execute();
      $res2 = $query2->get_result();
      $query2->close();
      $data2 = $res2->fetch_assoc();

      if($data2['isverify']==0){
        $login_msg = 'Login Failed : The email is not verified';
      } else {
        $login_msg = 'Success <script> document.location.href="/index.php";</script>';
        $_SESSION['user'] = $data['id'];
      }
    } else{
      $login_msg = 'Login Failed : Unknown account';
    }
  }

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

      <a class="login_title">LOGIN</a>
      <div class="context_bar"></div>

      <br>

      <div class="context_login">
        <div class="context_login2">
          <form action="login.php" method="post">
            <div class="grid_login">
            <a class="input_context">ID </a>
              <input class="input_box" type="text" name="username">
              <a class="input_context">PASSWORD </a>
              <input class="input_box" type="password" name="password">
            </div>
          <br>
          <input type="submit" id="btn_login" value="Submit">
          <p class="login_msg">
            <?php
              if(isset($login_msg)){
                echo($login_msg);
              }
            ?>
            </p>
          </form>
        </div>
      </div>

    <?php
        include 'menu.php';
    ?>
  </body>
</html>
