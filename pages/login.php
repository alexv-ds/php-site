<?php namespace page;
if (!$_ROUTER_PAGE) {
  throw new \Exception("Router include only");
}
if ($_ROUTER_PAGE_PATH != "/login") {
  $_ROUTER_PAGE_NEXT($_ROUTER_PAGE_PATH, $_ROUTER_PAGE_ARGS);
  exit();
}

require_once(__DIR__."/../Cookie.php");
require_once(__DIR__."/../Template.php");


$navbar_template_result = \core\Template::execute(__DIR__."/../templates/navbar.php", [
  "auth" => true
]);
$login_template_result = \core\Template::execute(__DIR__."/../templates/login.php");

//<a class="btn btn-primary" href="#" role="button">Link</a>
if ($_ROUTER_PAGE_ARGS["LOGIN"]) {
  echo \core\Template::execute(__DIR__."/../templates/page_base.php", [
    "title" => "Авторизация",
    "body" =>  \core\Template::execute(__DIR__."/../templates/message_page.php", [
      "message" => "<a class=\"btn btn-primary\" href=\"/api/logout\" role=\"button\">Выйти</a>"
    ])
  ]);

} else {
  echo \core\Template::execute(__DIR__."/../templates/page_base.php", [
    "title" => "Авторизация",
    "body" => $navbar_template_result.$login_template_result
  ]);
}


?>