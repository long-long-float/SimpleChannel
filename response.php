<?php

require_once 'common.php';

session_start();

if(!is_loggedin()) {
  redirect_to("/index.php");
}

$db = new DatabaseWrapper();

$method = $_SERVER["REQUEST_METHOD"];
if($method === "POST") {
  #CSRF
  if($_POST["nonce"] !== md5($_SESSION["nonce"])) {
    set_error("許可されていない操作です");
    redirect_to("/index.php");
    return;
  }

  $tid = $_POST["thread_id"];
  $db->execute_sql("insert into responses (thread_id, content) values (?, ?)", array($tid, $_POST["content"]));
  redirect_to("/thread.php?id=$tid");
}

?>