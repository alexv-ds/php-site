<?php namespace api;

if ($_ROUTER_PAGE_PATH != "/api/logout") {
  $_ROUTER_PAGE_NEXT($_ROUTER_PAGE_PATH, $_ROUTER_PAGE_ARGS);
  exit();
}

require_once(__DIR__."/../Cookie.php");

\core\Cookie::delete_cookie("user_id");
header("Location: /login", true, 302);

?>