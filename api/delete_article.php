<?php namespace api;
if (!$_ROUTER_PAGE) {
  throw new \Exception("Router include only");
}

$regexp_match_result = [];
if (!preg_match("/api\/article_edit\/delete\/(\\d+)/", $_ROUTER_PAGE_PATH, $regexp_match_result)) {
  $_ROUTER_PAGE_NEXT($_ROUTER_PAGE_PATH, $_ROUTER_PAGE_ARGS);
  exit();
}

if (!$_ROUTER_PAGE_ARGS["LOGIN"]) {
  throw new \Exception("Must be logged in to delete article");
}

if ($_ROUTER_PAGE_ARGS["LOGIN"]['id'] != $_ROUTER_PAGE_ARGS["DB"]->get_article_author(intval($regexp_match_result[1]))) {
  throw new \Exception("Only the author of an article can delete it");
}

$_ROUTER_PAGE_ARGS["DB"]->delete_article(intval($regexp_match_result[1]));

header("Location: /article/my", true, 302);
?>