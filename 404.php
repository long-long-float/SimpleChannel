<?php

function render404($msg) {

  header("HTTP/1.1 404");

?>

<!DOCTYPE html>
<html>
<head>
  <title>404 Not Found</title>
</head>
<body>
<a href="/index.php">Top</a>
<?php echo $msg ?>
</body>
</html>

<?php

}

?>