<?php

require_once 'header.php';

$db = new DatabaseWrapper();

$method = $_SERVER["REQUEST_METHOD"];
if($method === "POST") {
  if(check_for_csrf()) return;

  $db->execute_sql("insert into threads (name) values (?)", array($_POST["name"]));
  
  return redirect_to("/index.php");
  
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
  <?php html($response["content"]); ?><hr>
<?php } ?>
<form action="/response.php" method="POST">
  <?php create_nonce(); ?>
  <input type="hidden" name="thread_id" value="<?php html($thread["id"]); ?>">
  <textarea name="content"></textarea>
  <input type="submit" value="投稿">
</form>

<?php require_once 'footer.php'; render_footer(); ?>