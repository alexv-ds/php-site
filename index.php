<?php namespace core;

require_once("Router.php");

$router = new Router;

//Порядок вызову снизу вверх
$router->add_script(__DIR__."/pages/404.php");

$router->add_script(__DIR__."/api/register.php");
$router->add_script(__DIR__."/api/logout.php");
$router->add_script(__DIR__."/api/login.php");
$router->add_script(__DIR__."/api/delete_article.php");
$router->add_script(__DIR__."/api/edit_article.php");
$router->add_script(__DIR__."/api/new_article.php");

$router->add_script(__DIR__."/pages/edit_article.php");
$router->add_script(__DIR__."/pages/my_articles.php");
$router->add_script(__DIR__."/pages/article.php");
$router->add_script(__DIR__."/pages/new_article.php");

$router->add_script(__DIR__."/pages/login copy.php");
$router->add_script(__DIR__."/pages/login.php");
$router->add_script(__DIR__."/pages/phpinfo.php");
$router->add_script(__DIR__."/pages/index.php");
$router->add_script(__DIR__."/middlewares/login_check.php");
$router->add_script(__DIR__."/middlewares/db_init.php");
$router->add_script(__DIR__."/middlewares/exception_handle.php");

$router->route(parse_url($_SERVER["REQUEST_URI"])["path"], $_REQUEST);

?>