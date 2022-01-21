<?php namespace core;

class Template {
  public static function execute(string $script_path, array $args = []): string {
    if (!file_exists($script_path)) {
      throw new \Exception("Template $script_path not exits");
    }
    ob_start();
    try {
      $_TEMPLATE = true;
      $_TEMPLATE_ARGS = $args;
      include $script_path;
    } catch (\Exception $e) {
      ob_end_clean();
      throw $e; //rethrow;
    }
    return ob_get_clean();
  }
};

?>