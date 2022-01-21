<?php namespace template;

/*
  id: ?int - (id статьи) если null, то создается новая статья, иначе - редактирование существующей
  //следующие ключи существуют, существует id
  $theme: string - тема статьи
  $url_theme: string - тема в url виде
  $content: string - json данные для редактора
  $scope: string - область видимости статьи
*/

if (!$_TEMPLATE) {
  throw new \Exception("Template include only");
}

if (!key_exists("id", $_TEMPLATE_ARGS)) {
  $_TEMPLATE_ARGS["id"] = null;
}

$theme_input_additional_artibute = "";
if ($_TEMPLATE_ARGS["id"]) {
  $theme = $_TEMPLATE_ARGS["theme"];
  $theme_input_additional_artibute = "value=\"$theme\"";
}

function check_selected_atribute($article_scope, $option_scope) {
  if ($article_scope == $option_scope) {
    return "selected";
  } else {
    return "";
  }
}

$scope_all_addition = $_TEMPLATE_ARGS["id"] ? check_selected_atribute($_TEMPLATE_ARGS["scope"], "all") : "";
$scope_registered_addition = $_TEMPLATE_ARGS["id"] ? check_selected_atribute($_TEMPLATE_ARGS["scope"], "registered") : "";
$scope_author_addition = $_TEMPLATE_ARGS["id"] ? check_selected_atribute($_TEMPLATE_ARGS["scope"], "author") : "";

?>

<?php if ($_TEMPLATE_ARGS["id"]) { ?>
  <script>
    document.addEventListener("DOMContentLoaded", function(event) {
      const data = <?php echo $_TEMPLATE_ARGS["content"] ?>;
      quill.setContents(data);
    });
  </script>
<?php } ?>

<div class="container">
  <div class="row text-center">
    <div class="col-12">
      <?php 
        if ($_TEMPLATE_ARGS["id"]) {
          echo "<h1>Изменить статью</h1>";
        } else {
          echo "<h1>Новая статья</h1>";
        }
      ?>
    </div>
  </div>
  <div class="row">
    <div class="col-12 p-0">
      <form>
        <input id="theme"
               class="form-control form-control-lg rounded-0 text-center btn-outline-warn no-focus-shadow border-bottom-0"
               type="text" 
               placeholder="Тема"
               <?php echo $theme_input_additional_artibute;?>
               onkeydown="return event.key != 'Enter';">
      </form>
    </div>
  </div>
  <div class="row">
    <div class="col-12 form-control" id="text-editor" style="height: 600px;"></div>
  </div>
  <div>
  <form>
    <div class="form-group row m-1">
      <label for="scope-select" class="col-2 col-form-label p-0">Область видимости</label>
      <div class="col-4">
        <select class="form-control no-focus-shadow rounded-0 p-0" id="scope-select">
          <option id="all" <?php echo $scope_all_addition?>>Всем</option>
          <option id="registered" <?php echo $scope_registered_addition?>>Зарегестрированным</option>
          <option id="author" <?php echo $scope_author_addition?>>Только мне</option>
        </select>
      </div>
    </div>
  </form>
  <div class="row">
    <button type="button" class="btn btn-success rounded-0" onclick="submit_button(<?php echo $_TEMPLATE_ARGS["id"] ?>)">Сохранить</button>
  </div>
</div>





