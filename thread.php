<?php

require_once 'common.php';

session_start();

if(!is_loggedin()) {
  redirect_to("/index.php");
}

$db = new DatabaseWrapper();

$method = $_SERVER["REQUEST_METHOD"];
if($method === "POST") {
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

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title><?php html($thread["name"]); ?></title>
</head>
<body>
<a href="/index.php">Top</a>
<h1><?php html($thread["name"]); ?></h1>
<?php foreach ($responses as $response) { ?>
  <?php html($response["content"]); ?><hr>
<?php } ?>
<form action="/response.php" method="POST">
  <input type="hidden" name="thread_id" value="<?php html($thread["id"]); ?>">
  <textarea name="content"></textarea>
  <input type="submit" value="投稿">
</form>
</body>
</html>
