<?php

namespace helionogueir\filecreator\output;

use Exception;
use helionogueir\languagepack\Lang;
use helionogueir\filecreator\autoload\LanguagePack;

/**
 * @author Helio Nogueira <helio.nogueir@gmail.com>
 * @version v1.0.0
 */
class ReadFile {

  private $pattern = "/^(.*)(\/|\\\\)(.*)\.(.*)$/i";

  /**
   * Read file and print
   * @param string $pathname File name to be read
   * @param bool $download Force download
   * @return null
   */
  public function read(string $pathname, bool $download = false) {
    $auth = false;
    if (!empty($pathname) && file_exists($pathname) && is_file($pathname)) {
      $filename = preg_replace($this->pattern, '$3', $pathname);
      $extention = preg_replace($this->pattern, '$4', $pathname);
      $this->setHeader($pathname, $filename, $extention, $download);
      ob_clean();
      flush();
      readfile($pathname);
      $auth = true;
    }
    // Exception
    if (!$auth) {
      Lang::addRoot(LanguagePack::PACKAGE, LanguagePack::PATH);
      throw new Exception(Lang::get('filecreator:upload:readfile:read', 'helionogueir/filecreator', Array("pathname" => $pathname)));
    }
    return null;
  }

  /**
   * Prepare herader file
   * @param string $extention Extention initials
   * @return null
   */
  private function setHeader(string $pathname, string $filename, string $extention, bool $download) {
    header('Content-Transfer-Encoding: binary');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s', filemtime($pathname)) . ' GMT');
    header('Accept-Ranges: bytes');
    header('Content-Length: ' . filesize($pathname));
    header('Content-Encoding: none');
    header('Content-Type: ' . mime_content_type($pathname));
    if (preg_match("/(htm|html|xhtml|js|css|json|xml|xsl|eot|svg|ttf|woff)/i", $pathname)) {
      header("Content-Type: text/{$extention}");
    }
    if ($download) {
      header("Content-Disposition: attachment; filename='{$filename}'");
      header("Content-Type: application/{$extention}");
    }
    return null;
  }

}
