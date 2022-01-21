<?php namespace template;

if (!$_TEMPLATE) {
  throw new \Exception("Template include only");
}

?>

<div class="container">

  <div class="row text-center">
    <div class="col-12"><h1>Список статей</h1></div>
  </div>

<div class="row d-flex justify-content-center mt-100 mb-100">

  <?php foreach($_TEMPLATE_ARGS as $article) {?>
    <div class="card m-1 onhover-border-change" style="width: 18rem;">
      <a href='/article/<?php echo $article["id"]."/".$article["url_theme"]?>' class="text-decoration-none">
        <div class="card-body">
          <table class="table">
            <tbody>
              <tr>
                <th>Тема: </th>
                <td><?php echo $article["theme"]?></td>
              </tr>
              <tr>
                <th>Автор: </th>
                <td><?php echo $article["author_name"]?></td>
              </tr>
              <tr>
                <td colspan="2" class="border-bottom-0 text-center"><?php echo $article["timestamp"]?></td>
              </tr>   
            </tbody>
          </table>
        </div>
      </a>
    </div>
  <?php }?>

</div>


</div>