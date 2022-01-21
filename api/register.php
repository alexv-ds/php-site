<?php namespace api;

if ($_ROUTER_PAGE_PATH != "/api/register" || $_SERVER["REQUEST_METHOD"] != "POST") {
  $_ROUTER_PAGE_NEXT($_ROUTER_PAGE_PATH, $_ROUTER_PAGE_ARGS);
  exit();
}

if ($_ROUTER_PAGE_ARGS["LOGIN"]) {
  throw new \Exception("Already logged in");
}

require_once(__DIR__."/../Cookie.php");
require_once(__DIR__."/../Template.php");

$db = $_ROUTER_PAGE_ARGS["DB"];

if (!array_key_exists("username", $_POST) || strlen($_POST["username"]) == 0) {
  show_and_exit("Некорректное имя пользователя");
}

if (!array_key_exists("password", $_POST) || strlen($_POST["password"]) == 0) {
  show_and_exit("Некорректный пароль");
}

$auth_data = $db->get_user_auth_data($_POST["username"]);

if ($auth_data) {
  show_and_exit("Невозможно зарегестрироваться. Пользователь с таким именем уже существует.");
}

$db->add_user_auth_data($_POST["username"], hash("sha256", $_POST["username"]."123df321"), "123df321");
$auth_data = $db->get_user_auth_data($_POST["username"]);
\core\Cookie::set_cookie("user_id", $auth_data["id"]);

header("Location: /", true, 302);
?>