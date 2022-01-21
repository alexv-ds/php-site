<?php namespace page;
if (!$_ROUTER_PAGE) {
  throw new \Exception("Router include only");
}
header("HTTP/1.0 404 Not Found");

if (!$_ROUTER_PAGE) {
  throw new \Exception("Router include only");
}

require_once(__DIR__."/../Template.php");

$message_page_template_result = \core\Template::execute(__DIR__."/../templates/message_page.php", [
  "message" => "404 - Not Found :("
]);
echo \core\Template::execute(__DIR__."/../templates/page_base.php", [
  "title" => "Not Found",
  "body" => $message_page_template_result
]);
?>
