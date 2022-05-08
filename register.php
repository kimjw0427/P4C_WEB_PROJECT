<?php
  include('PHPMailer/src/Exception.php');
  include('PHPMailer/src/PHPMailer.php');
  include('PHPMailer/src/SMTP.php');

  use PHPMailer\PHPMailer\PHPMailer;
  use PHPMailer\PHPMailer\Exception;
  use PHPMailer\PHPMailer\SMTP;

  include_once("db.php");
  session_start();

  if(isset($_POST['username']) and isset($_POST['email']) and isset($_POST['password']) and isset($_POST['password2'])){
    $username = $_POST['username'];
    $email = $_POST['email']; 
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    $reg_msg = 'True';

    $query1 = $db->prepare("SELECT id FROM users WHERE username=?;");
    $query1->bind_param("s",$username);
    $query1->execute();
    $res1 = $query1->get_result();
    $query1->close();
    $data1 = $res1->fetch_assoc();

    $query2 = $db->prepare("SELECT id FROM users WHERE email=?;");
    $query2->bind_param("s",$email);
    $query2->execute();
    $res2 = $query2->get_result();
    $query2->close();
    $data2 = $res2->fetch_assoc();

    if(!preg_match('/^[a-z0-9]*$/i', $username)){
        $reg_msg = 'REGISTER FAILED : Invalid charater in username';
    } elseif(!preg_match('/^[a-z0-9]*$/i', $password)){
        $reg_msg = 'REGISTER FAILED : Invalid charater in password';
    } elseif(!($password==$password2)){
        $reg_msg = 'REGISTER FAILED : The passwords are not same.';
    } elseif(isset($data1['id'])){
        $reg_msg = 'REGISTER FAILED : The username is already existed';
    } elseif(isset($data2['id'])){
        $reg_msg = 'REGISTER FAILED : The email is already existed';
    }

    $mail = new PHPMailer(true);
    $mail->IsSMTP();

    if($reg_msg == 'True'){
      try {
        $random = rand (1000000000,9999999999);
        $date = $time = date("YmdHis");
        $verify_code = $date.$time.$username;
        $is_verify = 0;

        $mail->Host = "smtp.gmail.com";
        $mail->SMTPAuth = true;
        $mail->Port = 465;
        $mail->SMTPSecure = "ssl";
        $mail->Username   = "MYEMAIL";
        $mail->Password   = "MYPASSWORD";


        $mail->SetFrom('uz.56764@gmail.com', 'email verify');
        $mail->AddAddress($_POST['email'], $_POST['username']);

        $mail->Subject = 'Email verify!';        // 메일 제목
        $mail->MsgHTML("Email verify! http://127.0.0.1/verify.php?code=".$verify_code."&username=".$username);

        $mail->Send(); 

        echo "Message Sent OK<p></p>\n";

      } catch (phpmailerException $e) {
        $reg_msg = 'REGISTER FAILED : Invalid email.';
      }
    }

    if($reg_msg == 'True'){
        $query3 = $db->prepare("INSERT INTO users(username,email,password) VALUES(?,?,?);");
        $query3->bind_param("sss",$username,$email,$password);
        $query3->execute();
        $query3->close();

        $query3 = $db->prepare("INSERT INTO verify(username,email,code,isverify) VALUES(?,?,?,?);");
        $query3->bind_param("sssi",$username,$email,$verify_code,$is_verify);
        $query3->execute();
        $query3->close();

        $reg_msg = 'Success <script> document.location.href="/login.php";</script>';
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

      <a class="login_title">REGISTER</a>
      <div class="context_bar"></div>

      <br>

      <div class="context_login">
        <div class="context_login2">
          <form action="register.php" method="post">
            <div class="grid_register">
              <a class="input_context">ID </a>
              <input class="input_box" type="text" name="username">
              <a class="input_context">EMAIL </a>
              <input class="input_box" type="text" name="email">
              <a class="input_context">PASSWORD </a>
              <input class="input_box" type="password" name="password">
              <a class="input_context">PS CONFIRM </a>
              <input class="input_box" type="password" name="password2">
            </div>
            <br>
            <input type="submit" id="btn_login" value="Submit">
            <p class="login_msg">
            <?php
              if(isset($reg_msg)){
                echo($reg_msg);
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
