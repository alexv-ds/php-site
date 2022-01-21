<?php namespace page;
if (!$_ROUTER_PAGE) {
  throw new \Exception("Router include only");
}

$regexp_match_result = [];

if (!preg_match("/article\/(\\d+?)\/(.+)/", $_ROUTER_PAGE_PATH, $regexp_match_result)) {
  $_ROUTER_PAGE_NEXT($_ROUTER_PAGE_PATH, $_ROUTER_PAGE_ARGS);
  exit();
}
$article_id = intval($regexp_match_result[1]);
$article_data = $_ROUTER_PAGE_ARGS["DB"]->get_article($article_id);

if (!$article_data) {
  $_ROUTER_PAGE_NEXT($_ROUTER_PAGE_PATH, $_ROUTER_PAGE_ARGS);
  exit();
}

if ($article_data["url_theme"] != $regexp_match_result[2]) {
  $url_theme = $article_data["url_theme"];
  header("Location: /article/$article_id/$url_theme", true, 301);
  exit();
}

require_once(__DIR__."/../Template.php");

$template_args = [];
$template_args["title"] = $article_data["theme"];
$template_args["body"] = \core\Template::execute(__DIR__."/../templates/navbar.php");

$article_author_name = $_ROUTER_PAGE_ARGS["DB"]->get_username($article_data["author_id"]);
$article_data["article_author_name"] = $article_author_name ? $article_author_name : "[deleted user]";
if ($article_data["scope"] == "registered") {
  if ($_ROUTER_PAGE_ARGS["LOGIN"]) {
    $template_args["body"] = $template_args["body"].\core\Template::execute(__DIR__."/../templates/article.php", $article_data);
  } else {
    $template_args["body"] = \core\Template::execute(__DIR__."/../templates/message_page.php", [
      "message" => "Cтатья доступна только зарегестрированным пользователям"
    ]);
  }

} else if ($article_data["scope"] == "author") {
  if ($_ROUTER_PAGE_ARGS["LOGIN"] && $_ROUTER_PAGE_ARGS["LOGIN"]["id"] == $article_data["author_id"]) {
    $template_args["body"] = $template_args["body"].\core\Template::execute(__DIR__."/../templates/article.php", $article_data);
  } else {
    $template_args["body"] = \core\Template::execute(__DIR__."/../templates/message_page.php", [
      "message" => "Автор закрыл доступ к публикации"
    ]);
  }
} else {
  $template_args["body"] = $template_args["body"].\core\Template::execute(__DIR__."/../templates/article.php", $article_data);
}

echo \core\Template::execute(__DIR__."/../templates/page_base.php", $template_args);

?>


