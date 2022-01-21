<?php namespace page;
if (!$_ROUTER_PAGE) {
  throw new \Exception("Router include only");
}
if ($_ROUTER_PAGE_PATH != "/article/new") {
  $_ROUTER_PAGE_NEXT($_ROUTER_PAGE_PATH, $_ROUTER_PAGE_ARGS);
  exit();
}

if (!$_ROUTER_PAGE_ARGS["LOGIN"]) {
  header("Location: /login", true, 302);
  exit();
}

require_once(__DIR__."/../Template.php");

$navbar_template_result = \core\Template::execute(__DIR__."/../templates/navbar.php", [
  "new_article" => true
]);

$new_article_template_result = \core\Template::execute(__DIR__."/../templates/edit_article.php", []);

$page_base_args = [];
$page_base_args["title"] = "Новая статья";
$page_base_args["body"] = $navbar_template_result.$new_article_template_result;
$page_base_args["scripts"] = [
  ["src" => "/static/new_article.js"]
];
$page_base_args["styles"] = [
  ["href" => "/static/new_article.css"],
  ["href" => "//cdn.quilljs.com/1.3.6/quill.snow.css"],
];

echo \core\Template::execute(__DIR__."/../templates/page_base.php", $page_base_args);

?>