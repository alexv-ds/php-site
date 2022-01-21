<?php namespace template;

if (!$_TEMPLATE) {
  throw new \Exception("Template include only");
}

?>

<div class="container">
  <div class="row text-center">
    <div class="col-12"><h1>Мои статьи</h1></div>
  </div>
  <div class="row d-flex justify-content-center mt-100 mb-100">
    <div class="col-12">
      <table class="table table-hover">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Тема</th>
            <th scope="col">Область видимости</th>
            <th scope="col">Дата создания</th>
            <th scope="col">Действия</th>
          </tr>                    
        </thead>        
        <tbody>
          <?php $row_counter = 1?>
          <?php foreach($_TEMPLATE_ARGS as $article) {?>
            <tr>
              <th scope="row"><?php echo $row_counter++?></th>
              <td><?php echo $article["theme"]?></td>
              <td><?php echo $article["scope"]?></td>
              <td><?php echo $article["timestamp"]?></td>
              <td>
              <a href='/article/<?php echo $article["id"]."/".$article["url_theme"]?>' class="text-decoration-none">
                <button type="button" class="btn btn-outline-success">Открыть</button>
              </a>
              <a href='/article/edit/<?php echo $article["id"]."/".$article["url_theme"]?>' class="text-decoration-none">
                <button type="button" class="btn btn-outline-warning">Изменить</button>
              </a>
              <a href='/api/article_edit/delete/<?php echo $article["id"]?>' class="text-decoration-none">
                <button type="button" class="btn btn-outline-danger">Удалить</button>
              </a>
              </td>
            </tr>
          <?php }?>
        </tbody>
      </table>
    </div>
  </div>
</div>