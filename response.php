<?php

require_once 'common.php';

session_start();

for_only("users");

$db = new DatabaseWrapper();

$method = $_SERVER["REQUEST_METHOD"];
if($method === "POST") {
  if(check_for_csrf()) return;

  $tid = $_POST["thread_id"];
  $content = $_POST["content"];
  if(mb_strlen($content, "UTF-8") > 1024) {
    set_error("本文が長すぎます!");
    redirect_to("/thread.php?id=$tid");
    return;
  }
  $db->execute_sql("insert into responses (thread_id, content) values (?, ?)", array($tid, $content));
  redirect_to("/thread.php?id=$tid");
}

?>