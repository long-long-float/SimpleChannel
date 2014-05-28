<?php

class DatabaseWrapper {
  private $dbh;

  function __construct() {
    $this->dbh = new PDO("sqlite:database.db");
  }

  public function execute_sql($sql, $params = array()) {
    $stmt = $this->dbh->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
  }

  public function find_by($key, $value, $table, $columns) {
    return $this->execute_sql("select ".implode(", ", $columns)." from $table where $key = ?", array($value));
  }
}

function is_loggedin() {
  return isset($_SESSION["user_id"]);
}

function redirect_to($uri) {
  header("Location: $uri");
}

function html($str) {
  #XSS
  echo $str;
  #echo htmlspecialchars($str);
}

function check_for_csrf() {
  #CSRF
  if($_POST["nonce"] !== md5($_SESSION["nonce"])) {
    set_error("許可されていない操作です");
    redirect_to("/index.php");
    return true;
  }
  return false;
}

function set_error($err) {
  $_SESSION["error"] = $err;
}

function get_error() {
  if(!isset($_SESSION["error"])) {
    return "";
  } else {
    $err = $_SESSION["error"];
    unset($_SESSION["error"]);
    return $err;
  }
}

?>