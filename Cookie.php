<?php namespace core;

class Cookie {

  public static function set_cookie(string $name, string $value): void {
    assert(strlen($name) > 0);
    $cookie_sign = Cookie::hash_cookie($name, $value);
    $_COOKIE[$name] = $value;
    $_COOKIE[$name."_sign"] = $cookie_sign;
    setcookie($name, $value, ["path" => "/"]);
    setcookie($name."_sign", $cookie_sign, ["path" => "/"]);
  }

  public static function get_cookie(string $name): ?string {
    if (!isset($_COOKIE[$name]) || !isset($_COOKIE[$name."_sign"])) {
      return null;
    }
    $value = $_COOKIE[$name];
    $sign = $_COOKIE[$name."_sign"];
    if (!hash_equals($sign, Cookie::hash_cookie($name, $value))) {
      return null;
    }
    return $value;
  }

  public static function delete_cookie(string $name): void {
    if (isset($_COOKIE[$name])) {
      unset($_COOKIE[$name]); 
      setcookie($name, "", ["path" => "/"]);
    }
    if (isset($_COOKIE[$name."_sign"])) {
      unset($_COOKIE[$name."_sign"]); 
      setcookie($name."_sign", "", ["path" => "/"]);
    }
  }

  private static function hash_cookie(string $name, string $value): string {
    return hash("sha256", $name.$value.Config::$cookie_sign_secret);
  }

};



?>