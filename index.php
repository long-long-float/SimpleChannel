<?php
require_once 'common.php';

session_start();

$db = new DatabaseWrapper();

if(is_loggedin()) {
  $sql = "select id, name from users where id = ?";
  $current_user = $db->execute_sql($sql, array($_SESSION["user_id"]))[0];
}

$threads = $db->execute_sql("select id, name from threads");

$nonce = session_id();
$_SESSION["nonce"] = $nonce;

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Simple Channel</title>
</head>
<body>
<div style="color:red;"><?php html(get_error()); ?></div>
<?php if(!is_loggedin()) { ?>
  ログインしてね<br>
  <form action="/login.php" method="POST">
    user : <input type="text" name="name"><br>
    pass : <input type="password" name="pass"><br>
    <input type="submit" value="login">
  </form>
<?php } else { ?>
  <?php html($current_user["name"]."さん　こんにちは"); ?>
  <a href="/logout.php">ログアウト</a>
  <ul>
    <?php foreach ($threads as $thread) { ?>
      <li><a href="/thread.php?id=<?php html($thread["id"]); ?>"><?php html($thread["name"]); ?></a></li>
    <?php } ?>
  </ul>
  <h4>スレをたてる</h4>
  <form action="/thread.php" method="POST">
    <input type="hidden" name="nonce" value="<?php echo md5($nonce); ?>">
    <input type="text" name="name">
    <input type="submit" value="つくる">
  </form>
<?php } ?>
</body>
</html>
