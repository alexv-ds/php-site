<?php namespace middleware;

//$_ROUTER_PAGE_ARGS["LOGIN"]["id"] - ид юзера
//$_ROUTER_PAGE_ARGS["LOGIN"]["name"] - name юзера
//$_ROUTER_PAGE_ARGS["LOGIN"] - может быть null, если не залогигег

if (!$_ROUTER_PAGE) {
  throw new \Exception("Router include only");
}

require_once(__DIR__."/../Cookie.php");

$str_id = \core\Cookie::get_cookie("user_id");

if ($str_id) {
  $id = intval($str_id);
  $_ROUTER_PAGE_ARGS["LOGIN"] = [
    "id" => intval($str_id),
    "name" => $_ROUTER_PAGE_ARGS["DB"]->get_username($id)
  ];
} else {
  $_ROUTER_PAGE_ARGS["LOGIN"] = null;
}
$_ROUTER_PAGE_NEXT($_ROUTER_PAGE_PATH, $_ROUTER_PAGE_ARGS);

?>