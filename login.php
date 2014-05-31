<?php

require_once 'common.php';

session_start();

if(is_loggedin()) {
  redirect_to("/index.php");
  return;
}

if($_SERVER["REQUEST_METHOD"] === "POST") {
  if(check_for_csrf()) return;

  $db = new DatabaseWrapper();

  $name = $_POST["name"];
  $pass = $_POST["pass"];

  #sql injection
  #$user = $db->execute_sql("select id from users where name = '$name' and password = '$pass'")[0];

  $user = $db->execute_sql("select id from users where name = ? and password = ?", array($name, $pass))[0];

  if($user !== NULL) {
    $_SESSION["user_id"] = $user["id"];
    redirect_to("/index.php");
  } else {
    set_error("ユーザーIDまたはパスワードが違います");
    redirect_to("/login.php");  
  }
}

?>


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Simple Channel</title>
</head>
<body>
<div style="color:red;"><?php html(get_error()); ?></div>
ログインしてね<br>
<form action="/login.php" method="POST">
  <?php create_nonce(); ?>
  user : <input type="text" name="name"><br>
  pass : <input type="password" name="pass"><br>
  <input type="submit" value="login">
</form>
</body>
</html>