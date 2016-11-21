<?php

namespace helionogueir\filecreator\output;

use helionogueir\languagepack\Lang;
use helionogueir\typeBoxing\type\String;

/**
 * Read file:
 * - Displays the file;
 *
 * @author Helio Nogueira <helio.nogueir@gmail.com>
 * @version v1.0.0
 */
class ReadFile {

  /**
   * Contruct the basic of class
   * @return null
   */
  public function __construct() {
    return null;
  }

  /**
   * Read file:
   * - Read file and print
   * 
   * @param helionogueir\typeBoxing\type\String $filename File name to be read
   * @return null
   */
  public function read(String $filename) {
    $auth = false;
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
      $auth = true;
    } else {
      header('HTTP/1.0 404 Not Found');
    }
    // Exception
    if (!$auth) {
      Lang::addRoot(new String(\helionogueir\filecreator\autoload\LanguagePack::PACKAGE), new String(\helionogueir\filecreator\autoload\LanguagePack::PATH));
      throw new Exception(Lang::get(new String('filecreator:upload:readfile:read'), new String('helionogueir/filecreator')));
    }
    return null;
  }

  /**
   * Rank the format of file:
   * - See the extention and rank the format to be displayed
   * 
   * @param String $name Name of file
   * @param String $extention Extention initials
   * @return null
   */
  private function putTypeRules(String $name, String $extention) {
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
