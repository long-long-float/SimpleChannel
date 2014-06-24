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

function current_user($db) {
  if(is_loggedin()) {
    $sql = "select id, name, point from users where id = ?";
    return $db->execute_sql($sql, array($_SESSION["user_id"]))[0];
  }
  return null;
}

function for_only($type) {
  if(!is_loggedin()) {
    set_error("ログインしてください");
    $redirect = ($_SERVER["REQUEST_URI"]);
    redirect_to("/login.php?redirect=$redirect");
    return true;
  }
  return false;
}

function redirect_to($uri) {
  header("Location: $uri");
}

function html($str) {
  #XSS
  echo $str;
  #echo htmlspecialchars($str, ENT_QUOTES, "UTF-8");
}

function create_nonce() {

$nonce = session_id();
$_SESSION["nonce"] = $nonce;

?>

<input type="hidden" name="nonce" value="<?php echo md5($nonce); ?>">

<?php

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

session_save_path("./sessions");

session_start();

?>