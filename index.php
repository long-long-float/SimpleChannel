<?php
require_once 'header.php'; render_header("Simple Channel");

$db = new DatabaseWrapper();
$threads = $db->execute_sql("select id, name from threads");

?>

<ul>
  <?php foreach ($threads as $thread) { ?>
    <li><a href="/thread.php?id=<?php html($thread["id"]); ?>"><?php html($thread["name"]); ?></a></li>
  <?php } ?>
</ul>
<h4>スレをたてる</h4>
<form action="/thread.php" method="POST">
  <?php create_nonce() ?>
  <input type="text" name="name">
  <input type="submit" value="つくる">
</form>

<?php require_once 'footer.php'; render_footer(); ?>