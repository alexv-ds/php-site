<?php namespace core;

class Router {
  private $current_fn = null;

  public function add(Callable $middleware): void {
    if ($this->current_fn == null) {
      $this->current_fn = function(string $path, array $args) use ($middleware) {
        $middleware($path, $args, function(string $path, array $args) {/*empty function*/});
      }; 
    } else {
      $next_fn = $this->current_fn;
      $this->current_fn = function(string $path, array $args) use ($next_fn, $middleware) {
        $middleware($path, $args, $next_fn);
      };
    }
  }

  public function add_script(string $script_path): void {
    $this->add(function (string $path, array $args, Callable $next_fn) use ($script_path) {
      if (!file_exists($script_path)) {
        throw new \Exception("Page file '".$script_path." not exists");
      }
      $_ROUTER_PAGE_PATH = $path;
      $_ROUTER_PAGE_ARGS = $args;
      $_ROUTER_PAGE_NEXT = $next_fn;
      $_ROUTER_PAGE = true;
      include $script_path;
    });
  }

  public function route(string $path, array $args): void {
    if (!$this->current_fn) {
      return;
    }
    $middleware = $this->current_fn;
    $middleware($path, $args);
  }
}


?>