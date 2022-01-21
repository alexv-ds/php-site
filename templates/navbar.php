<?php namespace template;
/*
  Какие кнопки активны, могут отсутствовать ключи
  main: bool
  articles: bool
  auth: bool
  new_article: bool

*/

if (!$_TEMPLATE) {
  throw new \Exception("Template include only");
}

$username = null;
if (array_key_exists("username", $_TEMPLATE_ARGS)) {
  $username = $_TEMPLATE_ARGS["username"];
} else {
  $username = "Login";
}

function draw_button(string $href, string $content, bool $active): void {
  $active_addiction = $active ? "border rounded" : "";
  echo "<li class=\"nav-item $active_addiction\">";
  echo "<a class=\"nav-link\" href=\"$href\">$content</a>";
  echo "</li>";
}

if (!array_key_exists("main", $_TEMPLATE_ARGS)) {
  $_TEMPLATE_ARGS["main"] = false;
}
if (!array_key_exists("articles", $_TEMPLATE_ARGS)) {
  $_TEMPLATE_ARGS["articles"] = false;
}
if (!array_key_exists("auth", $_TEMPLATE_ARGS)) {
  $_TEMPLATE_ARGS["auth"] = false;
}
if (!array_key_exists("new_article", $_TEMPLATE_ARGS)) {
  $_TEMPLATE_ARGS["new_article"] = false;
}

?>

<nav class="navbar navbar-expand navbar-dark bg-dark">
  <div class="container-fluid">
    <ul class="navbar-nav">
      <?php draw_button("/", "На главную", $_TEMPLATE_ARGS["main"])?>
      <?php draw_button("/article/my", "Мои статьи", $_TEMPLATE_ARGS["articles"])?>
      <?php draw_button("/login", "Авторизация", $_TEMPLATE_ARGS["auth"])?>
      <?php draw_button("/article/new", "Новая статья", $_TEMPLATE_ARGS["new_article"])?>
    </ul>
  </div>
</nav>