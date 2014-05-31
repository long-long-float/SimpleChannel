<?php

require_once 'header.php';

for_only("users");

$db = new DatabaseWrapper();

$method = $_SERVER["REQUEST_METHOD"];
if($method === "POST") {
  if(check_for_csrf()) return;

  $thread_name = $_POST["name"];
  if(mb_strlen($thread_name, "UTF-8") > 128) {
    set_error("スレタイが長過ぎます");
    redirect_to("index.php");
    return;
  }
  $db->execute_sql("insert into threads (name) values (?)", array($_POST["name"]));
  
  redirect_to("/index.php");
  return;
  
} elseif ($method === "GET") {
  $id = $_GET["id"];
}

$thread = $db->find_by("id", $id, "threads", array("id", "name"))[0];
if($thread === NULL) {
  require_once '404.php';
  render404("スレッドが見つかりませんでした...");
  return;
}
$responses = $db->find_by("thread_id", $id, "responses", array("id", "content"));

render_header($thread["name"]);

?>

<h1><?php html($thread["name"]); ?></h1>
<?php foreach ($responses as $response) { ?>
  <?php
    $res = $response["content"];
    html(preg_replace("/https?:\/\/[\w.]+/", "<a href='/cushion.php?url=$0'>$0</a>", $res));
  ?><hr>
<?php } ?>
<form action="/response.php" method="POST">
  <?php create_nonce(); ?>
  <input type="hidden" name="thread_id" value="<?php html($thread["id"]); ?>">
  <textarea name="content"></textarea>
  <input type="submit" value="投稿">
</form>

<?php require_once 'footer.php'; render_footer(); ?>