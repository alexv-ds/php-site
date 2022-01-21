<?php namespace template;
/*
  message: string - что выводится на странице
*/

if (!$_TEMPLATE) {
  throw new \Exception("Template include only");
}
?>

<div class="container">
  <div class="row justify-content-center align-items-center" style="height:100vh">
    <div class="col-12 text-center">
      <h1 class="display-3"><?php echo $_TEMPLATE_ARGS["message"]?></h1>
    </div>
  </div>
</div>