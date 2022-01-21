<?php namespace api;
if (!$_ROUTER_PAGE) {
  throw new \Exception("Router include only");
}
if ($_ROUTER_PAGE_PATH != "/api/article_edit/new" || $_SERVER["REQUEST_METHOD"] != "POST") {
  $_ROUTER_PAGE_NEXT($_ROUTER_PAGE_PATH, $_ROUTER_PAGE_ARGS);
  exit();
}

if (!$_ROUTER_PAGE_ARGS["LOGIN"]) {
  throw new \Exception("Must be logged in to create a page");
}

$data = json_decode($_POST["data"], true);

if ($data["scope"] != "all" && $data["scope"] != "registered" && $data["scope"] != "author") {
  throw new \Exception("Invalid scope");
}

if (!$data["theme"]) {
  throw new \Exception("Invalid theme");
}

$theme = $data["theme"];
$theme = str_replace(["&","$", "+", ",", "/", ":", ";", "=", "?", "@", "#", "<", ">", "[", "]", "{", "}", "|", "\\", "^", "%"], "",$theme);

$url_theme = rawurlencode($theme);
$theme_id = $_ROUTER_PAGE_ARGS['DB']->add_atricle(
  $_ROUTER_PAGE_ARGS["LOGIN"]["id"], $theme, $url_theme, $data["scope"], $data["content"]
);

//header("Location: /article/$theme_id/$url_theme", true, 302);

?>