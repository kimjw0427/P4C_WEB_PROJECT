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
      $login_msg = 'Success';
      $_SESSION['user'] = $data['id'];
    } else{
      $login_msg = 'Login Failed : Unknown account';
    }
  }

  if(isset($_SESSION['user'])){
    $query = $db->prepare("SELECT username FROM users WHERE id=?;");
    $query->bind_param("i",$id);
    $query->execute();
    $res = $query->get_result();
    $query->close();

    $data = $res->fetch_assoc();
    $username = $data['username'];

    $username = 'admin';
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
                echo($username);
              }
            ?>
            </p>
        </div>
      </div>
</form>
  </div>

    <div class="top_bar2"></div>
    <div class="top_bar"></div>

    <p id="name" class="ps-font">name</p>
    <p id="category_note" onclick="on_category();">category</p>
    <p id="write_up">Write</p>
    
    <?php
      if(isset($username)){
        $menu_html='
        <p id="logout" onclick="javascript:location.href=\'/Logout.php\'" >Logout</p>
        <p id="l_g_and_2">/</p>
        <p id="username">'.$username.'</p>
        ';
      } else{
        $menu_html='
        <p id="login" onclick="javascript:location.href=\'/login.php\'" >Login</p>
        <p id="l_g_and">/</p>
        <p id="register">Register</p>
        ';
      }
      echo($menu_html);
    ?>

    <div class="left_bar2" id="on_off_category2" style="display: none;"></div>
    <div class="left_bar" id="on_off_category" style="display: none; overflow:auto;">"
      <ol class="link_list">
        <p></p>

        <p class="ps-font link_list2">Notice</p>
        <ul class="link_list3">
          <li id="popup" onclick="ctg1_1();">Category 1</li>
          <li id="popup" onclick="ctg2_2();">Category 2</li>
          <li id="popup" onclick="ctg3_3();">Category 3</li>
        </ul>

        <br>

        <p class="ps-font link_list2">Board 2</p>
        <ul class="link_list3">
          <li id="popup" onclick="ctg2_1();">Category 1</li>
          <li id="popup" onclick="ctg2_2();">Category 2</li>
          <li id="popup" onclick="ctg2_3();">Category 3</li>
        </ul>

        <br>


        <p class="ps-font link_list2">Board 3</p>
        <ul class="link_list3">
          <li id="popup" onclick="ctg3_1();">Category 1</li>
          <li id="popup" onclick="ctg3_2();">Category 2</li>
          <li id="popup" onclick="ctg3_3();">Category 3</li>
        </ul>

      </ol>
    </div>


  </body>
</html>
