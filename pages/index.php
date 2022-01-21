<?php namespace page;
if (!$_ROUTER_PAGE) {
  throw new \Exception("Router include only");
}
if ($_ROUTER_PAGE_PATH != "/") {
  $_ROUTER_PAGE_NEXT($_ROUTER_PAGE_PATH, $_ROUTER_PAGE_ARGS);
  exit();
}

require_once(__DIR__."/../Template.php");

$navbar_template_result = \core\Template::execute(__DIR__."/../templates/navbar.php", ["main" => true]);

$articles = [];
foreach($_ROUTER_PAGE_ARGS["DB"]->get_articles() as $article) {
  if ($article["scope"] == "all") {
    array_push($articles, $article);
  }
  if ($article["scope"] == "registered" && $_ROUTER_PAGE_ARGS["LOGIN"]) {
    array_push($articles, $article);
  }
  if ($article["scope"] == "author" && $_ROUTER_PAGE_ARGS["LOGIN"] && $_ROUTER_PAGE_ARGS["LOGIN"]["id"] == $article["author_id"]) {
    array_push($articles, $article);
  }
}
foreach($articles as &$article) {
  $author = $_ROUTER_PAGE_ARGS["DB"]->get_username($article["author_id"]);
  $article["author_name"] = $author ? $author : "[deleted user]";
}
$index_template_result = \core\Template::execute(__DIR__."/../templates/index.php", $articles);

echo \core\Template::execute(__DIR__."/../templates/page_base.php", [
  "title" => "Список статей",
  "body" => $navbar_template_result.$index_template_result,
  "styles" => [
    ["href" => "/static/index.css"]
  ]
]);

?>