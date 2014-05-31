<?php
require_once 'header.php'; render_header("ポイントのチャージ");

for_only("users");

if($_SERVER["REQUEST_METHOD"] === "POST") {
  if(check_for_csrf()) return;

  $db = new DatabaseWrapper();
  $current_user = current_user($db);
  $db->execute_sql("update users set point = ? where id = ?", array((int)$_POST["money"] + $current_user["point"], $current_user["id"]));
  
  return redirect_to("/index.php");
}

?>

<form action="/deposit.php" method="POST">
  <?php create_nonce(); ?>
  金額 <input type="number" name="money">
  <input type="submit" value="チャージ">
</form>

<?php require_once 'footer.php'; render_footer(); ?>