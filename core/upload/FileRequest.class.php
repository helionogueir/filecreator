<?php

namespace helionogueir\filecreator\upload;

use Exception;
use helionogueir\languagepack\Lang;
use helionogueir\foldercreator\folder\Create;
use helionogueir\filecreator\tool\NameGenarator;

/**
 * Save file:
 * - Save file in storage;
 *
 * @author Helio Nogueira <helio.nogueir@gmail.com>
 * @version v1.0.0
 */
class FileRequest {

  private $pattern = '/^(.*)\.(.*)$/';
  private $chmod = 0777;

  /**
   * Contruct the basic of class
   * @return null
   */
  public function __construct() {
    return null;
  }

  /**
   * Mount file in stotage:
   * - Receive parameters and create file in storage
   * 
   * @param string $filename Name of file in $_FILE
   * @param string $directoryDestiny
   * @param Array $extentions
   * @return string Path the file storage
   */
  public function upload(string $filename, string $directoryDestiny, Array $extentions = Array()) {
    $filepath = null;
    if (!empty($filename) && !empty($directoryDestiny)) {
      $this->filename = $filename;
      $this->directoryDestiny = $directoryDestiny;
      if (count($extentions)) {
        $this->extentions = $extentions;
      }
      if ($this->prepareDirectory($directoryDestiny) && $this->checkExtention($filename, $extentions)) {
        if ($destination = $this->moveTempToStorage($filename, $directoryDestiny)) {
          @chmod($destination, $this->chmod);
          $filepath = "{$destination}";
        }
      }
    }
    // Exception
    if (empty($filepath)) {
      Lang::addRoot(\helionogueir\filecreator\autoload\LanguagePack::PACKAGE, \helionogueir\filecreator\autoload\LanguagePack::PATH);
      throw new Exception(Lang::get("filecreator:upload:save:notfound", 'helionogueir/filecreator'));
    }
    return $filepath;
  }

  /**
   * Prepara directory:
   * - Create folder of path
   * 
   * @param string $directory Path of directory
   * @return bool Info if path is create
   */
  private function prepareDirectory(string $directory) {
    $dir = new Create();
    return $dir->make($directory, $this->chmod);
  }

  /**
   * Move file:
   * - Move $_FILE to stotage
   * 
   * @param string $filename Name of file in $_FILE
   * @param string $directoryDestiny Path destiny of file
   * @return string Path file uploaded
   */
  private function moveTempToStorage(string $filename, string $directoryDestiny) {
    $fileDestination = null;
    if (isset($_FILES["{$filename}"], $_FILES["{$filename}"]['name'], $_FILES["{$filename}"]['type'], $_FILES["{$filename}"]['tmp_name'], $_FILES["{$filename}"]['error'])) {
      if (!(bool) $_FILES["{$filename}"]['error'] && is_uploaded_file($_FILES["{$filename}"]['tmp_name'])) {
        if ($destination = $directoryDestiny . DIRECTORY_SEPARATOR . $this->createFilename($filename)) {
          if (move_uploaded_file($_FILES["{$filename}"]['tmp_name'], $destination)) {
            $fileDestination = $destination;
          }
        }
      }
    }
    // Exception
    if (empty($fileDestination)) {
      Lang::addRoot(\helionogueir\filecreator\autoload\LanguagePack::PACKAGE, \helionogueir\filecreator\autoload\LanguagePack::PATH);
      throw new Exception(Lang::get("filecreator:upload:save:moveTempStorage", 'filecreator'));
    }
    return $fileDestination;
  }

  /**
   * Check extentions:
   * - Check if extention is valid for upload
   * 
   * @param string $filename Name of file in $_FILE
   * @param Array $extentions Valid extentions
   * @return bool Info if extetion is valid
   */
  private function checkExtention(string $filename, Array $extentions) {
    $checked = true;
    if (count($extentions)) {
      if (isset($_FILES["{$filename}"], $_FILES["{$filename}"]['type'])) {
        $pattern = '/(' . implode(')|(', $extentions) . ')/i';
        $checked = preg_match($pattern, $_FILES["{$filename}"]['type']);
      }
    }
    return $checked;
  }

  /**
   * Create name:
   * - Create name of the new file
   * 
   * @param string $filename Name of file in $_FILE
   * @return string Path with name of new file
   */
  private function createFilename(string $filename) {
    $name = null;
    if (isset($_FILES["{$filename}"], $_FILES["{$filename}"]['name']) && preg_match($this->pattern, $_FILES["{$filename}"]['name'])) {
      $extention = preg_replace($this->pattern, '$2', $_FILES["{$filename}"]['name']);
      $name = NameGenarator::uniqueName() . ".{$extention}";
    }
    // Exception
    if (empty($name)) {
      Lang::addRoot(\helionogueir\filecreator\autoload\LanguagePack::PACKAGE, \helionogueir\filecreator\autoload\LanguagePack::PATH);
      throw new Exception(Lang::get("filecreator:upload:save:createFilename", 'filecreator'));
    }
    return $name;
  }

}
