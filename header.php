<?php
require_once 'common.php';

function render_header($title) {

  $db = new DatabaseWrapper();
  $current_user = current_user($db);
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php html($title); ?></title>
</head>
<body>
<div style="color:red;"><?php html(get_error()); ?></div>
<a href="/index.php">Simple Channel</a>
<?php if(is_loggedin()) { ?>
  / <?php html($current_user["name"]); ?>さん こんにちは / <?php html($current_user["point"]); ?>ポイント
  <a href="/deposit.php">ポイントのチャージ</a> /
  <a href="/logout.php">ログアウト</a>
<?php } ?>
<hr>

<?php } ?>