</div>

<div class="top_bar2"></div>
<div class="top_bar"></div>

<p id="name" class="ps-font">name</p>
<p id="category_note" onclick="on_category();">category</p>
<p id="write_up" onclick="javascript:location.href='/write.php'">Write</p>

<?php
  if(isset($session_user)){
    $menu_html='
    <p id="logout" onclick="javascript:location.href=\'/logout.php\'" >Logout</p>
    <p id="l_g_and_2">/</p>
    <p id="username">'.$session_user.'</p>
    ';
  } else{
    $menu_html='
    <p id="login" onclick="javascript:location.href=\'/login.php\'" >Login</p>
    <p id="l_g_and">/</p>
    <p id="register" onclick="javascript:location.href=\'/register.php\'">Register</p>
    ';
  }
  echo($menu_html);
?>

<div class="left_bar2" id="on_off_category2" style="display: none;"></div>
<div class="left_bar" id="on_off_category" style="display: none; overflow:auto;">"
  <ol class="link_list">
    <p></p>

    <p class="ps-font link_list2">MAIN</p>
    <ul class="link_list3">
      <li id="popup" onclick="javascript:location.href='/index.php'">Main page</li>
      <li id="popup" onclick="javascript:location.href='/write.php'">Write</li>
    </ul>

    <br>

    <p class="ps-font link_list2">Board</p>
    <ul class="link_list3">
      <li id="popup" onclick="javascript:location.href='/board_list.php'">Board1</li>
    </ul>

    <br>


    <p class="ps-font link_list2">UNKNOWN</p>
    <ul class="link_list3">
      <li id="popup" onclick="ctg('NULL');">Category 1</li>
      <li id="popup" onclick="ctg('NULL');">Category 2</li>
      <li id="popup" onclick="ctg('NULL');">Category 3</li>
    </ul>

  </ol>
</div>


</body>