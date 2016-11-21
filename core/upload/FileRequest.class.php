<?php

namespace helionogueir\filecreator\upload;

use Exception;
use helionogueir\languagepack\Lang;
use helionogueir\typeBoxing\type\String;
use helionogueir\typeBoxing\type\Boolean;
use helionogueir\typeBoxing\type\Integer;
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
   * @param helionogueir\typeBoxing\type\String $filename Name of file in $_FILE
   * @param helionogueir\typeBoxing\type\String $directoryDestiny
   * @param Array $extentions
   * @return helionogueir\typeBoxing\type\String Path the file storage
   */
  public function upload(String $filename, String $directoryDestiny, Array $extentions = Array()) {
    $filepath = null;
    if (!$filename->isEmpty() && !$directoryDestiny->isEmpty()) {
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
      Lang::addRoot(new String(\helionogueir\filecreator\autoload\LanguagePack::PACKAGE), new String(\helionogueir\filecreator\autoload\LanguagePack::PATH));
      throw new Exception(Lang::get(new String('filecreator:upload:save:notfound'), new String('helionogueir/filecreator')));
    }
    return new String($filepath);
  }

  /**
   * Prepara directory:
   * - Create folder of path
   * 
   * @param helionogueir\typeBoxing\type\String $directory Path of directory
   * @return helionogueir\typeBoxing\type\Boolean Info if path is create
   */
  private function prepareDirectory(String $directory) {
    $dir = new Create();
    return $dir->make($directory, new Integer($this->chmod));
  }

  /**
   * Move file:
   * - Move $_FILE to stotage
   * 
   * @param helionogueir\typeBoxing\type\String $filename Name of file in $_FILE
   * @param helionogueir\typeBoxing\type\String $directoryDestiny Path destiny of file
   * @return helionogueir\typeBoxing\type\String Path file uploaded
   */
  private function moveTempToStorage(String $filename, String $directoryDestiny) {
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
      Lang::addRoot(new String(\helionogueir\filecreator\autoload\LanguagePack::PACKAGE), new String(\helionogueir\filecreator\autoload\LanguagePack::PATH));
      throw new Exception(Lang::get(new String('filecreator:upload:save:moveTempStorage'), new String('filecreator')));
    }
    return new String($fileDestination);
  }

  /**
   * Check extentions:
   * - Check if extention is valid for upload
   * 
   * @param helionogueir\typeBoxing\type\String $filename Name of file in $_FILE
   * @param Array $extentions Valid extentions
   * @return helionogueir\typeBoxing\type\Boolean Info if extetion is valid
   */
  private function checkExtention(String $filename, Array $extentions) {
    $checked = true;
    if (count($extentions)) {
      if (isset($_FILES["{$filename}"], $_FILES["{$filename}"]['type'])) {
        $pattern = '/(' . implode(')|(', $extentions) . ')/i';
        $checked = preg_match($pattern, $_FILES["{$filename}"]['type']);
      }
    }
    return new Boolean($checked);
  }

  /**
   * Create name:
   * - Create name of the new file
   * 
   * @param helionogueir\typeBoxing\type\String $filename Name of file in $_FILE
   * @return helionogueir\typeBoxing\type\String Path with name of new file
   */
  private function createFilename(String $filename) {
    $name = null;
    if (isset($_FILES["{$filename}"], $_FILES["{$filename}"]['name']) && preg_match($this->pattern, $_FILES["{$filename}"]['name'])) {
      $extention = preg_replace($this->pattern, '$2', $_FILES["{$filename}"]['name']);
      $name = NameGenarator::uniqueName() . ".{$extention}";
    }
    // Exception
    if (empty($name)) {
      Lang::addRoot(new String(\helionogueir\filecreator\autoload\LanguagePack::PACKAGE), new String(\helionogueir\filecreator\autoload\LanguagePack::PATH));
      throw new Exception(Lang::get(new String('filecreator:upload:save:createFilename'), new String('filecreator')));
    }
    return new String($name);
  }

}
