<?php namespace api;

if ($_ROUTER_PAGE_PATH != "/api/login" || $_SERVER["REQUEST_METHOD"] != "POST") {
  $_ROUTER_PAGE_NEXT($_ROUTER_PAGE_PATH, $_ROUTER_PAGE_ARGS);
  exit();
}

if ($_ROUTER_PAGE_ARGS["LOGIN"]) {
  throw new \Exception("Already logged in");
}

require_once(__DIR__."/../Cookie.php");
require_once(__DIR__."/../Template.php");

$db = $_ROUTER_PAGE_ARGS["DB"];
 
function show_and_exit($msg) {
  echo \core\Template::execute(__DIR__."/../templates/page_base.php", [
    "title" => "Ошибка авторизации",
    "body" => \core\Template::execute(__DIR__."/../templates/message_page.php", [
      "message" => $msg
    ])
  ]);
  exit();
}

if (!array_key_exists("username", $_POST) || strlen($_POST["username"]) == 0) {
  show_and_exit("Некорректное имя пользователя");
}

if (!array_key_exists("password", $_POST) || strlen($_POST["password"]) == 0) {
  show_and_exit("Некорректный пароль");
}

$auth_data = $db->get_user_auth_data($_POST["username"]);

if (!$auth_data) {
  show_and_exit("Пользователя не сущетвует");
}

$password_hash = hash("sha256", $_POST["password"].$auth_data["salt"]);
if ($password_hash == $auth_data["hash"]) {
  \core\Cookie::set_cookie("user_id", $auth_data["id"]);
} else {
  show_and_exit("Неправильный пароль");
}

header("Location: /", true, 302);







?>