<?php namespace api;
if (!$_ROUTER_PAGE) {
  throw new \Exception("Router include only");
}

$regexp_match_result = [];
if (!preg_match("/api\/article_edit\/edit\/(\\d+)/", $_ROUTER_PAGE_PATH, $regexp_match_result)) {
  $_ROUTER_PAGE_NEXT($_ROUTER_PAGE_PATH, $_ROUTER_PAGE_ARGS);
  exit();
}

if (!$_ROUTER_PAGE_ARGS["LOGIN"]) {
  throw new \Exception("Must be logged in to delete article");
}

if ($_ROUTER_PAGE_ARGS["LOGIN"]['id'] != $_ROUTER_PAGE_ARGS["DB"]->get_article_author(intval($regexp_match_result[1]))) {
  throw new \Exception("Only the author of an article can delete it");
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

$_ROUTER_PAGE_ARGS["DB"]->update_article(intval($regexp_match_result[1]), $theme, $url_theme, $data["scope"], $data["content"]);

$article_id = $regexp_match_result[1];
header("Location: /article/$article_id/$url_theme", true, 302);
?>