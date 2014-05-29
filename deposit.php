<?php

require_once 'common.php';

session_start();

if(!is_loggedin()) {
  redirect_to("/index.php");
}

$db = new DatabaseWrapper();

if(is_loggedin()) {
  $sql = "select id, name, point from users where id = ?";
  $current_user = $db->execute_sql($sql, array($_SESSION["user_id"]))[0];
}

$method = $_SERVER["REQUEST_METHOD"];
if($method === "POST") {
  if(check_for_csrf()) return;

  $db->execute_sql("update users set point = ? where id = ?", array((int)$_POST["money"] + $current_user["point"], $current_user["id"]));
  
  return redirect_to("/index.php");
}

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>ポイントのチャージ</title>
</head>
<body>
<a href="/index.php">Top</a>
<form action="/deposit.php" method="POST">
  <?php create_nonce(); ?>
  金額 <input type="number" name="money">
  <input type="submit" value="チャージ">
</form>
</body>
</html>
