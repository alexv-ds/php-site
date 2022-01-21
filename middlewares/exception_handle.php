<?php namespace middleware;
if (!$_ROUTER_PAGE) {
  throw new \Exception("Router include only");
}

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
  throw new \ErrorException($errstr, $errno, $errno, $errfile, $errline);
}, E_ALL);

$exception = null;
ob_start();
try {
  $_ROUTER_PAGE_NEXT($_ROUTER_PAGE_PATH, $_ROUTER_PAGE_ARGS);
} catch (\Exception $e) {
  $exception = $e;
}

if ($exception == null) {
  ob_end_flush();
  exit();
} else {
  ob_end_clean();
}

function print_exception(\Exception $e): void {
  echo "<b>Message:</b> ".$e->getMessage()."<br>";
  echo "<b>Code:</b> ".$e->getCode()."<br>";  
  echo "<b>File:</b> ".$e->getFile()."<br>";  
  echo "<b>Line:</b> ".$e->getLine()."<br>";
  echo "<h2>Stacktrace</h2>";
  foreach ($e->getTrace() as $trace_value) {
    echo "<hr>";
    echo "<b>File:</b> ".$trace_value["file"]."<br>";
    echo "<b>Line:</b> ".$trace_value["line"]."<br>";
    echo "<b>Function:</b> ".$trace_value["function"]."(";
    if (array_key_exists("args", $trace_value)) {
      echo implode(", ", $trace_value["args"]);
    }
    echo ")<br>";
  }
}

?>



<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Error occurred</title>
  </head>
  <body>
    <h2>Exception</h2>
    <hr>
    <?php namespace middleware; print_exception($exception)?>
  </body>
</html>