<?php namespace template;

if (!$_TEMPLATE) {
  throw new \Exception("Template include only");
}

?>

<div class="container text-center">
  <main class="form-signin">
    <form action="/api/login" method="post">
      <h1 class="h2 mb-4 fw-normal">Вход</h1>
      <div class="form-floating">
        <input type="login" class="form-control" id="floatingInput" placeholder="login" name="username" size="20" maxlength="60"><label for="floatingInput">Логин:</label></input>
      </div>
      <div class="form-floating">
        <input type="password" class="form-control" id="floatingPassword" placeholder="Пароль" name="password" size="20" maxlength="60"><label for="floatingPassword">Пароль:</label></input>
      </div>
      <p><input type="submit" name="submit" value="Войти" class="w-100 btn btn-lg btn-success" ></input></p>
    </form>
  </main>
  <hr>
  <main class="form-signin">
    <form action="/api/register" method="post">
      <h1 class="h2 mb-4 fw-normal">Регистрация</h1>
      <div class="form-floating">
      <input type="login" class="form-control" id="floatingInput" placeholder="login" name="username" size="20" maxlength="60"><label for="floatingInput">Логин:</label>
      </div>
      
      <div class="form-floating">
      <input type="password" class="form-control" id="floatingPassword" placeholder="Пароль" name="password" size="20" maxlength="60"><label for="floatingPassword">Пароль:</label>
      </div>
      <p><input type="submit" name="submit" value="Зарегестрироваться" class="w-100 btn btn-lg btn-warning"></input></p>
    </form>
  </main>

</div>

