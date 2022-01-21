<?php namespace template;

/*
  

*/

if (!$_TEMPLATE) {
  throw new \Exception("Template include only");
}

?>

<script>
  document.addEventListener("DOMContentLoaded", function(event) {
    const data = <?php echo $_TEMPLATE_ARGS["content"] ?>;
    const quill = new Quill('#article-content');
    quill.setContents(data);
    quill.enable(false);
  });
</script>

<div class="container">

  <div class="row text-center">
      <div class="col-12"><h1><?php echo $_TEMPLATE_ARGS["theme"]?></h1></div>
  </div>
  <div class="row">
    <div id="article-content" class="col-12 border-bottom"></div>
  </div>
  <div class="row">
    <div class="col-6 text-center"><b>Автор:</b> <?php echo $_TEMPLATE_ARGS["article_author_name"]?></div>
    <div class="col-6 text-center"><b>Дата публикации:</b> <?php echo $_TEMPLATE_ARGS["timestamp"]?></div>
  </div>

</div>


