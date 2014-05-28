<?php

require_once 'common.php';

session_start();

unset($_SESSION["user_id"]);

redirect_to("/index.php");

?>