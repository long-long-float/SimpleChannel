<?php
require_once 'header.php'; render_header("確認");
$url = $_GET["url"];
?>

<?php html($url); ?> にジャンプしますがよろしいですか?

<a href="<?php html($url); ?>"><?php html($url); ?></a>

<?php require_once 'footer.php'; render_footer(); ?>