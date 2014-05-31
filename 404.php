<?php

function render404($msg) {

  header("HTTP/1.1 404");

  require_once 'header.php'; render_header("404 Not Found");

  html($msg);

  require_once 'footer.php'; render_footer();

}

?>