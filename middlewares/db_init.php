<?php namespace middleware;
if (!$_ROUTER_PAGE) {
  throw new \Exception("Router include only");
}

require_once(__DIR__."/../Database.php");
require_once(__DIR__."/../Config.php");

$_ROUTER_PAGE_ARGS["DB"] = new \core\Database(\core\Config::$db_host,\core\Config::$db_user,\core\Config::$db_password);

$db = $_ROUTER_PAGE_ARGS["DB"];

$_ROUTER_PAGE_NEXT($_ROUTER_PAGE_PATH, $_ROUTER_PAGE_ARGS);

?>