<?php namespace page;
if (!$_ROUTER_PAGE) {
  throw new \Exception("Router include only");
}
if ($_ROUTER_PAGE_PATH != "/article/my") {
  $_ROUTER_PAGE_NEXT($_ROUTER_PAGE_PATH, $_ROUTER_PAGE_ARGS);
  exit();
}

if (!$_ROUTER_PAGE_ARGS["LOGIN"]) {
  header("Location: /login", true, 302);
  exit();
}

require_once(__DIR__."/../Template.php");

$navbar_template_result = \core\Template::execute(__DIR__."/../templates/navbar.php", ["articles" => true]);

$my_articles_template_result = \core\Template::execute(
  __DIR__."/../templates/my_articles.php",
  $_ROUTER_PAGE_ARGS["DB"]->get_user_articles($_ROUTER_PAGE_ARGS["LOGIN"]["id"])
);

echo \core\Template::execute(__DIR__."/../templates/page_base.php", [
  "title" => "Мои статьи",
  "body" => $navbar_template_result.$my_articles_template_result
]);

?>

