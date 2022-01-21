<?php namespace page;
if (!$_ROUTER_PAGE) {
  throw new \Exception("Router include only");
}
if ($_ROUTER_PAGE_PATH != "/login_old") {
  $_ROUTER_PAGE_NEXT($_ROUTER_PAGE_PATH, $_ROUTER_PAGE_ARGS);
  exit();
}

require_once(__DIR__."/../Cookie.php");
require_once(__DIR__."/../Database.php");

$db = $_ROUTER_PAGE_ARGS["DB"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  if (array_key_exists("username", $_POST) && array_key_exists("password", $_POST)) {
    $auth_data = $db->get_user_auth_data($_POST["username"]);
    if ($auth_data) {
      $password_hash = hash("sha256", $_POST["password"].$auth_data["salt"]);
      if ($password_hash == $auth_data["hash"]) {
        \core\Cookie::set_cookie("user_id", $auth_data["id"]);
      } else {
        throw new \Exception("Incorrect password");
      }
    } else {
      $db->add_user_auth_data($_POST["username"], hash("sha256", $_POST["username"]."123df321"), "123df321");
      $auth_data = $db->get_user_auth_data($_POST["username"]);
      \core\Cookie::set_cookie("user_id", $auth_data["id"]);
    }
    header("Location: /", true, 302);
  } else if (array_key_exists("logout", $_POST)) {
    \core\Cookie::delete_cookie("user_id");
    header("Location: /login_old", true, 302);
  }
  exit();
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login page</title>
  </head>
  <body>
    <?php namespace page;
      if ($_ROUTER_PAGE_ARGS["LOGIN"]) {
        echo "<h1>Current username: ".$_ROUTER_PAGE_ARGS["LOGIN"]["name"]."</h1>";
        echo '
          <form action="/login_old" method="post">
            <input type="text" name="logout">
            <input type="submit" value="logout">
          </form>
        ';
      } else {
        echo "<h1>НЕ ЗАЛОГИНЕНО</h1>";
        echo '
          <form action="/login_old" method="post">
            username: <input type="text" name="username"><br>
            password: <input type="password" name="password"><br>
            <input type="submit">
          </form>
        ';
      }
    ?>

  </body>
</html>