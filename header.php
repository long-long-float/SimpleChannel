<?php
require_once 'common.php';

session_start();

if(!is_loggedin()) {
  redirect_to("/login.php");
  return;
}

function render_header($title) {

  $db = new DatabaseWrapper();

  if(is_loggedin()) {
    $sql = "select id, name, point from users where id = ?";
    $current_user = $db->execute_sql($sql, array($_SESSION["user_id"]))[0];
  }

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php html($title); ?></title>
</head>
<body>
<div style="color:red;"><?php html(get_error()); ?></div>
<?php html($current_user["name"]); ?>さん　こんにちは <?php html($current_user["point"]); ?>ポイント
<a href="/deposit.php">ポイントのチャージ</a>
<a href="/logout.php">ログアウト</a>

<?php } ?>