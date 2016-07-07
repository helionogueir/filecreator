<?php

spl_autoload_register(function($classname) {
  $pattern = "/^(helionogueir\\\\filecreator)\\\\(.*)$/";
  if (preg_match($pattern, $classname)) {
    $classname = preg_replace($pattern, '$2', $classname);
    $filename = dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . preg_replace("/(\/|\\\\)/", DIRECTORY_SEPARATOR, $classname) . '.class.php';
    if (file_exists($filename)) {
      require_once($filename);
    }
  }
});
