<?php namespace page;
if (!$_ROUTER_PAGE) {
  throw new \Exception("Router include only");
}

$regexp_match_result = [];

if (!preg_match("/article\/edit\/(\\d+?)\/(.+)/", $_ROUTER_PAGE_PATH, $regexp_match_result)) {
  $_ROUTER_PAGE_NEXT($_ROUTER_PAGE_PATH, $_ROUTER_PAGE_ARGS);
  exit();
}

if (!$_ROUTER_PAGE_ARGS["LOGIN"]) {
  throw new \Exception("Registered users only");
}

$article_id = intval($regexp_match_result[1]);
$article_data = $_ROUTER_PAGE_ARGS["DB"]->get_article($article_id);
$article_data["id"] = $article_id;

if (!$article_data) {
  $_ROUTER_PAGE_NEXT($_ROUTER_PAGE_PATH, $_ROUTER_PAGE_ARGS);
  exit();
}

if ($article_data["url_theme"] != $regexp_match_result[2]) {
  $url_theme = $article_data["url_theme"];
  header("Location: /article/edit/$article_id/$url_theme", true, 301);
  exit();
}

if ($_ROUTER_PAGE_ARGS["LOGIN"]['id'] != $article_data["author_id"]) {
  throw new \Exception("Only the author of an article can edit it");
}

require_once(__DIR__."/../Template.php");

$navbar_temlate_result = \core\Template::execute(__DIR__."/../templates/navbar.php");
$edit_article_temlpate_result = \core\Template::execute(__DIR__."/../templates/edit_article.php", $article_data);

echo \core\Template::execute(__DIR__."/../templates/page_base.php", [
  "title" => "Изменить статью",
  "body" => $navbar_temlate_result.$edit_article_temlpate_result,
  "scripts" => [
    ["src" => "/static/new_article.js"]
  ],
  "styles" => [
    ["href" => "/static/new_article.css"],
    ["href" => "//cdn.quilljs.com/1.3.6/quill.snow.css"]
  ]
]);

?>
