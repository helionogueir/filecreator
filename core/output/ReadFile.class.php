<?php

namespace helionogueir\filecreator\output;

use Exception;
use helionogueir\languagepack\Lang;
use helionogueir\filecreator\autoload\Environment;

/**
 * - Read file by pathname
 * @author Helio Nogueira <helio.nogueir@gmail.com>
 * @version v1.1.0
 */
class ReadFile {

  private $pattern = "/^(.*)(\/|\\\\)(.*)\.(.*)$/i";

  /**
   * - Get text and replace tagname(s)
   * @param string $pathname Pathname by file to be read
   * @param bool $isText Define if file to be read as text file
   * @param bool $forceDownload Force download info
   * @return null
   */
  public function read(string $pathname, bool $isText, bool $forceDownload = false) {
    $auth = false;
    if (!empty($pathname) && file_exists($pathname) && is_file($pathname)) {
      $filename = preg_replace($this->pattern, '$3', $pathname);
      $extention = preg_replace($this->pattern, '$4', $pathname);
      $this->setHeader($pathname, $filename, $extention, $isText, $forceDownload);
      ob_clean();
      flush();
      readfile($pathname);
      $auth = true;
    }
    if (!$auth) {
      Lang::addRoot(Environment::PACKAGE, Environment::PATH);
      throw new Exception(Lang::get('filecreator:upload:readfile:read', 'helionogueir/filecreator', Array("pathname" => $pathname)));
    }
    return null;
  }

  /**
   * - Set header file
   * @param string $pathname Pathname by file to be read
   * @param string $filename Only filename
   * @param string $extention File extention
   * @param bool $isText Define if file to be read as text file
   * @param bool $forceDownload Force download info
   * @return null
   */
  private function setHeader(string $pathname, string $filename, string $extention, bool $isText, bool $forceDownload) {
    header('Content-Transfer-Encoding: binary');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($pathname)) . ' GMT');
    header('Accept-Ranges: bytes');
    header('Content-Length: ' . filesize($pathname));
    header('Content-Encoding: none');
    header('Content-Type: ' . mime_content_type($pathname));
    if ($isText) {
      header("Content-Type: text/{$extention}");
    }
    if ($forceDownload) {
      header("Content-Disposition: attachment; filename='{$filename}'");
      header("Content-Type: application/{$extention}");
    }
    return null;
  }

}
