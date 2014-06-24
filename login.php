<?php

require_once 'common.php';

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
    #open redirect
    if(isset($_POST["redirect"]) && preg_match("/\A\/[^\/]/", $_POST["redirect"])) {
      redirect_to($_POST["redirect"]);
    } else {
      redirect_to("/index.php");
    }
    return;
  } else {
    set_error("ユーザーIDまたはパスワードが違います");
    redirect_to("/login.php");
    return;
  }
}

require_once 'header.php'; render_header("ログイン");

?>

<form action="/login.php" method="POST">
  <?php create_nonce(); ?>
  <input type="hidden" name="redirect" value="<?php html($_GET["redirect"]); ?>">
  user : <input type="text" name="name"><br>
  pass : <input type="password" name="pass"><br>
  <input type="submit" value="login">
</form>

<?php require_once 'footer.php'; render_footer(); ?>