<?php

namespace helionogueir\filecreator\output;

use helionogueir\typeBoxing\type\String;

/**
 * Read file:
 * - Check if file exists;
 * - Flush the file;
 *
 * @author Helio Nogueira <helio.nogueir@gmail.com>
 * @version v1.0.0
 */
class ReadFile {

  public function __construct() {
    return false;
  }

  /**
   * Make file:
   * - Make the file;
   * 
   * @param helionogueir\typeBoxing\type\String $filename Filename
   * @return null Without return
   */
  public final function make(String $filename) {
    if (!$filename->isEmpty() && file_exists($filename) && is_file($filename)) {
      $pattern = "/^(.*)(\/|\\\\)(.*)\.(.*)$/i";
      $name = new String(preg_replace($pattern, '$3', $filename));
      $extention = new String(preg_replace($pattern, '$4', $filename));
      header('Content-Transfer-Encoding: binary');
      header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime("{$filename}")) . ' GMT');
      header('Accept-Ranges: bytes');
      header('Content-Length: ' . filesize("{$filename}"));
      header('Content-Encoding: none');
      header('Content-Type: ' . mime_content_type("{$filename}"));
      $this->putTypeRules($name, $extention);
      ob_clean();
      flush();
      readfile($filename);
    }
    return null;
  }

  /**
   * File rules:
   * - Put rules;
   * 
   * @param string $name Name of file
   * @param string $extention Extention of filename
   * @return null Without return
   */
  private final function putTypeRules(String $name, String $extention) {
    switch ($extention) {
      case 'ods':
      case 'odt':
      case 'txt':
        header("Content-Type: application/{$extention}");
        header("Content-Disposition: attachment; filename='{$name}'");
        break;
      case 'pdf':
        header("Content-Type: application/{$extention}");
        break;
      case 'js':
        header("Content-Type: text/javascript");
        break;
      default :
        header("Content-Type: text/{$extention}");
        break;
    }
    return null;
  }

}
