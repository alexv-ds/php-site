<?php namespace template;

/*
  Входящие аргументы
  title: string - название страницы
  body: string - тело страницы
  scripts: двумерный массив - дополнительные скрипты
  styles: двумерный массив - доп стили

  Пример доп скрипта
  $scripts = [
    ["src" => "https://...", "integrity" => "..."],
    ["src" => "..."]
  ];

  Пример доп стиля
  $styles = [
    ["href"="https://...", "integrity" => "..."]
  ];
*/


if (!$_TEMPLATE) {
  throw new \Exception("Template include only");
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title><?php echo $_TEMPLATE_ARGS["title"]?></title>
    <link rel='shortcut icon' type='image/x-icon' href='/static/favicon.ico'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="//cdn.quilljs.com/1.3.6/quill.bubble.css" rel="stylesheet">
    <?php 
      if (array_key_exists("styles", $_TEMPLATE_ARGS)) {
        foreach ($_TEMPLATE_ARGS["styles"] as $style_data) {
          $style_string = "<link rel=\"stylesheet\" ";
          foreach ($style_data as $key => $value) {
            $style_string = "$style_string $key=\"$value\" ";
          }
          $style_string = "$style_string>";
          echo $style_string;
        }
      }
    ?>
  </head>
  <body>
    <?php echo $_TEMPLATE_ARGS["body"]?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="//cdn.quilljs.com/1.3.6/quill.min.js"></script>
    <?php 
      if (array_key_exists("scripts", $_TEMPLATE_ARGS)) {
        foreach ($_TEMPLATE_ARGS["scripts"] as $script_data) {
          $script_string = "<script ";
          foreach ($script_data as $key => $value) {
            $script_string = "$script_string $key=\"$value\" ";
          }
          $script_string = "$script_string></script>";
          echo $script_string;
        }
      }
    ?>
  </body>
</html>


